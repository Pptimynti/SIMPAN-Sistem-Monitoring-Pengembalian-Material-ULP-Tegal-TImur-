<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MaterialBekas extends Model
{
    protected $fillable = ['material_id', 'stok_tersedia', 'telah_digunakan', 'stok_manual'];

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class)->withTrashed();
    }
}
