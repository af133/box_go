<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('gambar_area', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_lokasi')->constrained('lokasi')->onDelete('cascade');
            $table->string('path_gambar');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('gambar_area');
    }
};
