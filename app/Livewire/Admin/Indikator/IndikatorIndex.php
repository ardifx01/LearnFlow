<?php

namespace App\Livewire\Admin\Indikator;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Indikator;
use App\Models\Aspek;

class IndikatorIndex extends Component
{
    use WithPagination;

    public $search = '';
    public $perPage = 10;

    protected $paginationTheme = 'bootstrap';

    protected $listeners = ['delete' => 'destroyData'];
    public $delete_id;

    public function deleteContirmation($id) {
        $this->delete_id = $id;
        $this->dispatch('konfirmDelete');
    }

    public function destroyData()
    {
        $data = Indikator::where('id', $this->delete_id)->first();
        $data->delete();
  
        $this->dispatch('HapusAja');
    }

    public function render()
    {
        $indikators = Indikator::with('aspek')
            ->when($this->search, function ($query) {
                $query->where('deskripsi', 'like', '%' . $this->search . '%')
                      ->orWhereHas('aspek', function ($q) {
                          $q->where('nama', 'like', '%' . $this->search . '%');
                      });
            })
            ->latest()
            ->paginate($this->perPage);

        return view('livewire.admin.indikator.indikator-index', [
            'indikators' => $indikators
        ]);
    }

    public function delete($id)
    {
        $indikator = Indikator::findOrFail($id);
        $indikator->delete();

        session()->flash('success', 'Indikator berhasil dihapus');
    }
}
