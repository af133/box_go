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
        Schema::create('area_gudang', function (Blueprint $table) {
            $table->id('id_area');
             $table->foreignId('id_polygon')->constrained('polygon','id_polygon')->onDelete('cascade');
             $table->foreignId('id_lokasi')->constrained('lokasi','id_lokasi')->onDelete('cascade');
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
