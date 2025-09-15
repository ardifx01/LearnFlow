<?php

namespace App\Livewire\Admin\WaliSiswa;

use App\Models\User;
use App\Models\WaliSiswa;
use Livewire\Component;

class EditWaliSiswa extends Component
{

    public $guruId, $kontak;
    public $userId, $name, $email;

    public function mount(WaliSiswa $walisiswa)
    {
        $this->guruId = $walisiswa->id;
        $this->kontak = $walisiswa->kontak;

        // Ambil data user dari guru
        $this->userId = $walisiswa->users_id;
        $user = User::find($this->userId);

        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'kontak' => 'nullable|numeric|digits:12',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);

    }

    public function update()
    {
        $this->validate([
            'kontak' => 'nullable|numeric|digits:12',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
        ]);

        // Update Guru
        WaliSiswa::findOrFail($this->guruId)->update([
            'kontak' => $this->kontak,
        ]);

        // Update User
        User::findOrFail($this->userId)->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        session()->flash('success', 'Data berhasil disimpan!');
        return $this->redirect(route('walisiswa.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.wali-siswa.edit-wali-siswa');
    }
}

