<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

/** Tabel (spreadsheet). cells/fmt/imgs/filter disimpan sebagai JSON. */
class Sheet extends Model
{
    use BelongsToUser;

    protected $guarded = [];
    protected $casts = ['cells' => 'array', 'fmt' => 'array', 'imgs' => 'array', 'filter' => 'array'];
}
