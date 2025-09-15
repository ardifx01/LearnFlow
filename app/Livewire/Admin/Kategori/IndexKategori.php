<?php

namespace App\Livewire\Admin\Kategori;

use App\Models\Kategori;
use Livewire\Component;
use Livewire\WithPagination;

class IndexKategori extends Component
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
        $user = Kategori::where('id', $this->delete_id)->first();
        $user->delete();
  
        $this->dispatch('HapusAja');
    }
    public function render()
    {
        return view('livewire.admin.kategori.index-kategori', [
            'kategories' => Kategori::where('nama', 'like', "%{$this->search}%")
                ->paginate(10),
        ]);
    }
}
