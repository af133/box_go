<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('order', function (Blueprint $table) {
            $table->id('id_order');
            $table->foreignId('id_pelanggan')->constrained('pelanggan','id_pelanggan')->onDelete('cascade');
            $table->string('path_gambar')->nullable();
            $table->foreignId('id_jenis_barang')->constrained('jenis_barang','id_jenis_barang')->onDelete('cascade');
            $table->date('tanggal_penitipan');
            $table->foreignId('id_lokasi')->constrained('lokasi','id_lokasi')->onDelete('cascade');
            $table->date('tanggal_pengambilan');
            $table->enum('status', ['pending','diterima', 'tidak'])->default('pending');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('order');
    }
};
