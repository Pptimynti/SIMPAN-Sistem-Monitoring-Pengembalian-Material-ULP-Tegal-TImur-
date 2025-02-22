<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Material extends Model
{
    protected $fillable = ['nama', 'satuan'];

    
    public function materialBekas(): HasMany
    {
        return $this->hasMany(MaterialBekas::class);
    }

    public function materialDikembalikans(): HasMany
    {
        return $this->hasMany(MaterialDikembalikan::class);
    }
}
