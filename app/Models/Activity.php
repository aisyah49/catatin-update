<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;

/**
 * Riwayat perubahan. Baris dibuat oleh TRIGGER database, bukan oleh PHP,
 * jadi tidak ada kolom updated_at dan model ini hanya dipakai untuk membaca.
 */
class Activity extends Model
{
    use BelongsToUser;

    public $timestamps = false;
    protected $guarded = [];
    protected $casts = ['snapshot' => 'array', 'undone' => 'boolean', 'created_at' => 'datetime'];
}
