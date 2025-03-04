<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Laravel\Sanctum\HasApiTokens;

class Post extends Model
{
    use HasFactory,HasApiTokens;

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'iduser','id');
    }

    public function profil()
{
    return $this->belongsTo(Profil::class, 'idprofil');
}

    public function categories(): BelongsTo
    {
        return $this->belongsTo(Category::class,'idkategori');
    }
}
