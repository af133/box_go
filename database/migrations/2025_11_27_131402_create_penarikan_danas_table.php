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
        Schema::create('penarikan_danas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_mitra')->constrained('mitra','id_mitra')->onDelete('cascade');
            $table->date('tanggal_penarikan');
            $table->integer('jumlah_penarikan');
            $table->text('alasan_penarikan')->nullable();
            $table->enum('status', ['pending', 'Diterima', 'Ditolak'])->default('pending');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penarikan_danas');
    }
};
