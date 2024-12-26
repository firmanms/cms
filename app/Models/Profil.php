<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Profil extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'seo_keywords' => 'array'
    ];

    public function idprofil(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idprofil','idprofil');
    }

    
}
