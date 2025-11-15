<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('chat', function (Blueprint $table) {
            $table->id('id_chat');
            $table->foreignId('id_mitra')->nullable()->constrained('mitra','id_mitra')->onDelete('cascade');
            $table->foreignId('id_pelanggan')->nullable()->constrained('pelanggan','id_pelanggan')->onDelete('cascade');
            $table->text('pesan');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('chat');
    }
};
