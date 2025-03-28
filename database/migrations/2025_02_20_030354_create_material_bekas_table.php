<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('material_bekas', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_id');
            $table->integer('stok_tersedia');
            $table->integer('telah_digunakan')->nullable()->default(0);
            $table->integer('stok_manual')->nullable()->default(0);
            $table->timestamps();
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_bekas');
    }
};
