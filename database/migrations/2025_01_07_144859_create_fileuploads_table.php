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
        Schema::create('fileuploads', function (Blueprint $table) {
            $table->id();            
            $table->integer('iduser');
            $table->integer('idprofil');
            $table->string('title');
            $table->mediumText('url');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fileuploads');
    }
};
