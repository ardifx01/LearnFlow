<?php

namespace App\Livewire\Guru\PenilaianSiswa;

use Livewire\Component;
use App\Models\Penilaian;
use App\Models\Aspek;

class PenilaianDetail extends Component
{
    public $penilaian;
    public $aspeks = [];

    public function mount($id)
    {
        $this->penilaian = Penilaian::with([
            'siswa.kelas',
            'penilaianDetails.aspek',
            'penilaianIndikators.indikator'
        ])->findOrFail($id);

        // ambil semua aspek + indikator
        $this->aspeks = Aspek::with('indikators')->get();
    }

    public function render()
    {
        return view('livewire.guru.penilaian-siswa.penilaian-detail', [
            'penilaian' => $this->penilaian,
            'aspeks'    => $this->aspeks,
        ]);
    }
}
