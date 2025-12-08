<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id('id_order');
            $table->foreignId('id_pelanggan')->constrained('pelanggan','id_pelanggan')->onDelete('cascade');
            $table->string('path_gambar')->nullable();
            $table->foreignId('id_lokasi')->constrained('lokasi','id_lokasi')->onDelete('cascade');
            $table->date('tanggal_pengambilan');
            $table->date('tanggal_penitipan');
            $table->string('path_pembayaran')->nullable();
            $table->enum('status', ['pending','Diterima', 'Ditolak'])->default('pending');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
