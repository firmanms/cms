<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Laravel\Sanctum\HasApiTokens;

class Profil extends Model
{
    use HasFactory, HasApiTokens;

    protected $guarded = [];

    protected $casts = [
        'seo_keywords' => 'array'
    ];

    public function idprofil(): BelongsTo
    {
        return $this->belongsTo(User::class, 'idprofil','idprofil');
    }

    public function agenda(): HasMany
    {
        return $this->hashMany(Agenda::class,'idprofil','id');
    }

    public function api(): HasMany
    {
        return $this->hashMany(Api::class,'idprofil','id');
    }

    public function banner(): HasMany
    {
        return $this->hashMany(Banner::class,'idprofil','id');
    }

    public function category(): HasMany
    {
        return $this->hashMany(Category::class,'idprofil','id');
    }

    public function tokenregen(): HasMany
    {
        return $this->hasMany(Tokengen::class, 'tokenable_id', 'id');
    }

    public function complaint(): HasMany
    {
        return $this->hashMany(Complaint::class,'idprofil','id');
    }

    public function employee(): HasMany
    {
        return $this->hashMany(Employee::class,'idprofil','id');
    }

    public function facilities(): HasMany
    {
        return $this->hashMany(Facilities::class,'idprofil','id');
    }

    public function faq(): HasMany
    {
        return $this->hashMany(Faq::class,'idprofil','id');
    }

    public function fileupload(): HasMany
    {
        return $this->hashMany(Fileupload::class,'idprofil','id');
    }

    public function galery(): HasMany
    {
        return $this->hashMany(Galery::class,'idprofil','id');
    }

    public function page(): HasMany
    {
        return $this->hashMany(Page::class,'idprofil','id');
    }

    public function post(): HasMany
    {
        return $this->hashMany(Post::class,'idprofil','id');
    }

    public function related(): HasMany
    {
        return $this->hashMany(Related::class,'idprofil','id');
    }

    public function service(): HasMany
    {
        return $this->hashMany(Service::class,'idprofil','id');
    }

    public function slide(): HasMany
    {
        return $this->hashMany(Slide::class,'idprofil','id');
    }

    public function widget(): HasMany
    {
        return $this->hashMany(Widget::class,'idprofil','id');
    }

    public function adjacency(): HasMany
    {
        return $this->hashMany(Adjacency::class,'idprofil','id');
    }

    
}
