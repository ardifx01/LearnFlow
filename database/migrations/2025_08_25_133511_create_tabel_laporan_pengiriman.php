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
        Schema::create('laporan_pengiriman', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('siswa_id');
            $table->date('bulan'); 
            $table->boolean('wa_terkirim')->default(false);
            $table->timestamp('wa_tanggal')->nullable();
            $table->boolean('email_terkirim')->default(false);
            $table->timestamp('email_tanggal')->nullable();
            $table->timestamps();
        
            $table->foreign('siswa_id')->references('id')->on('siswa')->onDelete('cascade');
            $table->unique(['siswa_id', 'bulan']);
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('laporan_pengiriman');
    }
};
