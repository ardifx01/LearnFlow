<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WaliKelas extends Model
{
    protected $table = 'wali_kelas';
    protected $fillable = [
        'users_id',
        'kontak',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'users_id');
    }

    public function kelas()
    {
        return $this->hasOne(Kelas::class, 'guru_id');
    }

}
