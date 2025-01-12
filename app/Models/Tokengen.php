<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Tokengen extends Model
{
    use HasFactory;

    protected $table ='personal_access_tokens';

    protected $guarded = [];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'iduser','id');
    }

    public function profil()
    {
        return $this->belongsTo(Profil::class, 'tokenable_id');
    }
}
