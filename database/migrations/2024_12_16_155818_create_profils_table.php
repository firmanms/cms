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
        Schema::create('profils', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug');
            $table->string('leader_name')->nullable();
            $table->string('leader_foto')->nullable();
            $table->longText('welcome')->nullable();
            $table->longText('overview')->nullable();
            $table->longText('maintask')->nullable();
            $table->string('video_profile')->nullable();
            $table->string('office_name')->nullable();
            $table->string('office_address')->nullable();
            $table->longText('url_maps')->nullable();
            $table->string('office_telp')->nullable();
            $table->string('office_whatsapp')->nullable();
            $table->string('office_email')->nullable();
            $table->string('open_hour')->nullable();
            $table->string('seo_desc')->nullable();
            $table->string('seo_keywords')->nullable();
            $table->string('fb')->nullable();
            $table->string('ig')->nullable();
            $table->string('tw')->nullable();
            $table->string('channel_yt')->nullable();
            $table->string('tiktok')->nullable();
            $table->string('logo')->nullable();
            $table->string('favicon')->nullable();
            $table->string('nickname')->nullable();
            $table->string('status')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('profils');
    }
};
