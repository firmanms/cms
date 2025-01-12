<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable, HasRoles, HasApiTokens;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'idprofil',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    public function idprofil()
    {
        return $this->hasOne(Profil::class, 'idprofil','idprofil');
    }

    public function agenda(): HasMany
    {
        return $this->hashMany(Agenda::class,'iduser','id');
    }

    public function api(): HasMany
    {
        return $this->hashMany(Api::class,'iduser','id');
    }

    public function banner(): HasMany
    {
        return $this->hashMany(Banner::class,'iduser','id');
    }

    public function category(): HasMany
    {
        return $this->hashMany(Category::class,'iduser','id');
    }

    public function complaint(): HasMany
    {
        return $this->hashMany(Complaint::class,'iduser','id');
    }

    public function employee(): HasMany
    {
        return $this->hashMany(Employee::class,'iduser','id');
    }

    public function facilities(): HasMany
    {
        return $this->hashMany(Facilities::class,'iduser','id');
    }

    public function faq(): HasMany
    {
        return $this->hashMany(Faq::class,'iduser','id');
    }

    public function fileupload(): HasMany
    {
        return $this->hashMany(Fileupload::class,'iduser','id');
    }

    public function galery(): HasMany
    {
        return $this->hashMany(Galery::class,'iduser','id');
    }

    public function page(): HasMany
    {
        return $this->hashMany(Page::class,'iduser','id');
    }

    public function post(): HasMany
    {
        return $this->hashMany(Post::class,'iduser','id');
    }

    public function related(): HasMany
    {
        return $this->hashMany(Related::class,'iduser','id');
    }

    public function service(): HasMany
    {
        return $this->hashMany(Service::class,'iduser','id');
    }

    public function slide(): HasMany
    {
        return $this->hashMany(Slide::class,'iduser','id');
    }

    public function widget(): HasMany
    {
        return $this->hashMany(Widget::class,'iduser','id');
    }
}
