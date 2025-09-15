<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenilaianDetail extends Model
{
    use HasFactory;
    protected $table = 'penilaian_detail';
    protected $fillable = [
        'penilaian_id',
        'aspek_id',
        'nilai',
        'keterangan',
    ];

    // Relasi dengan penilaian
    public function penilaian()
    {
        return $this->belongsTo(Penilaian::class);
    }

    // Relasi dengan aspek
    public function aspek()
    {
        return $this->belongsTo(Aspek::class);
    }

    public function indikators()
    {
        return $this->belongsToMany(Indikator::class, 'indikator_penilaian_detail');
    }
}
