<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Penilaian extends Model
{
    use HasFactory;

    protected $table = 'penilaian';

    protected $fillable = [
        'siswa_id',
        'bulan',
        'pesan_wali',
        'nilai_akhir'
    ];

    // Relasi dengan siswa
    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }

    // Relasi dengan penilaian_detail
    public function penilaianDetails()
    {
        return $this->hasMany(PenilaianDetail::class);
    }

    public function penilaianIndikators()
    {
        return $this->hasMany(\App\Models\PenilaianIndikator::class, 'penilaian_id');
    }

}
