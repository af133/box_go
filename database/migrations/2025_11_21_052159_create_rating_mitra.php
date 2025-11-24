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
        Schema::create('rating_mitra', function (Blueprint $table) {
            $table->id('id_rating_mitra');
            $table->unsignedBigInteger('id_lokasi');
            $table->unsignedBigInteger('id_pelanggan')->nullable();
            $table->integer('rating');
            $table->text('review')->nullable();
            $table->timestamps();

            $table->foreign('id_lokasi')->references('id_lokasi')->on('lokasi')->onDelete('cascade');
            $table->foreign('id_pelanggan')->references('id_pelanggan')->on('pelanggan')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rating_mitra');
    }
};
