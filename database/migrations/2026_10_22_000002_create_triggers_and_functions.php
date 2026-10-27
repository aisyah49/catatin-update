<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

/**
 * MIGRATION 2 — FUNCTION, VIEW, dan TRIGGER (khusus MySQL 8 / MariaDB 10.5+).
 *
 * Isi file ini:
 *  A. FUNCTION  : fn_modal_per_pcs, fn_laba_per_pcs, fn_total_modal_folder   (hitungan di sisi database)
 *  B. VIEW      : v_produk_laba                                              (memakai function di atas)
 *  C. TRIGGER   : validasi data (BEFORE) dan pencatatan riwayat otomatis (AFTER)
 *
 * Catatan penting:
 *  - SIGNAL SQLSTATE '45000' = menolak query dan membatalkan (ROLLBACK) perubahan pada statement itu.
 *  - Pencatatan riwayat bisa dimatikan sementara lewat variabel sesi:  SET @catatin_skip_log = 1;
 *    (dipakai saat "Urungkan" supaya pemulihan data tidak tercatat sebagai "Tambah" baru).
 *  - MySQL TIDAK menjalankan trigger untuk penghapusan akibat ON DELETE CASCADE, karena itu
 *    riwayat hapus folder dicatat di trigger BEFORE DELETE milik folders (lengkap dengan barangnya).
 */
return new class extends Migration
{
    public function up(): void
    {
        // ================= A. FUNCTION =================

        // Harga modal per pcs = harga beli per box / isi pcs per box. NULL bila isi box kosong/0.
        DB::unprepared('DROP FUNCTION IF EXISTS fn_modal_per_pcs');
        // [FUNCTION] fn_modal_per_pcs
        DB::unprepared("
            CREATE FUNCTION fn_modal_per_pcs(p_price BIGINT UNSIGNED, p_box_qty INT UNSIGNED)
            RETURNS DECIMAL(14,2)
            DETERMINISTIC
            BEGIN
                IF p_box_qty IS NULL OR p_box_qty = 0 THEN
                    RETURN NULL;           -- tidak bisa dihitung tanpa isi box
                END IF;
                RETURN ROUND(p_price / p_box_qty, 2);
            END
        ");

        // Laba per pcs = harga jual - modal per pcs.
        DB::unprepared('DROP FUNCTION IF EXISTS fn_laba_per_pcs');
        // [FUNCTION] fn_laba_per_pcs
        DB::unprepared("
            CREATE FUNCTION fn_laba_per_pcs(p_price BIGINT UNSIGNED, p_box_qty INT UNSIGNED, p_sell BIGINT UNSIGNED)
            RETURNS DECIMAL(14,2)
            DETERMINISTIC
            BEGIN
                RETURN p_sell - fn_modal_per_pcs(p_price, p_box_qty);   -- NULL bila modal tidak bisa dihitung
            END
        ");

        // Total harga beli semua barang dalam satu folder.
        DB::unprepared('DROP FUNCTION IF EXISTS fn_total_modal_folder');
        // [FUNCTION] fn_total_modal_folder
        DB::unprepared("
            CREATE FUNCTION fn_total_modal_folder(p_folder_id BIGINT UNSIGNED)
            RETURNS BIGINT UNSIGNED
            READS SQL DATA
            BEGIN
                RETURN (SELECT COALESCE(SUM(price), 0) FROM products WHERE folder_id = p_folder_id);
            END
        ");

        // ================= B. VIEW =================
        DB::unprepared('DROP VIEW IF EXISTS v_produk_laba');
        DB::unprepared("
            CREATE VIEW v_produk_laba AS
            SELECT p.id, p.folder_id, p.name, p.price, p.box_qty, p.selling_price,
                   fn_modal_per_pcs(p.price, p.box_qty)                    AS modal_per_pcs,
                   fn_laba_per_pcs(p.price, p.box_qty, p.selling_price)    AS laba_per_pcs
            FROM products p
        ");

        // ================= C. TRIGGER: VALIDASI (BEFORE) =================
        foreach (['trg_products_bi' => 'INSERT', 'trg_products_bu' => 'UPDATE'] as $name => $event) {
            DB::unprepared("DROP TRIGGER IF EXISTS $name");
            // Dijalankan SEBELUM barang disimpan. Data tidak valid -> ditolak.
            // [TRIGGER] validasi sebelum simpan (BEFORE INSERT/UPDATE): tolak data tidak valid dengan SIGNAL 45000
            DB::unprepared("
                CREATE TRIGGER $name BEFORE $event ON products FOR EACH ROW
                BEGIN
                    IF NEW.name IS NULL OR TRIM(NEW.name) = '' THEN
                        SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nama barang tidak boleh kosong';
                    END IF;
                    SET NEW.name = TRIM(NEW.name);   -- rapikan spasi di awal/akhir
                END
            ");
        }

        DB::unprepared('DROP TRIGGER IF EXISTS trg_folders_bi');
        DB::unprepared("
            CREATE TRIGGER trg_folders_bi BEFORE INSERT ON folders FOR EACH ROW
            BEGIN
                IF NEW.name IS NULL OR TRIM(NEW.name) = '' THEN
                    SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Nama folder tidak boleh kosong';
                END IF;
            END
        ");

        // ================= C. TRIGGER: RIWAYAT OTOMATIS (AFTER) =================
        // Pola yang sama untuk tiap tabel: setelah INSERT/UPDATE/DELETE, tulis satu baris ke `activities`.
        // Dibungkus IF agar bisa dimatikan lewat @catatin_skip_log.
        $skip = 'COALESCE(@catatin_skip_log, 0) = 0';

        // --- products ---
        $productJson = fn (string $r) => "JSON_OBJECT('id',$r.id,'folder_id',$r.folder_id,'date',$r.date,'name',$r.name,"
            . "'price',$r.price,'box_qty',$r.box_qty,'small_box_qty',$r.small_box_qty,"
            . "'selling_price',$r.selling_price,'photo',$r.photo)";

        // [TRIGGER] pencatat riwayat otomatis (AFTER INSERT/UPDATE/DELETE) untuk semua tabel
        $this->trigger('trg_products_ai', 'AFTER INSERT ON products', "
            IF $skip THEN
                INSERT INTO activities(type,entity,entity_id,entity_name) VALUES ('add','product',NEW.id,NEW.name);
            END IF;");
        $this->trigger('trg_products_au', 'AFTER UPDATE ON products', "
            IF $skip THEN
                INSERT INTO activities(type,entity,entity_id,entity_name) VALUES ('edit','product',NEW.id,NEW.name);
            END IF;");
        $this->trigger('trg_products_ad', 'AFTER DELETE ON products', "
            IF $skip THEN
                INSERT INTO activities(type,entity,entity_id,entity_name,snapshot)
                VALUES ('delete','product',OLD.id,OLD.name," . $productJson('OLD') . ");
            END IF;");

        // --- folders ---
        $this->trigger('trg_folders_ai', 'AFTER INSERT ON folders', "
            IF $skip THEN
                INSERT INTO activities(type,entity,entity_id,entity_name) VALUES ('add','folder',NEW.id,NEW.name);
            END IF;");
        $this->trigger('trg_folders_au', 'AFTER UPDATE ON folders', "
            IF $skip AND NOT (NEW.name <=> OLD.name) THEN   -- hanya bila nama berubah (membuka folder tidak dicatat)
                INSERT INTO activities(type,entity,entity_id,entity_name) VALUES ('edit','folder',NEW.id,NEW.name);
            END IF;");
        // BEFORE DELETE (bukan AFTER) supaya barang di dalam folder masih ada untuk disalin ke snapshot.
        $this->trigger('trg_folders_bd', 'BEFORE DELETE ON folders', "
            IF $skip THEN
                INSERT INTO activities(type,entity,entity_id,entity_name,snapshot)
                VALUES ('delete','folder',OLD.id,OLD.name,
                    JSON_OBJECT(
                        'folder', JSON_OBJECT('id',OLD.id,'name',OLD.name,'last_opened_at',OLD.last_opened_at,'created_at',OLD.created_at),
                        'products', COALESCE((SELECT JSON_ARRAYAGG(" . $productJson('p') . ") FROM products p WHERE p.folder_id = OLD.id), JSON_ARRAY())
                    ));
            END IF;");

        // --- memos ---
        $this->trigger('trg_memos_ai', 'AFTER INSERT ON memos', "
            IF $skip THEN
                INSERT INTO activities(type,entity,entity_id,entity_name) VALUES ('add','memo',NEW.id,NEW.title);
            END IF;");
        $this->trigger('trg_memos_au', 'AFTER UPDATE ON memos', "
            IF $skip THEN
                INSERT INTO activities(type,entity,entity_id,entity_name) VALUES ('edit','memo',NEW.id,NEW.title);
            END IF;");
        $this->trigger('trg_memos_ad', 'AFTER DELETE ON memos', "
            IF $skip THEN
                INSERT INTO activities(type,entity,entity_id,entity_name,snapshot)
                VALUES ('delete','memo',OLD.id,OLD.title,
                    JSON_OBJECT('id',OLD.id,'title',OLD.title,'date',OLD.date,'blocks',OLD.blocks,'from_sheet',OLD.from_sheet));
            END IF;");

        // --- sheets (tidak mencatat UPDATE karena autosave menyimpan tiap ketikan) ---
        $this->trigger('trg_sheets_ai', 'AFTER INSERT ON sheets', "
            IF $skip THEN
                INSERT INTO activities(type,entity,entity_id,entity_name) VALUES ('add','sheet',NEW.id,NEW.name);
            END IF;");
        $this->trigger('trg_sheets_ad', 'AFTER DELETE ON sheets', "
            IF $skip THEN
                INSERT INTO activities(type,entity,entity_id,entity_name) VALUES ('delete','sheet',OLD.id,OLD.name);
            END IF;");

        // --- activities: riwayat tidak boleh diubah/dihapus manual selain kolom `undone` ---
        $this->trigger('trg_activities_bu', 'BEFORE UPDATE ON activities', "
            IF NEW.type <> OLD.type OR NEW.entity <> OLD.entity OR NOT (NEW.entity_id <=> OLD.entity_id) THEN
                SIGNAL SQLSTATE '45000' SET MESSAGE_TEXT = 'Riwayat tidak boleh diubah (hanya status undone)';
            END IF;");
    }

    public function down(): void
    {
        foreach ([
            'trg_products_bi', 'trg_products_bu', 'trg_products_ai', 'trg_products_au', 'trg_products_ad',
            'trg_folders_bi', 'trg_folders_ai', 'trg_folders_au', 'trg_folders_bd',
            'trg_memos_ai', 'trg_memos_au', 'trg_memos_ad', 'trg_sheets_ai', 'trg_sheets_ad', 'trg_activities_bu',
        ] as $t) {
            DB::unprepared("DROP TRIGGER IF EXISTS $t");
        }
        DB::unprepared('DROP VIEW IF EXISTS v_produk_laba');
        foreach (['fn_laba_per_pcs', 'fn_modal_per_pcs', 'fn_total_modal_folder'] as $f) {
            DB::unprepared("DROP FUNCTION IF EXISTS $f");
        }
    }

    /** Helper: buat satu trigger (hapus dulu bila sudah ada). */
    private function trigger(string $name, string $when, string $body): void
    {
        DB::unprepared("DROP TRIGGER IF EXISTS $name");
        DB::unprepared("CREATE TRIGGER $name $when FOR EACH ROW BEGIN $body END");
    }
};
