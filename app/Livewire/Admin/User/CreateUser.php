<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateUser extends Component
{
    public $name, $email, $password;

    protected $rules = [
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);
        
    }

    public function store()
    {
        $this->validate();

        User::create([
            'name' => $this->name,
            'email' => $this->email,
            'password' => Hash::make($this->password),
            'role' => 'admin', // Set otomatis sebagai admin
        ]);
        session()->flash('success', 'Data berhasil disimpan!');
        return $this->redirect(route('user'), navigate: true);
    }

    public function render()
    {
        return view('livewire.admin.user.create-user');
    }
}
