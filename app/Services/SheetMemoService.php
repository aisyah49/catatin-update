<?php

namespace App\Services;

use App\Models\Memo;
use App\Models\Sheet;
use App\Support\DbGuard;

/**
 * "Salin ke Memo": mengubah Tabel menjadi blok tabel di Memo baru.
 * Memo hanya salinan (tidak tersambung ke Tabel), sama seperti di aplikasi HTML.
 * Dibungkus transaksi supaya memo tidak setengah jadi bila ada error di tengah.
 */
class SheetMemoService
{
    public function copy(Sheet $sheet): Memo
    {
        return DbGuard::tx(function () use ($sheet) {
            $cells = $sheet->cells ?? [];
            $header = [];
            for ($c = 0; $c < $sheet->cols; $c++) {
                $header[] = (string) ($cells["0_$c"] ?? '');
            }
            $rows = [];
            for ($r = 1; $r < $sheet->rows; $r++) {
                $row = [];
                for ($c = 0; $c < $sheet->cols; $c++) {
                    $row[] = (string) ($cells["{$r}_$c"] ?? '');
                }
                $rows[] = $row;
            }

            return Memo::create([
                'title'      => 'Tabel: ' . $sheet->name,
                'date'       => now()->toDateString(),
                'blocks'     => [['type' => 'table', 'header' => $header, 'rows' => $rows, 'rich' => true]],
                'from_sheet' => ['id' => $sheet->id, 'name' => $sheet->name],
            ]);
        });
    }
}
