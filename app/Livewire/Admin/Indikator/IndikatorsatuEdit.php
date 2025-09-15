<?php

namespace App\Livewire\Admin\Indikator;

use Livewire\Component;
use App\Models\Indikator;
use App\Models\Aspek;

class IndikatorsatuEdit extends Component
{
    public $indikatorId;
    public $aspek_id;
    public $nama_indikator;

    public $aspeks;

    protected $rules = [
        'aspek_id' => 'required|exists:aspeks,id',
        'nama_indikator' => 'required|string|max:255',
    ];

    public function mount($id)
    {
        $this->indikatorId = $id;
        $indikator = Indikator::findOrFail($id);

        $this->aspek_id = $indikator->aspek_id;
        $this->nama_indikator = $indikator->nama_indikator;

        $this->aspeks = Aspek::all();
    }

    public function update()
    {
        $this->validate();

        $indikator = Indikator::findOrFail($this->indikatorId);
        $indikator->update([
            'aspek_id' => $this->aspek_id,
            'nama_indikator' => $this->nama_indikator,
        ]);

        session()->flash('success', 'Indikator berhasil diperbarui!');
        return redirect()->route('indikator.index'); // sesuaikan route index indikator
    }

    public function render()
    {
        return view('livewire.admin.indikator.indikatorsatu-edit');
    }
}
