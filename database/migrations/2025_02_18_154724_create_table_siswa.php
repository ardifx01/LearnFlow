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
        Schema::create('siswa', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('wali_id');
            $table->unsignedBigInteger('kelas_id');
            $table->string('nama_lengkap');
            $table->string('nama_panggilan');
            $table->string('jk');
            $table->date('tetala');
            $table->string('alamat')->nullable();
            $table->timestamps();
            $table->foreign('wali_id')->references('id')->on('wali_siswa')->onDelete('restrict');
            $table->foreign('kelas_id')->references('id')->on('kelas')->onDelete('restrict');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('siswa');
    }
};
