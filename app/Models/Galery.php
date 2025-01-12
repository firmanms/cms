<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Galery extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'image_gallery' => 'array',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'iduser','id');
    }

    public function profil()
{
    return $this->belongsTo(Profil::class, 'idprofil');
}
}
