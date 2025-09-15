<?php

namespace App\Livewire\Admin\User;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class IndexUser extends Component
{
    public $search;
    public $filter = 'admin';

    use WithPagination;

    public function updatedFilter()
    {
        $this->resetPage(); // Reset pagination saat filter berubah
    }

    protected $listeners = ['delete' => 'destroyData'];
    public $delete_id;

    public function deleteContirmation($id) {
        $this->delete_id = $id;
        $this->dispatch('konfirmDelete');
    }

    public function destroyData()
    {
        $user = User::where('id', $this->delete_id)->first();
        $user->delete();
  
        $this->dispatch('HapusAja');
    }

    public function render()
    {
        $users = User::where(function ($query) {
                $query->where('name', 'like', "%{$this->search}%")
                      ->orWhere('email', 'like', "%{$this->search}%");
            })
            ->when($this->filter, function ($query) {
                return $query->where('role', $this->filter);
            })
            ->paginate(10);

        return view('livewire.admin.user.index-user', compact('users'));
    }
}
