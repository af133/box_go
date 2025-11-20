<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->id('id_admin');
            $table->foreignId('id_email')->constrained('email','id_email')->onDelete('cascade');
            $table->timestamps();
        });

    }

    public function down(): void
    {
        Schema::dropIfExists('admin');
    }
};
