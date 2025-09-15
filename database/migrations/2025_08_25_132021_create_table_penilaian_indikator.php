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
        Schema::create('penilaian_indikator', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('penilaian_id');
        $table->unsignedBigInteger('indikator_id');
        $table->timestamps();

        $table->foreign('penilaian_id')->references('id')->on('penilaian')->onDelete('cascade');
        $table->foreign('indikator_id')->references('id')->on('indikators')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_indikator');
    }
};
