<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditUser extends Component
{

    public $user;
    public $name, $email, $password, $role;

    public function mount(User $user)
    {
        $this->user = $user;
        $this->name = $user->name;
        $this->email = $user->email;
        $this->role = $user->role;
    }

    public function update()
    {
        $this->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,'.  $this->user->id,
            'password' => 'nullable|min:6',
            'role' => 'required|string', 
        ]);

        $this->user->update([
            'name' => $this->name,
            'email' => $this->email,
            'role' => $this->role,
            'password' => $this->password ? Hash::make($this->password) : $this->user->password,
        ]);

        session()->flash('success', 'Data berhasil disimpan!');
        return $this->redirect(route('user'), navigate: true);

    }

    public function render()
    {
        return view('livewire.admin.user.edit-user');
    }
}
