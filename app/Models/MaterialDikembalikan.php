<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterialDikembalikan extends Model
{
    protected $table = 'material_dikembalikans';

    protected $fillable = ['pekerjaan_id', 'nama', 'jumlah'];

    public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class);
    }

    public function gambarMaterials(): HasMany
    {
        return $this->hasMany(GambarMaterial::class);
    }
}
