<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Siswa extends Model
{
    protected $table = 'siswa';
    protected $fillable = [
        'wali_id',
        'kelas_id',
        'nama_lengkap',
        'nama_panggilan',
        'jk',
        'tetala',
        'alamat'
    ];

    public function kelas()
    {
        return $this->belongsTo(Kelas::class);
    }

    public function wali()
    {
        return $this->belongsTo(WaliSiswa::class, 'wali_id');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'siswa_id');
    }

    public function laporanPengiriman()
    {
        return $this->hasOne(LaporanPengiriman::class, 'siswa_id');
    }


}
