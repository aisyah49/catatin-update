<?php

namespace App\Support;

use Illuminate\Support\Facades\DB;

/**
 * Semua TRIGGER Catatin dalam satu tempat (versi 2: riwayat ikut mencatat user_id pemilik data).
 * Dipanggil oleh migration 2026_10_26_000001_add_login_and_unique_ids. Aman dijalankan berulang
 * (setiap trigger di-DROP dulu lalu dibuat ulang).
 */
class CatatinTriggers
{
    public static function install(): void
    {
        // ---- A. TRIGGER VALIDASI (BEFORE) ----
        foreach (['trg_products_bi' => 'INSERT', 'trg_products_bu' => 'UPDATE'] as $name => $event) {
            self::make($name, "BEFORE $event ON products", "
                IF NEW.name IS NULL OR TRIM(NEW.name) = '' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nama barang tidak boleh kosong';
                END IF;
                SET NEW.name = TRIM(NEW.name);");
        }
        self::make('trg_folders_bi', 'BEFORE INSERT ON folders', "
            IF NEW.name IS NULL OR TRIM(NEW.name) = '' THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nama folder tidak boleh kosong';
            END IF;");

        // ---- B. TRIGGER RIWAYAT OTOMATIS (AFTER) ----
        // Dibungkus IF agar bisa dimatikan lewat @catatin_skip_log. Kolom user_id disalin dari baris datanya.
        $skip = 'COALESCE(@catatin_skip_log, 0) = 0';
        $productJson = fn (string $r) => "JSON_OBJECT('id',$r.id,'folder_id',$r.folder_id,'date',$r.date,'name',$r.name,"
            . "'price',$r.price,'box_qty',$r.box_qty,'small_box_qty',$r.small_box_qty,"
            . "'selling_price',$r.selling_price,'photo',$r.photo)";

        // products
        self::make('trg_products_ai', 'AFTER INSERT ON products', "
            IF $skip THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name) VALUES (NEW.user_id,'add','product',NEW.id,NEW.name);
            END IF;");
        self::make('trg_products_au', 'AFTER UPDATE ON products', "
            IF $skip THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name) VALUES (NEW.user_id,'edit','product',NEW.id,NEW.name);
            END IF;");
        self::make('trg_products_ad', 'AFTER DELETE ON products', "
            IF $skip THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name,snapshot)
                VALUES (OLD.user_id,'delete','product',OLD.id,OLD.name," . $productJson('OLD') . ");
            END IF;");

        // folders
        self::make('trg_folders_ai', 'AFTER INSERT ON folders', "
            IF $skip THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name) VALUES (NEW.user_id,'add','folder',NEW.id,NEW.name);
            END IF;");
        self::make('trg_folders_au', 'AFTER UPDATE ON folders', "
            IF $skip AND NOT (NEW.name <=> OLD.name) THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name) VALUES (NEW.user_id,'edit','folder',NEW.id,NEW.name);
            END IF;");
        // BEFORE DELETE supaya barang di dalam folder masih ada untuk disalin ke snapshot.
        self::make('trg_folders_bd', 'BEFORE DELETE ON folders', "
            IF $skip THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name,snapshot)
                VALUES (OLD.user_id,'delete','folder',OLD.id,OLD.name,
                    JSON_OBJECT(
                        'folder', JSON_OBJECT('id',OLD.id,'name',OLD.name,'last_opened_at',OLD.last_opened_at,'created_at',OLD.created_at),
                        'products', COALESCE((SELECT JSON_ARRAYAGG(" . $productJson('p') . ") FROM products p WHERE p.folder_id = OLD.id), JSON_ARRAY())
                    ));
            END IF;");

        // memos
        self::make('trg_memos_ai', 'AFTER INSERT ON memos', "
            IF $skip THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name) VALUES (NEW.user_id,'add','memo',NEW.id,NEW.title);
            END IF;");
        self::make('trg_memos_au', 'AFTER UPDATE ON memos', "
            IF $skip THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name) VALUES (NEW.user_id,'edit','memo',NEW.id,NEW.title);
            END IF;");
        self::make('trg_memos_ad', 'AFTER DELETE ON memos', "
            IF $skip THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name,snapshot)
                VALUES (OLD.user_id,'delete','memo',OLD.id,OLD.title,
                    JSON_OBJECT('id',OLD.id,'title',OLD.title,'date',OLD.date,'blocks',OLD.blocks,'from_sheet',OLD.from_sheet));
            END IF;");

        // sheets (UPDATE tidak dicatat karena autosave menyimpan tiap ketikan)
        self::make('trg_sheets_ai', 'AFTER INSERT ON sheets', "
            IF $skip THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name) VALUES (NEW.user_id,'add','sheet',NEW.id,NEW.name);
            END IF;");
        self::make('trg_sheets_ad', 'AFTER DELETE ON sheets', "
            IF $skip THEN
                INSERT INTO activities(user_id,type,entity,entity_id,entity_name) VALUES (OLD.user_id,'delete','sheet',OLD.id,OLD.name);
            END IF;");

        // activities: riwayat tidak boleh diubah selain kolom `undone` (dan user_id saat data lama diklaim)
        self::make('trg_activities_bu', 'BEFORE UPDATE ON activities', "
            IF NEW.type <> OLD.type OR NEW.entity <> OLD.entity OR NOT (NEW.entity_id <=> OLD.entity_id) THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Riwayat tidak boleh diubah (hanya status undone)';
            END IF;");
    }

    private static function make(string $name, string $when, string $body): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS $name");
        DB::unprepared("CREATE TRIGGER $name $when FOR EACH ROW BEGIN $body END");
    }
}
