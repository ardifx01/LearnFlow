<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianIndikator extends Model
{
    use HasFactory;

    protected $table = 'penilaian_indikator';

    protected $fillable = [
        'penilaian_id',
        'indikator_id',
    ];

    // Relasi ke Penilaian
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class, 'penilaian_id');
    }

    // Relasi ke Indikator
    public function indikator()
    {
        return $this->belongsTo(Indikator::class, 'indikator_id');
    }
}
