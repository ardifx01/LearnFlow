<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Models\WaliSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class CreateSiswa extends Component
{

    public $nama_lengkap, $nama_panggilan, $tetala, $alamat, $jk, $kelas_id;
    public $nama_wali, $kontak, $email, $password;

    protected $rules = [
        'nama_lengkap' => 'required|string',
        'nama_panggilan' => 'required|string',
        'alamat' => 'required|string',
        'tetala' => 'required|string',
        'jk' => 'required|string',
        'kelas_id' => 'required|exists:kelas,id',
        'nama_wali' => 'required|string',
        'kontak' => 'nullable|numeric|digits:12',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|min:6',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);
    }

    public function store()
    {
        // dd($this->all());
        $this->validate();

        DB::beginTransaction(); // Mulai transaksi

        try {
            // Buat akun user untuk wali siswa
            $user = User::create([
                'name' => $this->nama_wali,
                'email' => $this->email,
                'password' => Hash::make($this->password),
                'role' => 'wali_siswa',
            ]);

            // Buat data wali siswa
            $wali = WaliSiswa::create([
                'users_id' => $user->id,
                'kontak' => $this->kontak,
            ]);

            // Buat data siswa
            Siswa::create([
                'nama_lengkap' => $this->nama_lengkap,
                'nama_panggilan' => $this->nama_panggilan,
                'tetala' => $this->tetala,
                'alamat' => $this->alamat,
                'jk' => $this->jk,
                'wali_id' => $wali->id,
                'kelas_id' => $this->kelas_id,
            ]);

            DB::commit(); // Simpan ke database jika semuanya sukses

            session()->flash('success', 'Data siswa berhasil ditambahkan!');
            return $this->redirect(route('siswa.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollBack(); // Batalkan semua perubahan jika ada error

            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
            return $this->redirect(route('siswa.index'), navigate: true);
        }
    }

    public function render()
    {
        return view('livewire.admin.siswa.create-siswa', [
            'kelas' => Kelas::all(),
        ]);
    }
}
