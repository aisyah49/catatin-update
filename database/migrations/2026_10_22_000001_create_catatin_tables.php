<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * MIGRATION 1 — Membuat tabel utama.
 * Padanan dari "object store" IndexedDB di aplikasi HTML lama:
 *   folders, products, memos, sheets, activity  ->  folders, products, memos, sheets, activities
 */
return new class extends Migration
{
    public function up(): void
    {
        // Folder = kumpulan barang per tanggal belanja (contoh: "08 Desember 2023").
        Schema::create('folders', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->timestamp('last_opened_at')->nullable();   // dipakai kartu "Terakhir Dibuka"
            $t->timestamps();
        });

        // Barang. Dihapus otomatis bila foldernya dihapus (ON DELETE CASCADE).
        Schema::create('products', function (Blueprint $t) {
            $t->id();
            $t->foreignId('folder_id')->constrained('folders')->cascadeOnDelete();
            $t->date('date');
            $t->string('name');
            $t->unsignedBigInteger('price')->default(0);          // harga beli per box (Rupiah, tanpa desimal)
            $t->unsignedInteger('box_qty')->nullable();           // isi pcs per box
            $t->unsignedInteger('small_box_qty')->nullable();     // isi box kecil
            $t->unsignedBigInteger('selling_price')->default(0);  // harga jual per pcs
            $t->longText('photo')->nullable();                    // foto barang (data URL)
            $t->timestamps();
            $t->index(['folder_id', 'date']);
            $t->index('name');
        });

        // Memo. Isi memo berbentuk "blok" (teks, tabel, checklist, foto) -> disimpan sebagai JSON.
        Schema::create('memos', function (Blueprint $t) {
            $t->id();
            $t->string('title')->default('');
            $t->date('date');
            $t->json('blocks')->nullable();       // [{type:'text',html:..},{type:'table',..},{type:'image',..}]
            $t->json('from_sheet')->nullable();   // {id,name} bila memo adalah salinan dari Tabel
            $t->timestamps();
        });

        // Tabel (spreadsheet). Sel, format, dan foto sel disimpan sebagai JSON.
        Schema::create('sheets', function (Blueprint $t) {
            $t->id();
            $t->string('name');
            $t->unsignedSmallInteger('rows')->default(8);
            $t->unsignedSmallInteger('cols')->default(6);
            $t->json('cells')->nullable();    // {"0_0":"Halo","2_0":"=SUM(A1:A2)"}
            $t->json('fmt')->nullable();      // format per sel: tebal, warna, Rupiah, foto, dll.
            $t->json('imgs')->nullable();     // {idFoto: dataURL}
            $t->json('filter')->nullable();   // status filter & sortir kolom
            $t->timestamps();
        });

        // Riwayat perubahan. Diisi OTOMATIS oleh TRIGGER (lihat migration 2), bukan oleh kode PHP.
        Schema::create('activities', function (Blueprint $t) {
            $t->id();
            $t->enum('type', ['add', 'edit', 'delete']);
            $t->string('entity', 20);                  // folder | product | memo | sheet
            $t->unsignedBigInteger('entity_id')->nullable();
            $t->string('entity_name')->nullable();
            $t->json('snapshot')->nullable();          // salinan data saat dihapus -> dasar tombol "Urungkan"
            $t->boolean('undone')->default(false);
            $t->timestamp('created_at')->useCurrent();
            $t->index(['created_at']);
            $t->index(['entity', 'entity_id']);
        });
    }

    public function down(): void
    {
        foreach (['activities', 'sheets', 'memos', 'products', 'folders'] as $table) {
            Schema::dropIfExists($table);
        }
    }
};
