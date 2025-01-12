<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Facilities extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'maklumat' => 'array',
        'visi' => 'array',
        'misi' => 'array',
        'motto' => 'array',
        'kode_etik' => 'array',
        'tata_tertib' => 'array',
        'si_pelayanan_publik' => 'array',
        'ruang_tunggu' => 'array',
        'meja_layanan' => 'array',
        'parkir' => 'array',
        'tempat_ibadah' => 'array',
        'charger' => 'array',
        'pojok_baca' => 'array',
        'toilet' => 'array',
        'petunjuk_layanan_khusus' => 'array',
        'petunjuk_tanda' => 'array',
        'narator' => 'array',
        'huruf_braile' => 'array',
        'kursi_roda' => 'array',
        'rambatan' => 'array',
        'laktasi' => 'array',
        'toilet_disabilitas' => 'array',
        'kursi_prioritas' => 'array',
        'parkir_khusus' => 'array',
        'tempat_main' => 'array',
        'lantai_pemandu' => 'array',
        'apar' => 'array',
        'jalur_evakuasi' => 'array',
        'cctv' => 'array',
        'petugas_keamanan' => 'array',
        'titik_kumpul' => 'array',
        'ruang_arsip' => 'array',
        'red_button' => 'array',
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
