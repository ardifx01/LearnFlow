<?php

namespace App\Livewire\Dashboard;

use App\Models\Kelas;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\Siswa;
use App\Models\User;
use App\Models\WaliKelas;
use App\Models\WaliSiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Livewire\Component;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardIndex extends Component
{
    public $role;
    public $kelasList = [];
    public $kelas_id = null;
    public $bulan = null;

    public function mount()
    {
        $this->role = Auth::user()->role;
        $this->kelasList = Kelas::all();

        // default bulan sekarang
        $this->bulan = date('m');

        if ($this->role === 'wali_siswa') {
            $this->emitChartWali();
        } else {
            $this->emitChartData();
        }
    }

    /** trigger ketika kelas diganti */
    public function updatedKelasId()
    {
        $this->emitChartData();
    }

    /** trigger ketika bulan diganti */
    public function updatedBulan()
    {
        $this->emitChartData();
    }

    public function emitChartData()
    {
        $data = $this->getChartData();
        $this->dispatch('updateChart', data: $data);
    }

    public function getChartData()
    {
        $query = Siswa::with(['penilaian' => function ($q) {
            if ($this->bulan) {
                $q->whereMonth('bulan', $this->bulan);
            }
        }]);

        if ($this->kelas_id) {
            $query->where('kelas_id', $this->kelas_id);
        }

        $siswaList = $query->get();
        $data = [];

        foreach ($siswaList as $siswa) {
            foreach ($siswa->penilaian as $penilaian) {
                $data[] = [
                    'nama' => $siswa->nama_panggilan ?? $siswa->nama_lengkap,
                    'nilai' => $penilaian->nilai,
                    'warna' => match ($penilaian->nilai) {
                        '100' => 'green',
                        '50'  => 'yellow',
                        '10'  => 'red',
                        default => 'gray',
                    }
                ];
            }
        }

        return $data;
    }

    public function emitChartWali()
    {
        $data = $this->getChartDataWali();
        $this->dispatch('updateChartWali', data: $data);
    }

    public function getChartDataWali()
    {
        $user = Auth::user();
        $waliSiswa = WaliSiswa::where('users_id', $user->id)->first();

        if (!$waliSiswa) return [];

        $siswa = Siswa::where('wali_id', $waliSiswa->id)->first();
        if (!$siswa) return [];

        $penilaianList = Penilaian::where('siswa_id', $siswa->id)
            ->orderBy('bulan')
            ->get();

        $data = [];
        foreach ($penilaianList as $penilaian) {
            $data[] = [
                'nama' => date('F', strtotime($penilaian->bulan)),
                'nilai' => $penilaian->nilai,
                'warna' => match ($penilaian->nilai) {
                    '100' => 'green',
                    '50'  => 'yellow',
                    '10'  => 'red',
                    default => 'gray',
                }
            ];
        }

        return $data;
    }

    public function cetak()
    {
        $kelas = Kelas::find($this->kelas_id);

        $siswa = Siswa::where('kelas_id', $kelas->id)
            ->with(['penilaian' => function ($q) {
                $q->whereMonth('bulan', Carbon::parse($this->bulan)->month)
                  ->whereYear('bulan', Carbon::parse($this->bulan)->year);
            }])
            ->get();

        $pdf = Pdf::loadView('exports.grafik-penilaian', [
            'kelas' => $kelas,
            'siswa' => $siswa,
            'bulan' => $this->bulan,
        ])->setPaper('a4', 'landscape');

        return response()->streamDownload(function () use ($pdf) {
            echo $pdf->stream();
        }, 'grafik-penilaian.pdf');
    }

    /** 🔥 Rekap per aspek dengan filter bulan + kelas */
    public function getRekapAspek()
    {
        $query = PenilaianDetail::query();

        // filter per bulan
        if ($this->bulan) {
            $query->whereHas('penilaian', function($q) {
                $q->whereMonth('bulan', $this->bulan);
            });
        }

        // filter per kelas
        if ($this->kelas_id) {
            $query->whereHas('penilaian.siswa', function($q) {
                $q->where('kelas_id', $this->kelas_id);
            });
        }

        return $query->select(
                'aspek_id',
                DB::raw("SUM(CASE WHEN nilai BETWEEN 8 AND 10 THEN 1 ELSE 0 END) as berkembang"),
                DB::raw("SUM(CASE WHEN nilai BETWEEN 6 AND 7 THEN 1 ELSE 0 END) as cukup"),
                DB::raw("SUM(CASE WHEN nilai BETWEEN 1 AND 5 THEN 1 ELSE 0 END) as kurang")
            )
            ->groupBy('aspek_id')
            ->with('aspek')
            ->get();
    }

    public function render()
    {
        return view('livewire.dashboard.dashboard-index', [
            'siswa'     => Siswa::count(),
            'walisiswa' => WaliSiswa::count(),
            'walikelas' => WaliKelas::count(),
            'user'      => User::count(),
            'kelasList' => $this->kelasList,
            'rekapAspek'=> $this->getRekapAspek(),
        ]);
    }
}
