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
    Schema::create('penilaian_detail', function (Blueprint $table) {
        $table->id();
        $table->unsignedBigInteger('penilaian_id');
        $table->unsignedBigInteger('aspek_id');
        $table->tinyInteger('nilai'); // 1 - 10
        $table->string('keterangan')->nullable(); // Berkembang / Cukup Berkembang / Kurang Berkembang
        $table->timestamps();
        
        $table->foreign('penilaian_id')->references('id')->on('penilaian')->onDelete('cascade');
        $table->foreign('aspek_id')->references('id')->on('aspeks')->onDelete('cascade');
    });


    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penilaian_detail');
    }
};
