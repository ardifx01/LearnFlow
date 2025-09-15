<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Materi extends Model
{
    protected $table = 'materi_penilaian';
    protected $fillable = [
        'kategori_id',
        'nama'
    ];


    public function kategori()
    {
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    public function penilaian()
    {
        return $this->hasMany(Penilaian::class, 'materipenilaian_id');
    }

}
