<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use App\Models\WaliKelas;
use Livewire\Component;

class EditKelas extends Component
{

    public $kelas;
    public $guru_id, $nama;
    public $gurus;

    protected $rules = [
        'guru_id' => 'required',
        'nama' => 'required|string|max:255',
    ];

    public function mount(Kelas $kelas)
    {
        $this->kelas = $kelas;
        $this->guru_id = $kelas->guru_id;
        $this->nama = $kelas->nama;

        // Ambil wali kelas yang belum memiliki kelas atau wali kelas yang sedang mengampu kelas ini
        $this->gurus = WaliKelas::with('user')
            ->whereDoesntHave('kelas', function ($query) use ($kelas) {
                $query->where('id', '!=', $kelas->id);
            })
            ->orWhere('id', $kelas->guru_id) // Pastikan guru yang sekarang tetap ada dalam list
            ->get();
    }

    public function update()
    {
        $this->validate();

        $this->kelas->update([
            'guru_id' => $this->guru_id,
            'nama' => $this->nama,
        ]);

        session()->flash('success', 'Data berhasil diperbarui!');
        return $this->redirect(route('kelas.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.kelas.edit-kelas');
    }
}
