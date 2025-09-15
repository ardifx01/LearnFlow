<?php

namespace App\Livewire\Admin\Kelas;

use App\Models\Kelas;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Livewire\WithPagination;

class IndexKelas extends Component
{
    use WithPagination;
    public $search ='';

    protected $listeners = ['delete' => 'destroyData'];
    public $delete_id;

    public function deleteContirmation($id) {
        $this->delete_id = $id;
        $this->dispatch('konfirmDelete');
    }

    public function destroyData()
    {
        DB::beginTransaction();
        try {
            $kelas = Kelas::withCount('siswa')->find($this->delete_id);

            if (!$kelas) {
                session()->flash('error', 'Kelas tidak ditemukan.');
                return;
            }

            if ($kelas->siswa_count > 0) {
                session()->flash('error', 'Upss! Kelas tidak bisa dihapus karena masih ada siswa.');
                return;
            }

            $kelas->delete();
            DB::commit();

            $this->dispatch('HapusAja');
            session()->flash('success', 'Kelas berhasil dihapus.');
        } catch (\Exception $e) {
            DB::rollBack();
            session()->flash('error', 'Terjadi kesalahan saat menghapus kelas: ' . $e->getMessage());
        }
    }



    public function render()
    {
        return view('livewire.admin.kelas.index-kelas', [
            'kelas' => Kelas::where('nama', 'like', "%{$this->search}%")
                ->paginate(10),
        ]);
    }

}
