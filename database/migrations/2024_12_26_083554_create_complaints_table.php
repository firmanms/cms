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
        Schema::create('complaints', function (Blueprint $table) {
            $table->id();
            $table->integer('iduser');
            $table->integer('idprofil');
            $table->string('kotak')->nullable();
            $table->string('lapor')->nullable();
            $table->string('fax')->nullable();
            $table->string('telp')->nullable();
            $table->string('wa')->nullable();
            $table->string('email')->nullable();
            $table->string('fb')->nullable();
            $table->string('link_fb')->nullable();
            $table->string('tw')->nullable();
            $table->string('link_tw')->nullable();
            $table->string('ig')->nullable();
            $table->string('link_ig')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('link_tiktok')->nullable();
            $table->text('jangka_waktu')->nullable();
            $table->text('pengelola')->nullable();
            $table->text('prosedur')->nullable();
            $table->longText('image')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('complaints');
    }
};
