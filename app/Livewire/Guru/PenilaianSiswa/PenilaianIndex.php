<?php
namespace App\Livewire\Guru\PenilaianSiswa;

use App\Models\Penilaian;
use App\Models\Aspek;
use App\Models\Kelas;
use Carbon\Carbon;
use Livewire\Component;
use Livewire\WithPagination;

class PenilaianIndex extends Component
{
    use WithPagination;

    // protected $paginationTheme = 'bootstrap'; // kalau pakai Bootstrap, kalau Tailwind hapus saja

    public $aspeks;
    public $kelas_id = '';
    public $bulan = '';
    public $search = '';


    protected $listeners = ['delete' => 'destroyData'];
    public $delete_id;

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function updatingKelasId()
    {
        $this->resetPage();
    }

    public function updatingBulan()
    {
        $this->resetPage();
    }

    public function mount()
    {
        $this->bulan = Carbon::now()->month;
    }

    public function deleteContirmation($id)
    {
        $this->delete_id = $id;
        $this->dispatch('konfirmDelete'); // trigger modal konfirmasi
    }

    public function destroyData()
    {
        $penilaian = Penilaian::find($this->delete_id);

        if ($penilaian) {
            // Hapus relasi dulu
            $penilaian->penilaianDetails()->delete();
            $penilaian->penilaianIndikators()->delete();

            // Hapus penilaian utama
            $penilaian->delete();
        }

        $this->dispatch('HapusAja'); // notifikasi sukses
    }


    public function render()
    {
        // ambil data kelas untuk dropdown filter
        $kelasList = Kelas::all();

        // daftar bulan (Januari s/d Desember)
        $bulanList = collect(range(1, 12))->map(function ($m) {
            return [
                'value' => $m,
                'label' => Carbon::create()->month($m)->translatedFormat('F'),
            ];
        });

        // query penilaian dengan filter
        $query = Penilaian::with(['siswa.kelas', 'penilaianDetails'])
            ->when($this->search, function ($q) {
                $q->whereHas('siswa', function ($qs) {
                    $qs->where('nama_lengkap', 'like', '%' . $this->search . '%');
                });
            })
            ->when($this->kelas_id, function ($q) {
                $q->whereHas('siswa', function ($qs) {
                    $qs->where('kelas_id', $this->kelas_id);
                });
            })
            ->when($this->bulan, function ($q) {
                $q->whereMonth('bulan', $this->bulan);
            })
            ->latest();

        $penilaians = $query->paginate(10);

        $this->aspeks = Aspek::all();

        return view('livewire.guru.penilaian-siswa.penilaian-index', [
            'penilaians' => $penilaians,
            'kelasList'  => $kelasList,
            'bulanList'  => $bulanList,
        ]);
    }

}
