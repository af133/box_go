<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('pelanggan', function (Blueprint $table) {
            $table->id('id_pelanggan');
            $table->foreignId('id_email')->constrained('email','id_email')->onDelete('cascade');
            $table->string('nama');
            $table->string('path_profil');
            $table->text('alamat')->nullable();
            $table->string('nomor_hp', 20);
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('pelanggan');
    }
};
