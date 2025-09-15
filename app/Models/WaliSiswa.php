<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliSiswa extends Model
{
    protected $table = 'wali_siswa';
    protected $fillable = [
        'users_id',
        'kontak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function siswa()
    {
        return $this->belongsTo(Siswa::class);
    }
}
