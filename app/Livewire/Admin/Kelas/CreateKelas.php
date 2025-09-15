<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use App\Models\WaliKelas;
use Livewire\Component;

class CreateKelas extends Component
{
    public $guru_id, $nama;
    public $gurus;

    protected $rules = [
        'guru_id' => 'required',
        'nama' => 'required|string|max:255',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);
        
    }

    public function mount()
    {
        $this->gurus = WaliKelas::with('user')
            ->whereDoesntHave('kelas') // Hanya wali kelas yang belum punya kelas
            ->get();
    }
    

    public function store()
    {
        $this->validate();

        Kelas::create([
            'guru_id' => $this->guru_id,
            'nama' => $this->nama,
        ]);

        session()->flash('success', 'Data berhasil disimpan!');
        return $this->redirect(route('kelas.index'), navigate: true);

    }

    public function render()
    {
        return view('livewire.admin.kelas.create-kelas');
    }
}
