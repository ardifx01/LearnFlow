<?php

namespace App\Livewire\Admin\Siswa;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use App\Models\WaliSiswa;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Livewire\Component;

class EditSiswa extends Component
{

    public $siswa;
    public $nama_lengkap, $nama_panggilan, $tetala, $alamat, $jk, $kelas_id;
    public $nama_wali, $kontak, $email, $password;
    public $wali_id, $user_id;

    protected $rules = [
        'nama_lengkap' => 'required|string',
        'nama_panggilan' => 'required|string',
        'alamat' => 'required|string',
        'tetala' => 'required|string',
        'jk' => 'required|string',
        'kelas_id' => 'required|exists:kelas,id',
        'nama_wali' => 'required|string',
        'kontak' => 'nullable|numeric|digits:12',
        'email' => 'required|email|unique:users,email,{user_id}', // Email unik kecuali untuk user saat ini
        'password' => 'nullable|min:6',
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);
    }

    public function mount(Siswa $siswa)
    {
        $this->siswa = $siswa;
        $this->nama_lengkap = $siswa->nama_lengkap;
        $this->nama_panggilan = $siswa->nama_panggilan;
        $this->alamat = $siswa->alamat;
        $this->tetala = $siswa->tetala;
        $this->jk = $siswa->jk;
        $this->kelas_id = $siswa->kelas_id;

        // Ambil data wali siswa
        $wali = $siswa->wali;
        if ($wali) {
            $this->wali_id = $wali->id;
            $this->kontak = $wali->kontak;

            // Ambil data user dari wali
            $user = $wali->user;
            if ($user) {
                $this->user_id = $user->id;
                $this->nama_wali = $user->name;
                $this->email = $user->email;
            }
        }
    }


    public function update()
    {
        $this->validate([
            'nama_lengkap' => 'required|string',
            'nama_panggilan' => 'required|string',
            'alamat' => 'required|string',
            'tetala' => 'required|string',
            'jk' => 'required|string',
            'kelas_id' => 'required|exists:kelas,id',
            'nama_wali' => 'required|string',
            'kontak' => 'required|string',
            'email' => "required|email|unique:users,email,{$this->user_id}",
            'password' => 'nullable|min:6',
        ]);

        DB::beginTransaction();

        try {
            // Update data siswa
            $this->siswa->update([
                'nama_lengkap' => $this->nama_lengkap,
                'nama_panggilan' => $this->nama_panggilan,
                'alamat' => $this->alamat,
                'tetala' => $this->tetala,
                'jk' => $this->jk,
                'kelas_id' => $this->kelas_id,
            ]);

            // Update data wali siswa
            if ($this->wali_id) {
                $wali = WaliSiswa::find($this->wali_id);
                if ($wali) {
                    $wali->update([
                        'kontak' => $this->kontak,
                    ]);
                }
            }

            // Update data user
            if ($this->user_id) {
                $user = User::find($this->user_id);
                if ($user) {
                    $user->update([
                        'name' => $this->nama_wali,
                        'email' => $this->email,
                        'password' => $this->password ? Hash::make($this->password) : $user->password,
                    ]);
                }
            }

            DB::commit();
            session()->flash('success', 'Data siswa berhasil diperbarui!');
            return $this->redirect(route('siswa.index'), navigate: true);

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }


    public function render()
    {
        return view('livewire.admin.siswa.edit-siswa', [
            'kelas' => Kelas::all(),
        ]);
    }
}
