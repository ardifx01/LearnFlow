<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class EditKategori extends Component
{
    public $nama;
    public $kategori;

    protected $rules = [
        'nama' => 'required|string|max:255',
    ];

    public function mount(Kategori $kategori)
    {
        $this->nama = $kategori->nama;
    }

    public function update()
    {
        $this->validate();

        $this->kategori->update([
            'nama' => $this->nama,
        ]);

        session()->flash('success', 'Data berhasil diperbarui!');
        return $this->redirect(route('kategori.index'), navigate: true);
    }
    public function render()
    {
        return view('livewire.admin.kategori.edit-kategori');
    }
}
