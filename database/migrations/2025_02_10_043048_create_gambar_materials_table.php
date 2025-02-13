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
        Schema::create('gambar_materials', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('material_dikembalikan_id');
            $table->string('gambar');
            $table->timestamps();
            $table->foreign('material_dikembalikan_id')->references('id')->on('material_dikembalikans')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('gambar_materials');
    }
};
