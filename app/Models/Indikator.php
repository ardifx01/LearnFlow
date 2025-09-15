<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Indikator extends Model
{
    protected $table = 'indikators';
    protected $fillable = ['aspek_id', 'nama_indikator'];

    public function aspek()
    {
        return $this->belongsTo(Aspek::class);
    }
}

