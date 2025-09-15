<?php

namespace App\Livewire\Admin\Indikator;

use Livewire\Component;
use App\Models\Aspek;
use App\Models\Indikator;

class IndikatorEdit extends Component
{
    public $indikator_id;
    public $aspek_id;
    public $nama_indikator = ['']; // array dinamis
    public $aspeks;

    public function mount($id)
    {
        $indikators = Indikator::where('aspek_id', $id)->get();

        if ($indikators->isEmpty()) {
            abort(404, 'Indikator tidak ditemukan');
        }

        $this->indikator_id = $id;
        $this->aspek_id = $indikators->first()->aspek_id;
        $this->nama_indikator = $indikators->pluck('nama_indikator')->toArray();

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

    public function update()
    {
        $this->validate([
            'aspek_id' => 'required|exists:aspeks,id',
            'nama_indikator.*' => 'required|string|min:3',
        ]);

        // Hapus semua indikator lama dari aspek ini
        Indikator::where('aspek_id', $this->aspek_id)->delete();

        // Simpan ulang indikator baru
        foreach ($this->nama_indikator as $nama) {
            Indikator::create([
                'aspek_id' => $this->aspek_id,
                'nama_indikator' => $nama,
            ]);
        }

        session()->flash('success', 'Indikator berhasil diperbarui!');
        return redirect()->route('indikator.index');
    }

    public function render()
    {
        return view('livewire.admin.indikator.indikator-edit');
    }
}
