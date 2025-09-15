<?php

namespace App\Livewire\Admin\WaliSiswa;

use App\Models\User;
use App\Models\WaliSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateWaliSiswa extends Component
{
    public $name, $email, $password, $kontak;

    protected $rules = [
        'name' => 'required|string',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
        'kontak' => 'nullable|numeric|digits:12',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);

    }

    public function store()
    {
        $this->validate();

        DB::beginTransaction(); // Mulai transaksi

        try {
            // Buat akun user terlebih dahulu
            $userData = [
                'name' => $this->name,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'wali_siswa',
            ];

            $user = User::create($userData);

            WaliSiswa::create([
                'users_id' => $user->id,
                'kontak' => $this->kontak,
            ]);

            DB::commit(); // Simpan ke database

            session()->flash('success', 'Data berhasil disimpan!');
            return $this->redirect(route('walisiswa.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan jika ada error

            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return $this->redirect(route('walisiswa.index'), navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.admin.wali-siswa.create-wali-siswa');
    }
}
