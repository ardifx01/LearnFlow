<?php

namespace App\Livewire\Dashboard;

use App\Models\Kelas;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\Siswa;
use App\Models\User;
use App\Models\WaliKelas;
use App\Models\WaliSiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class DashboardIndex extends Component
{
    public $role;
    public $kelasList = [];
    public $kelas_id = null;
    public $bulan = null;
    public $chartType = 'line';
    public $tahun = null;


    public function mount()
    {
        $this->role = Auth::user()->role;
        $this->kelasList = Kelas::all();
        $this->bulan = date('m'); // default bulan sekarang
        $this->tahun = now()->year; // default tahun ini

    }

    /**
     * (opsional) tabel rekap aspek lama
     */
    public function getRekapAspek()
    {
        $query = PenilaianDetail::query();

        if ($this->bulan) {
            $query->whereHas('penilaian', function ($q) {
                $q->whereMonth('bulan', $this->bulan);
            });
        }

        if ($this->kelas_id) {
            $query->whereHas('penilaian.siswa', function ($q) {
                $q->where('kelas_id', $this->kelas_id);
            });
        }

        // deteksi driver DB
        $driver = DB::getDriverName();
        $separator = $driver === 'sqlite'
            ? ", ', '"              // SQLite style
            : " SEPARATOR ', '";    // MySQL/MariaDB style

        return $query->select(
                'aspek_id',
                DB::raw("SUM(CASE WHEN nilai BETWEEN 8 AND 10 THEN 1 ELSE 0 END) as berkembang"),
                DB::raw("SUM(CASE WHEN nilai BETWEEN 6 AND 7 THEN 1 ELSE 0 END) as cukup"),
                DB::raw("SUM(CASE WHEN nilai BETWEEN 1 AND 5 THEN 1 ELSE 0 END) as kurang"),

                DB::raw("GROUP_CONCAT(DISTINCT CASE WHEN nilai BETWEEN 8 AND 10 THEN siswa.nama_lengkap END) as siswa_berkembang"),
                DB::raw("GROUP_CONCAT(DISTINCT CASE WHEN nilai BETWEEN 6 AND 7 THEN siswa.nama_lengkap END) as siswa_cukup"),
                DB::raw("GROUP_CONCAT(DISTINCT CASE WHEN nilai BETWEEN 1 AND 5 THEN siswa.nama_lengkap END) as siswa_kurang"),
            )
            ->join('penilaian', 'penilaian.id', '=', 'penilaian_detail.penilaian_id')
            ->join('siswa', 'siswa.id', '=', 'penilaian.siswa_id')
            ->groupBy('aspek_id')
            ->with('aspek')
            ->get();
    }




    /**
     * Rekap siswa + nilai akhir (untuk tabel & chart)
     */
    public function getRekapSiswa()
    {
        $query = Penilaian::query()
            ->with(['siswa' => function ($q) {
                $q->select('id', 'nama_lengkap', 'kelas_id');
            }]);

        if ($this->bulan) {
            $query->whereMonth('bulan', $this->bulan);
        }

        if ($this->kelas_id) {
            $query->whereHas('siswa', fn ($q) => $q->where('kelas_id', $this->kelas_id));
        }

        $items = $query->orderBy('siswa_id')->get();

        // pastikan ada nilai_akhir; kalau null → pakai rata-rata detail
        $items->transform(function ($p) {
            if (is_null($p->nilai_akhir)) {
                // pastikan ada relasi details() di model Penilaian
                $avg = $p->details()->avg('nilai'); // null kalau tidak ada detail
                $p->nilai_akhir = is_null($avg) ? 0 : round($avg, 2);
            }
            return $p;
        });

        // filter baris yang tidak punya relasi siswa (jaga-jaga)
        return $items->filter(fn ($p) => $p->siswa !== null)->values();
    }

    /**
     * 🔹 Data chart dari rekap siswa
     */
    public function getChartData(array $rekapSiswa)
    {
        return [
            'categories' => collect($rekapSiswa)->pluck('siswa.nama_lengkap')->toArray(),
            'values'     => collect($rekapSiswa)->pluck('nilai_akhir')->map(fn ($v) => (float) $v)->toArray(),
        ];
    }

    public function render()
    {
        if ($this->role === 'wali_siswa') {
            $wali = WaliSiswa::where('users_id', Auth::id())->first();
            $siswa = Siswa::where('wali_id', $wali->id)->first();

            $rekapSiswa = Penilaian::query()
                ->where('siswa_id', $siswa->id)
                ->when($this->tahun, fn($q) => $q->whereYear('bulan', $this->tahun))
                ->with('siswa:id,nama_lengkap')
                ->orderBy('bulan')
                ->get()

                ->map(function ($p) {
                    if (is_null($p->nilai_akhir)) {
                        $avg = $p->details()->avg('nilai');
                        $p->nilai_akhir = is_null($avg) ? 0 : round($avg, 2);
                    }
                    return $p;
                });


            // Chart per bulan
            $chartData = [
                'categories' => $rekapSiswa->pluck('bulan')
                   ->map(fn($b) => \Carbon\Carbon::parse($b)->locale('id')->translatedFormat('F'))
                    ->unique()
                    ->values()
                    ->toArray(),
                'values' => $rekapSiswa->pluck('nilai_akhir')
                    ->map(fn($v) => (float) $v)
                    ->toArray(),
            ];
        } else {
            // Admin / wali_kelas → semua siswa
            $rekapSiswa = $this->getRekapSiswa()->all();

            // Chart per siswa
            $chartData = [
                'categories' => collect($rekapSiswa)->pluck('siswa.nama_lengkap')->toArray(),
                'values'     => collect($rekapSiswa)->pluck('nilai_akhir')->map(fn($v) => (float) $v)->toArray(),
            ];
        }

        $this->dispatch('refreshChart', chartData: $chartData, chartType: $this->chartType);

        return view('livewire.dashboard.dashboard-index', [
            'siswa'        => Siswa::count(),
            'walisiswa'    => WaliSiswa::count(),
            'walikelas'    => WaliKelas::count(),
            'user'         => User::count(),
            'kelasList'    => $this->kelasList,
            'rekapAspek'   => $this->getRekapAspek(),
            'rekapSiswa'   => $rekapSiswa,
            'bulan'        => $this->bulan,
            'chartType'    => $this->chartType,
            'role'         => $this->role,
        ]);
    }


}
