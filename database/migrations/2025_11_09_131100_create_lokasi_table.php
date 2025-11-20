<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
       Schema::create('lokasi', function (Blueprint $table) {
            $table->id('id_lokasi');
            $table->foreignId('id_mitra')->constrained('mitra','id_mitra')->onDelete('cascade');
            $table->string('nama_lokasi')->nullable();
            $table->string('path_area')->nullable();
            $table->string('deskripsi')->nullable();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi');
    }
};
