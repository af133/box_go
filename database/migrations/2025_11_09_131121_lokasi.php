<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('lokasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mitra')->constrained('mitra')->onDelete('cascade');
            $table->string('nama_tempat');
            $table->text('alamat');
            $table->geometry('area'); // Polygon
            $table->foreignId('id_gambar_area')->constrained('gambar_area')->onDelete('cascade');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('lokasi');
    }
};
