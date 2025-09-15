<?php

namespace App\Livewire\Guru\LaporanPengiriman;

use App\Models\Aspek;
use App\Models\Kelas;
use App\Models\Penilaian;
use App\Models\Siswa;
use App\Models\LaporanPengiriman;
use App\Mail\LaporanSiswaMail;
use App\Models\WaliSiswa;
use Barryvdh\DomPDF\Facade\Pdf;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use CURLFile;

use Livewire\WithPagination;

class LaporanIndex extends Component
{
    use WithPagination;

    public $aspeks;
    public $kelas_id = '';
    public $bulan = '';         // format: Y-m (contoh "2025-01")
    public $search = '';

    // reset pagination saat filter berubah
    public function updatingKelasId() { $this->resetPage(); }
    public function updatingBulan()    { $this->resetPage(); }
    public function updatingSearch()   { $this->resetPage(); }

    public function mount()
    {
        $this->bulan = Carbon::now()->format('Y-m');
    }

    public function render()
    {
        $user = Auth::user();

        $query = Penilaian::with(['siswa.kelas', 'penilaianDetails']);

        // Filter by role
        if ($user->role === 'wali_kelas') {
            // cari record wali_kelas dari user login
            $waliKelas = \App\Models\WaliKelas::where('users_id', $user->id)->first();

            if ($waliKelas) {
                // ambil semua kelas yg diampu wali ini
                $query->whereHas('siswa.kelas', function ($q) use ($waliKelas) {
                    $q->where('guru_id', $waliKelas->id);
                });
            }
        } elseif ($user->role === 'wali_siswa') {
            // cari record wali_siswa berdasarkan users_id
            $wali = WaliSiswa::where('users_id', $user->id)->first();

            if ($wali) {
                // filter penilaian hanya untuk anak-anak wali ini
                $query->whereHas('siswa', function ($q) use ($wali) {
                    $q->where('wali_id', $wali->id);
                });
            }
        }




        // Filter kelas
        if ($this->kelas_id) {
            $query->whereHas('siswa.kelas', function ($q) {
                $q->where('id', $this->kelas_id);
            });
        }

        // Filter bulan (Y-m)
        if ($this->bulan) {
            $date = Carbon::createFromFormat('Y-m', $this->bulan)->startOfMonth();
            $query->whereYear('bulan', $date->year)
                  ->whereMonth('bulan', $date->month);
        }

        // Filter nama siswa
        if ($this->search) {
            $query->whereHas('siswa', function ($q) {
                $q->where('nama_lengkap', 'like', '%'.$this->search.'%');
            });
        }

        $penilaians = $query->latest()->paginate(10);

        // dropdown kelas ikut dibatasi role wali_kelas
        $kelasListQuery = Kelas::query()->select('id', 'nama');
        if ($user->role === 'wali_kelas') {
            $kelasListQuery->where('wali_kelas_id', $user->id);
        }
        $kelasList = $kelasListQuery->orderBy('nama')->get();

        // list bulan untuk 12 bulan terakhir + bulan ini
        $bulanList = $this->generateBulanList(12);

        $this->aspeks = Aspek::all();

        return view('livewire.guru.laporan-pengiriman.laporan-index', [
            'penilaians' => $penilaians,
            'kelasList'  => $kelasList,
            'bulanList'  => $bulanList,
        ]);
    }

    private function generateBulanList(int $monthsBack = 12): array
    {
        $list  = [];
        $start = now()->copy()->startOfMonth()->subMonths($monthsBack);
        $end   = now()->copy()->startOfMonth();

        while ($start <= $end) {
            $list[] = [
                'value' => $start->format('Y-m'),
                'label' => $start->translatedFormat('F Y'),
            ];
            $start->addMonth();
        }

        return $list;
    }

    public function kirimEmail($penilaian_id)
    {
        $penilaian = Penilaian::with('siswa.wali.user')->findOrFail($penilaian_id);
        $siswa     = $penilaian->siswa;

        if (!$siswa || !$siswa->wali?->user?->email) {
            session()->flash('error', 'Email wali siswa tidak tersedia.');
            return;
        }

        $emailWali      = $siswa->wali->user->email;
        $bulanFormatted = Carbon::parse($penilaian->bulan)->translatedFormat('F Y');

        // ambil semua penilaian siswa pada bulan itu
        $penilaianBulan = Penilaian::where('siswa_id', $siswa->id)
            ->whereYear('bulan', Carbon::parse($penilaian->bulan)->year)
            ->whereMonth('bulan', Carbon::parse($penilaian->bulan)->month)
            ->get();

        // buat PDF
        $pdf = Pdf::loadView('pdf.laporan-siswa', [
            'siswa'     => $siswa,
            'bulan'     => $bulanFormatted,
            'penilaian' => $penilaianBulan
        ])->output();

        try {
            Mail::to($emailWali)->send(new LaporanSiswaMail($siswa, $bulanFormatted, $pdf));

            // update tabel laporan_pengiriman
            LaporanPengiriman::updateOrCreate(
                ['siswa_id' => $siswa->id, 'bulan' => $penilaian->bulan],
                ['email_terkirim' => true, 'email_tanggal' => now()]
            );

            session()->flash('success', "Laporan berhasil dikirim ke email wali siswa: {$siswa->nama_lengkap}");

        } catch (\Exception $e) {
            Log::error("Gagal mengirim email ke {$emailWali}: " . $e->getMessage());
            session()->flash('error', 'Gagal mengirim email. Silakan coba lagi.');
        }
    }

    public function kirimWhatsApp($penilaian_id)
    {
        $penilaian = Penilaian::with('siswa.wali.user')->findOrFail($penilaian_id);

        $siswa = $penilaian->siswa;
        $noWaWali = $siswa->wali?->kontak;
        $bulan = $penilaian->bulan;
        $bulanFormatted = Carbon::parse($bulan)->translatedFormat('F Y');

        if (!$noWaWali) {
            Log::error("Nomor WhatsApp wali siswa tidak tersedia untuk: " . $siswa->nama_lengkap);
            session()->flash('error', "Nomor WhatsApp wali siswa tidak tersedia.");
            return;
        }

        // ambil semua penilaian bulan tsb
        $penilaianBulan = Penilaian::where('siswa_id', $siswa->id)
            ->whereYear('bulan', Carbon::parse($bulan)->year)
            ->whereMonth('bulan', Carbon::parse($bulan)->month)
            ->get();

        if ($penilaianBulan->isEmpty()) {
            session()->flash('error', "Tidak ada data penilaian untuk {$siswa->nama_lengkap} di bulan {$bulanFormatted}");
            return;
        }

        $message = "*Assalamualaikum Bapak/Ibu {$siswa->wali->user->name}*,\n\n" .
            "Berikut kami akan lampirkan laporan perkembangan bulan *{$bulanFormatted}* untuk ananda *{$siswa->nama_lengkap}*.\n\n" .
            "Silakan cek laporan dalam file PDF terlampir.\n\n" .
            "*Pesan dikirim oleh sistem, tidak perlu dibalas*";

        // kirim teks via WA Gateway
        $curlText = curl_init();
        curl_setopt_array($curlText, [
            CURLOPT_URL => 'https://wag.smkannuqayah.sch.id/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'message' => $message,
                'number' => $noWaWali,
            ],
        ]);
        $responseText = curl_exec($curlText);
        curl_close($curlText);

        // simpan PDF sementara
        $pdfFilename = "Laporan_{$siswa->nama_lengkap}_{$bulan}.pdf";
        $pdfPath = Storage::path("public/{$pdfFilename}");
        Storage::put("public/{$pdfFilename}", Pdf::loadView('pdf.laporan-siswa', [
            'siswa' => $siswa,
            'bulan' => $bulanFormatted,
            'penilaian' => $penilaianBulan
        ])->output());

        sleep(2); // kasih delay biar pesan teks nyampe dulu

        // kirim file PDF via WA Gateway
        $curlFile = curl_init();
        curl_setopt_array($curlFile, [
            CURLOPT_URL => 'https://wag.smkannuqayah.sch.id/send-message',
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST => true,
            CURLOPT_POSTFIELDS => [
                'number' => $noWaWali,
                'file_dikirim' => new CURLFile($pdfPath, 'application/pdf', $pdfFilename)
            ],
        ]);
        $responseFile = curl_exec($curlFile);
        curl_close($curlFile);

        $responseDataText = json_decode($responseText, true);
        $responseDataFile = json_decode($responseFile, true);

        if (
            ($responseDataText && isset($responseDataText['status']) && $responseDataText['status'] === true) &&
            ($responseDataFile && isset($responseDataFile['status']) && $responseDataFile['status'] === true)
        ) {
            LaporanPengiriman::updateOrCreate(
                ['siswa_id' => $siswa->id, 'bulan' => $bulan],
                ['wa_terkirim' => true, 'wa_tanggal' => now()]
            );
            session()->flash('success', "Laporan berhasil dikirim ke WhatsApp wali: {$siswa->wali->user->name}");
        } else {
            Log::error("Gagal mengirim WhatsApp ke {$noWaWali}: " .
                (($responseDataText['message'] ?? '') . ' | ' . ($responseDataFile['message'] ?? 'Tidak diketahui')));
            session()->flash('error', "Gagal mengirim WhatsApp ke wali {$siswa->wali->user->name}");
        }

        // hapus file PDF setelah dikirim
        Storage::delete("public/{$pdfFilename}");
    }

    public function generatePDF($penilaian_id)
    {
        // Ambil penilaian pertama beserta siswa & wali
        $penilaianUtama = Penilaian::with('siswa.wali.user')->findOrFail($penilaian_id);

        $siswa = $penilaianUtama->siswa;
        $bulan = $penilaianUtama->bulan;
        $bulanFormatted = Carbon::parse($bulan)->translatedFormat('F Y');

        // Ambil semua penilaian siswa pada bulan yang sama
        $penilaian = Penilaian::with('penilaianDetails')
            ->where('siswa_id', $siswa->id)
            ->whereYear('bulan', Carbon::parse($bulan)->year)
            ->whereMonth('bulan', Carbon::parse($bulan)->month)
            ->get();

        // Buat PDF
        $pdf = Pdf::loadView('pdf.laporan-siswa', [
            'siswa'     => $siswa,
            'penilaian' => $penilaian,
            'bulan'     => $bulanFormatted
        ]);

        $filename = "Laporan_{$siswa->nama_lengkap}_" . Carbon::parse($bulan)->format('Y_m') . ".pdf";

        // Unduh file PDF
        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename
        );
    }



}
