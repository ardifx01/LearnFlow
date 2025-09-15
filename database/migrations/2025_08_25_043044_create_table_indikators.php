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
        Schema::create('indikators', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('aspek_id');
            $table->string('nama_indikator');
            $table->timestamps();

            $table->foreign('aspek_id')->references('id')->on('aspeks')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('indikators');
    }
};
