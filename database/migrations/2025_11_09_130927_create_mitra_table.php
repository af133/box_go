<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('mitra', function (Blueprint $table) {
            $table->id('id_mitra');
            $table->foreignId('id_email')->constrained('email','id_email')->onDelete('cascade');
            $table->string('nama');
            $table->text('path_profil')->nullable();
            $table->text('alamat');
            $table->string('nomor_hp', 20)->nullable();
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('mitra');
    }
};
