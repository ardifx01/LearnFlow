<?php

namespace App\Livewire\Admin\WaliKelas;

use App\Models\User;
use App\Models\WaliKelas;
use Livewire\Component;

class EditWaliKelas extends Component
{

    public $guruId, $kontak;
    public $userId, $name, $email;

    public function mount(WaliKelas $walikelas)
    {
        $this->guruId = $walikelas->id;
        $this->kontak = $walikelas->kontak;

        // Ambil data user dari guru
        $this->userId = $walikelas->users_id;
        $user = User::find($this->userId);

        if ($user) {
            $this->name = $user->name;
            $this->email = $user->email;
        }
    }

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'kontak' => 'required|string',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);

    }

    public function update()
    {
        $this->validate([
            'kontak' => 'nullable|string',
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->userId,
            'kontak' => 'nullable|numeric|digits:12',
        ]);

        // Update Guru
        WaliKelas::findOrFail($this->guruId)->update([
            'kontak' => $this->kontak,
        ]);

        // Update User
        User::findOrFail($this->userId)->update([
            'name' => $this->name,
            'email' => $this->email,
        ]);
        session()->flash('success', 'Data berhasil disimpan!');
        return $this->redirect(route('walikelas.index'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.wali-kelas.edit-wali-kelas');
    }
}
