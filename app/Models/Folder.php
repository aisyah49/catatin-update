<?php

namespace App\Models;

use App\Models\Concerns\BelongsToUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

/** Folder belanja. Punya banyak Product (dihapus ikut folder lewat FK cascade). */
class Folder extends Model
{
    use BelongsToUser;

    protected $guarded = [];
    protected $casts = ['last_opened_at' => 'datetime'];

    public function products(): HasMany
    {
        return $this->hasMany(Product::class);
    }
}
