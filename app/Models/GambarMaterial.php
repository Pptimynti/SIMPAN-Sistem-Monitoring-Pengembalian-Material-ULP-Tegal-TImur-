<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class GambarMaterial extends Model
{
    protected $fillable = ['material_dikembalikan_id', 'gambar'];

    public function materialDikembalikan(): BelongsTo
    {
        return $this->belongsTo(MaterialDikembalikan::class);
    }
}
