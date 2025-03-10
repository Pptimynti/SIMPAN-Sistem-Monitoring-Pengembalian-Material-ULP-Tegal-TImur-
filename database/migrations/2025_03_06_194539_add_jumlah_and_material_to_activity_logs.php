<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use function Laravel\Prompts\table;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            $table->integer('jumlah')->nullable()->default(0);
            $table->unsignedBigInteger('material_bekas_id')->nullable();
            $table->unsignedBigInteger('pekerjaan_id')->nullable();
            $table->foreign('pekerjaan_id')->references('id')->on('pekerjaans')->onDelete('cascade');
            $table->foreign('material_bekas_id')->references('id')->on('material_bekas')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('activity_logs', function (Blueprint $table) {
            //
        });
    }
};
