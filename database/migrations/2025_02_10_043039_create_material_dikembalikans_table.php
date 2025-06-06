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
        Schema::create('material_dikembalikans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('pekerjaan_id');
            $table->unsignedBigInteger('material_id');
            $table->integer('jumlah');
            $table->timestamps();
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaans')->onDelete('cascade');
            $table->foreign('material_id')->references('id')->on('materials')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('material_dikembalikans');
    }
};
