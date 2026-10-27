<?php

namespace Database\Seeders;

use App\Models\Folder;
use App\Models\Memo;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/** Data contoh yang sama dengan aplikasi HTML. Dijalankan dalam satu transaksi. */
class CatatinSeeder extends Seeder
{
    public function run(): void
    {
        // [TRANSAKSI] semua data contoh masuk bersamaan; gagal di tengah -> [ROLLBACK], sukses -> [COMMIT]
        DB::transaction(function () {
            $f1 = Folder::create(['name' => '02 November 2023']);
            $f2 = Folder::create(['name' => '08 Desember 2023', 'last_opened_at' => now()]);

            $f1->products()->create(['date' => '2023-11-02', 'name' => 'Milku', 'price' => 70000, 'box_qty' => 24, 'small_box_qty' => 6, 'selling_price' => 3000]);
            $f1->products()->create(['date' => '2023-11-02', 'name' => 'Floridina', 'price' => 29000, 'box_qty' => 24, 'small_box_qty' => 6, 'selling_price' => 2500]);
            $f2->products()->create(['date' => '2023-12-08', 'name' => 'Teh Pucuk', 'price' => 48000, 'box_qty' => 24, 'small_box_qty' => 1, 'selling_price' => 4000]);

            Memo::create([
                'title'  => 'Harga Supplier',
                'date'   => now()->toDateString(),
                'blocks' => [['type' => 'text', 'html' => 'Cek kembali harga barang dari supplier minggu depan.']],
            ]);
        });
    }
}
