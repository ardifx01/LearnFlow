<?php

namespace App\Livewire\Admin\WaliKelas;

use App\Models\WaliKelas;
use Livewire\Component;
use Livewire\WithPagination;

class IndexWaliKelas extends Component
{
    use WithPagination;
    public $search;
    protected $listeners = ['delete' => 'destroyData'];
    public $delete_id;

    public function deleteContirmation($id) {
        $this->delete_id = $id;
        $this->dispatch('konfirmDelete');
    }

    public function destroyData()
    {
        try {
            $guru = WaliKelas::where('id', $this->delete_id)->first();

            if ($guru) {
                // Simpan user sebelum hapus guru
                $user = $guru->user;

                // Hapus wali kelas dulu (yang pegang FK ke user)
                $guru->delete();

                // Baru hapus user
                if ($user) {
                    $user->delete();
                }

                $this->dispatch('HapusAja');
            } else {
                session()->flash('error', 'Data tidak ditemukan!');

            }

        } catch (\Exception $e) {
            session()->flash('error', 'Ups! Tidak bisa menghapus Wali kelas karena masih ada relasi dengan data kelas!');
        }
    }



    public function render()
    {
        return view('livewire.admin.wali-kelas.index-wali-kelas' , [
            'teachers' => WaliKelas::whereHas('user', function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })->paginate(10),
        ]);
    }
}
