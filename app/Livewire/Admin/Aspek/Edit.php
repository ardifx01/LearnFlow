<?php

namespace App\Livewire\Admin\Aspek;

use Livewire\Component;
use App\Models\Aspek;

class Edit extends Component
{
    public $aspekId;
    public $nama;

    protected $rules = [
        'nama' => 'required|string|max:255',
    ];

    public function mount($id)
    {
        $aspek = Aspek::findOrFail($id);
        $this->aspekId = $aspek->id;
        $this->nama = $aspek->nama;
    }

    public function update()
    {
        $this->validate();
        $aspek = Aspek::findOrFail($this->aspekId);
        $aspek->update(['nama' => $this->nama]);

        session()->flash('success', 'Aspek berhasil diupdate');
        return redirect()->route('aspek.index');
    }

    public function render()
    {
        return view('livewire.admin.aspek.edit');
    }
}
