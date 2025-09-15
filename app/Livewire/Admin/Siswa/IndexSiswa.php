<?php

namespace App\Livewire\Admin\Siswa;

use App\Imports\SiswaImport;
use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;

class IndexSiswa extends Component
{

    use WithPagination;
    use WithFileUploads;
    public $file, $isImporting = false;
    // protected $paginationTheme = 'bootstrap';

    public $search = '';
    public $kelas_id = '';
    protected $listeners = ['delete' => 'destroyData'];
    public $delete_id;

    protected $rules = [
        'file' => 'required|mimes:xlsx,xls|max:2048', // Maksimal 2MB
    ];

    public function updated($propertyName)
    {
        $this->validateOnly($propertyName, $this->rules);
    }

    public function deleteContirmation($id) {
        $this->delete_id = $id;
        $this->dispatch('konfirmDelete');
    }

    public function destroyData()
    {
        DB::beginTransaction();
        try {
            $siswa = Siswa::with('wali.user')->where('id', $this->delete_id)->first();

            if (!$siswa) {
                session()->flash('error', 'Siswa tidak ditemukan. Mungkin sudah dihapus sebelumnya.');
                return;
            }

            // Hapus data siswa
            $siswa->delete();

            // Jika ada wali, hapus juga datanya
            if ($siswa->wali) {
                $userId = $siswa->wali->users_id;
                $siswa->wali->delete();

                // Pastikan user terkait juga dihapus
                User::where('id', $userId)->delete();
            }

            DB::commit();

            $this->dispatch('HapusAja');
            session()->flash('success', 'Data siswa dan wali berhasil dihapus.');

        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Ups! Tidak bisa menghapus siswa karena sudah ada penilaian.');
        }
    }

    public function import()
    {
        $this->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        try {
            Excel::import(new SiswaImport, $this->file->getRealPath());
            session()->flash('success', '✅ Data siswa berhasil diimpor!');
        } catch (\Exception $e) {
            // Deteksi beberapa error umum
            if (str_contains($e->getMessage(), 'UNIQUE constraint failed: users.email')) {
                session()->flash('error', 'Gagal impor: Ada email yang sudah digunakan. Silakan periksa kembali file Excel Anda.');
            } else {
                session()->flash('error', 'Terjadi kesalahan saat impor: ' . $e->getMessage());
            }
        }

        $this->reset('file', 'isImporting');
    }



    public function downloadTemplate()
    {
        $filePath = public_path('storage/import_siswa/import.xlsx');

        if (!file_exists($filePath)) {
            session()->flash('error', 'Template tidak ditemukan!');
            return;
        }

        return response()->download($filePath, 'Template_Siswa.xlsx');
    }


    public function render()
    {
        $user = auth()->user(); // Ambil user yang login
        $query = Siswa::with(['wali', 'wali.user', 'kelas']);

        // Cek peran pengguna
        if ($user->role === 'wali_siswa') {
            // Hanya tampilkan anak dari wali siswa yang login
            $query->where('wali_id', $user->waliSiswa->id);
        } elseif ($user->role === 'wali_kelas') {
            // Hanya tampilkan siswa yang ada di kelas wali kelas tersebut
            $query->whereHas('kelas', function ($q) use ($user) {
                $q->where('guru_id', $user->waliKelas->id);
            });
        }
        // Jika role adalah admin, maka tidak ada filter tambahan (semua siswa ditampilkan)

        // Tambahkan pencarian
        $query->where(function ($q) {
            $q->where('nama_lengkap', 'like', "%{$this->search}%")
            ->orWhereHas('wali.user', function ($subQuery) {
                $subQuery->where('name', 'like', "%{$this->search}%");
            });
        });

        // Tambahkan filter kelas jika dipilih
        if ($this->kelas_id) {
            $query->where('kelas_id', $this->kelas_id);
        }

        $siswa = $query->paginate(10);
        $kelasList = Kelas::all();

        return view('livewire.admin.siswa.index-siswa', compact('siswa', 'kelasList'));
    }




}
