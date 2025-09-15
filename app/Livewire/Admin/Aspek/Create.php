<?php

namespace App\Livewire\Admin\Aspek;

use Livewire\Component;
use App\Models\Aspek;

class Create extends Component
{
    public $nama;

    protected $rules = [
        'nama' => 'required|string|max:255',
    ];

    public function store()
    {
        $this->validate();
        Aspek::create(['nama' => $this->nama]);

        session()->flash('success', 'Aspek berhasil ditambahkan');
        return redirect()->route('aspek.index');
    }

    public function render()
    {
        return view('livewire.admin.aspek.create');
    }
}
