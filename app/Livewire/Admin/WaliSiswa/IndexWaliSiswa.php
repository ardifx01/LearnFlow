<?php

namespace App\Livewire\Admin\WaliSiswa;

use App\Models\WaliSiswa;
use Livewire\Component;
use Livewire\WithPagination;

class IndexWaliSiswa extends Component
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
            $wali = WaliSiswa::where('id', $this->delete_id)->first();
    
            if (!$wali) {
                session()->flash('error', 'Data wali siswa tidak ditemukan!');
                return;
            }
    
            if ($wali->user) {
                $wali->user->delete(); // Hapus akun user juga
            }
    
            $wali->delete();
    
            $this->dispatch('HapusAja');
        } catch (\Exception $e) {
            session()->flash('error', 'Terjadi kesalahan: ' . $e->getMessage());
        }
    }
    

    public function render()
    {
        return view('livewire.admin.wali-siswa.index-wali-siswa' , [
            'walisiswa' => WaliSiswa::whereHas('user', function ($query) {
                $query->where('name', 'like', "%{$this->search}%");
            })->paginate(10),
        ]);
    }
}
