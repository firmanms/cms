<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('facilities', function (Blueprint $table) {
            $table->id();
            $table->integer('iduser');
            $table->integer('idprofil');
            $table->longText('maklumat')->nullable();
            $table->longText('visi')->nullable();
            $table->longText('misi')->nullable();
            $table->longText('motto')->nullable();
            $table->longText('kode_etik')->nullable();
            $table->longText('tata_tertib')->nullable();
            $table->longText('si_pelayanan_publik')->nullable();
            $table->longText('ruang_tunggu')->nullable();
            $table->longText('meja_layanan')->nullable();
            $table->longText('parkir')->nullable();
            $table->longText('tempat_ibadah')->nullable();
            $table->longText('charger')->nullable();
            $table->longText('pojok_baca')->nullable();
            $table->longText('toilet')->nullable();
            $table->longText('petunjuk_layanan_khusus')->nullable();
            $table->longText('petunjuk_tanda')->nullable();
            $table->longText('narator')->nullable();
            $table->longText('huruf_braile')->nullable();
            $table->longText('kursi_roda')->nullable();
            $table->longText('rambatan')->nullable();
            $table->longText('laktasi')->nullable();
            $table->longText('toilet_disabilitas')->nullable();
            $table->longText('kursi_prioritas')->nullable();
            $table->longText('parkir_khusus')->nullable();
            $table->longText('tempat_main')->nullable();
            $table->longText('lantai_pemandu')->nullable();
            $table->longText('apar')->nullable();
            $table->longText('jalur_evakuasi')->nullable();
            $table->longText('cctv')->nullable();
            $table->longText('petugas_keamanan')->nullable();
            $table->longText('titik_kumpul')->nullable();
            $table->longText('ruang_arsip')->nullable();
            $table->longText('red_button')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('facilities');
    }
};
