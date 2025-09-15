<?php

namespace App\Livewire\Admin\Aspek;

use App\Models\Aspek;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{

    public $search ='';
    use WithPagination;
    protected $paginationTheme = 'bootstrap';
    protected $listeners = ['delete' => 'destroyData'];
    public $delete_id;

    public function deleteContirmation($id) {
        $this->delete_id = $id;
        $this->dispatch('konfirmDelete');
    }

    public function destroyData()
    {
        $data = Aspek::where('id', $this->delete_id)->first();
        $data->delete();
  
        $this->dispatch('HapusAja');
    }

    public function render()
    {
        return view('livewire.admin.aspek.index', [
            'aspeks' => Aspek::where('nama', 'like', "%{$this->search}%")
                ->paginate(10),
        ]);
    }
}
