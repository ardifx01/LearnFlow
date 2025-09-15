<?php

namespace App\Livewire\Admin\Indikator;

use Livewire\Component;
use App\Models\Aspek;
use App\Models\Indikator;

class IndikatorCreate extends Component
{
    public $aspek_id;
    public $nama_indikator = ['']; // minimal satu input
    public $aspeks;

    public function mount()
    {
        $this->aspeks = Aspek::all();
    }

    public function addNamaIndikator()
    {
        $this->nama_indikator[] = '';
    }

    public function removeNamaIndikator($index)
    {
        unset($this->nama_indikator[$index]);
        $this->nama_indikator = array_values($this->nama_indikator);
    }

    public function store()
    {
        $this->validate([
            'aspek_id' => 'required|exists:aspeks,id',
            'nama_indikator.*' => 'required|string|min:3',
        ]);

        foreach ($this->nama_indikator as $nama) {
            Indikator::create([
                'aspek_id' => $this->aspek_id,
                'nama_indikator' => $nama,
            ]);
        }

        session()->flash('success', 'Indikator berhasil ditambahkan!');
        return redirect()->route('indikator.index');
    }

    public function render()
    {
        return view('livewire.admin.indikator.indikator-create');
    }
}
