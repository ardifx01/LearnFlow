<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Aspek extends Model
{
    protected $fillable = ['nama'];

    public function indikators()
    {
        return $this->hasMany(Indikator::class, 'aspek_id');
    }
}
