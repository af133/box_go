<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('item_order', function (Blueprint $table) {
            $table->id('id_item_order');
            $table->foreignId('id_order')->constrained('orders','id_order')->onDelete('cascade');
            $table->foreignId('id_jenis_barang')->constrained('jenis_barang','id_jenis_barang')->onDelete('cascade');
            $table->integer('harga_saat_order');
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('item_order');
    }
};
