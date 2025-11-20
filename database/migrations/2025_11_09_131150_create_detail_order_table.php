<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('detail_order', function (Blueprint $table) {
            $table->id('id_detail');
            $table->foreignId('id_order')->constrained('order','id_order')->onDelete('cascade');
            $table->foreignId('id_mitra')->constrained('mitra','id_mitra')->onDelete('cascade');
            $table->string('path_pembayaran')->nullable();
            $table->enum('status', ['pending', 'terkonfirmasi','telah diambil','dititipkan'])->default('pending');

        });

    }

    public function down(): void
    {
        Schema::dropIfExists('detail_order');
    }
};
