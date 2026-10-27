<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

/** Memo bergaya dokumen: `blocks` berisi daftar blok teks/tabel/checklist/foto. */
class Memo extends Model
{
    use BelongsToUser;

    protected $guarded = [];
    protected $casts = ['date' => 'date:Y-m-d', 'blocks' => 'array', 'from_sheet' => 'array'];
}
