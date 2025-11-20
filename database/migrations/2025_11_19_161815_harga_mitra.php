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
         Schema::create('harga_mitra', function (Blueprint $table) {
            $table->id('harga_mitra');
            $table->foreignId('id_mitra')->constrained('mitra','id_mitra')->onDelete('cascade');
            $table->foreignId('id_jenis_barang')->constrained('jenis_barang','id_jenis_barang')->onDelete('cascade');
            $table->integer('harga_sewa');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};
