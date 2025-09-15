<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\Kategori;
use Livewire\Component;

class CreateKategori extends Component
{
    public $nama;

    protected $rules = [
        'nama' => 'required|string|max:255',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);
        
    }
    

    public function store()
    {
        $this->validate();

        Kategori::create([
            'nama' => $this->nama,
        ]);

        session()->flash('success', 'Data berhasil disimpan!');
        return $this->redirect(route('kategori.index'), navigate: true);

    }

    public function render()
    {
        return view('livewire.admin.kategori.create-kategori');
    }
}
