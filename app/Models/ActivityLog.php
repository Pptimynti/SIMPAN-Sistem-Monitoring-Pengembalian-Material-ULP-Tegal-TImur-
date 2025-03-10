<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ActivityLog extends Model
{
    protected $fillable = ['user_id', 'aktivitas', 'deskripsi', 'jumlah', 'material', 'pekerjaan_id', 'material_bekas_id'];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function materialBekas(): BelongsTo
    {
        return $this->belongsTo(MaterialBekas::class);
    }

    public function pekerjaan(): BelongsTo
    {
        return $this->belongsTo(Pekerjaan::class);
    }
}
