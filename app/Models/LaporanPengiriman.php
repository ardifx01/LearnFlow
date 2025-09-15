<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class LaporanPengiriman extends Model
{
    protected $table = 'laporan_pengiriman';

    protected $fillable = [
        'siswa_id',
        'bulan',
        'wa_terkirim',
        'wa_tanggal',
        'email_terkirim',
        'email_tanggal',
    ];

    /**
     * Relasi ke tabel siswa
     */
    public function siswa()
    {
        return $this->belongsTo(Siswa::class, 'siswa_id');
    }
}
