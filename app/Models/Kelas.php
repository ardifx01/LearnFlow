<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Kelas extends Model
{
    protected $table = 'kelas';
    protected $fillable = ['guru_id', 'nama'];

    /**
     * Relasi ke model Guru (Setiap kelas memiliki satu guru)
     */
    public function waliKelas()
    {
        return $this->belongsTo(WaliKelas::class, 'guru_id');
    }
    public function siswa()
    {
        return $this->hasMany(Siswa::class);
    }
}
