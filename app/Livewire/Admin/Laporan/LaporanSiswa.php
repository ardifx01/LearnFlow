<?php

namespace App\Livewire\Admin\Laporan;

use Livewire\Component;
use Livewire\WithPagination;
use App\Models\Siswa;
use App\Models\Kelas;
use App\Models\Penilaian;
use Barryvdh\DomPDF\Facade\Pdf;
use Livewire\Attributes\OnDownload;
use App\Mail\LaporanSiswaMail;
use App\Models\LaporanPengiriman;
use App\Models\WaliKelas;
use Carbon\Carbon;
use CURLFile;
use DateTime;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

use Illuminate\Support\Facades\Storage;


class LaporanSiswa extends Component
{
    use WithPagination;

    public $bulan;
    public $kelas_id;
    public $search = '';
    public $selectedPenilaian;
    public function mount()
    {
        $this->bulan = now()->format('Y-m'); // Default bulan sekarang
        $this->kelas_id = ''; // Default tanpa filter kelas
    }
    public function showDetail($siswaId)
    {
        $this->selectedPenilaian = Penilaian::where('siswa_id', $siswaId)->latest()->first();
    }

    public function updatedKelasId()
    {
        $this->resetPage();
    }

    public function updatedBulan()
    {
        $this->resetPage();
    }

    public function updatedSearch()
    {
        $this->resetPage();
    }

   
public function render()
{
    $userId = Auth::id();
    $userRole = Auth::user()->role;

    // Hitung rentang awal dan akhir bulan
    $start = Carbon::parse($this->bulan . '-01')->startOfMonth();
    $end = Carbon::parse($this->bulan . '-01')->endOfMonth();

    // Query dasar siswa dengan relasi kelas dan penilaian
    $query = Siswa::with([
            'kelas',
            'penilaian' => function ($q) use ($start, $end) {
                $q->whereBetween('bulan', [$start, $end]);
            }
        ])
        ->whereHas('penilaian', function ($q) use ($start, $end) {
            $q->whereBetween('bulan', [$start, $end]);
        });


    // Role wali_kelas: filter hanya kelas yang diampu
    if ($userRole === 'wali_kelas') {
        $guru = WaliKelas::where('users_id', $userId)->first();

        if ($guru) {
            $kelasIds = Kelas::where('guru_id', $guru->id)->pluck('id');
            $query->whereIn('kelas_id', $kelasIds);
        } else {
            $query->whereNull('id'); // Kosongkan
        }
    }

    // Role wali_siswa: filter berdasarkan relasi wali
    elseif ($userRole === 'wali_siswa') {
        $query->whereHas('wali', function ($q) use ($userId) {
            $q->where('users_id', $userId);
        });
    }

    // Filter kelas
    if (!empty($this->kelas_id)) {
        $query->where('kelas_id', $this->kelas_id);
    }

    // Filter pencarian nama
    if (!empty($this->search)) {
        $query->where('nama_lengkap', 'like', '%' . $this->search . '%');
    }

    $siswaList = $query->paginate(10);
    $kelasList = Kelas::all();

    Log::info('FILTER: bulan ' . $this->bulan . ', kelas_id ' . $this->kelas_id . ', search ' . $this->search);

    return view('livewire.admin.laporan.laporan-siswa', compact('siswaList', 'kelasList'));
}

    
    

    #[OnDownload]
    public function generatePDF($siswa_id)
    {
        $siswa = Siswa::with('kelas', 'wali')->findOrFail($siswa_id);

        $penilaian = Penilaian::with('materipenilaian.kategori')
            ->where('siswa_id', $siswa_id)
            ->whereYear('bulan', Carbon::parse($this->bulan)->year)
            ->whereMonth('bulan', Carbon::parse($this->bulan)->month)
            ->get();


        $pdf = Pdf::loadView('pdf.laporan-siswa', [
            'siswa' => $siswa,
            'penilaian' => $penilaian,
            'bulan' => date('F Y', strtotime($this->bulan . '-01'))
        ]);

        $filename = "Laporan_{$siswa->nama_lengkap}_{$this->bulan}.pdf";

        return response()->streamDownload(
            fn () => print($pdf->output()),
            $filename
        );
    }

    #[On('kirimEmail')]
    public function kirimEmail($siswa_id)
    {
        Log::info("Mengirim email untuk siswa ID: $siswa_id di bulan $this->bulan");
    
        $siswa = Siswa::with('wali.user')->findOrFail($siswa_id);
        $emailWali = $siswa->wali?->user?->email;
    
        if (!$emailWali) {
            Log::error("Email wali siswa tidak tersedia untuk: " . $siswa->nama_lengkap);
            return;
        }
    
        $bulanFormatted = Carbon::parse($this->bulan . '-01')->translatedFormat('F Y');
    
        $penilaian = Penilaian::where('siswa_id', $siswa_id)
            ->whereYear('bulan', Carbon::parse($this->bulan)->year)
            ->whereMonth('bulan', Carbon::parse($this->bulan)->month)
            ->get();
    
        $pdf = Pdf::loadView('pdf.laporan-siswa', [
            'siswa' => $siswa,
            'bulan' => $bulanFormatted,
            'penilaian' => $penilaian
        ])->output();
    
        try {
            Mail::to($emailWali)->send(new LaporanSiswaMail($siswa, $bulanFormatted, $pdf));
            // Log::info("Email terkirim ke: " . $emailWali);
    
            LaporanPengiriman::updateOrCreate(
                ['siswa_id' => $siswa_id, 'bulan' => $this->bulan],
                ['email_terkirim' => true, 'email_tanggal' => now()]
            );
            session()->flash('success', 'Data berhasil dikirim ke Email Wali!');
    
        } catch (\Exception $e) {
            Log::error("Gagal mengirim email: " . $e->getMessage());
        }
    }
    
    #[On('kirimWhatsApp')]
    public function kirimWhatsApp($siswa_id, $bulan)
    {
        Log::info("Mengirim WhatsApp untuk siswa ID: $siswa_id di bulan $bulan");
    
        $siswa = Siswa::with('wali.user')->findOrFail($siswa_id);
        $noWaWali = $siswa->wali?->kontak;
    
        if (!$noWaWali) {
            Log::error("Nomor WhatsApp wali siswa tidak tersedia untuk: " . $siswa->nama_lengkap);
            return;
        }
    
        $bulanFormatted = Carbon::parse($bulan . '-01')->translatedFormat('F Y');

    
        $penilaian = Penilaian::where('siswa_id', $siswa_id)
            ->whereYear('bulan', Carbon::parse($bulan)->year)
            ->whereMonth('bulan', Carbon::parse($bulan)->month)
            ->get();
    
        if ($penilaian->isEmpty()) {
            Log::error("Tidak ada data penilaian untuk siswa {$siswa->nama_lengkap} di bulan {$bulanFormatted}");
            return;
        }
    
        $message = "*Assalamualaikum Bapak/Ibu " . $siswa->wali->user->name . "*,\n\n" .
            "Berikut kami lampirkan laporan perkembangan bulan *{$bulanFormatted}* untuk ananda *{$siswa->nama_lengkap}*.\n\n" .
            "Silakan cek laporan dalam file PDF terlampir. Jika ada pertanyaan, silakan hubungi kami.\n\n" .
            "*Pesan dikirim oleh sistem, tidak perlu dibalas*";
    
        // Kirim pesan teks WhatsApp
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
    
        Log::info("Response WhatsApp (Pesan): " . $responseText);
    
        // Simpan PDF ke storage sementara
        $pdfFilename = "Laporan_{$siswa->nama_lengkap}_{$bulan}.pdf";
        $pdfPath = Storage::path("public/{$pdfFilename}");
    
        Storage::put("public/{$pdfFilename}", Pdf::loadView('pdf.laporan-siswa', [
            'siswa' => $siswa,
            'bulan' => $bulanFormatted,
            'penilaian' => $penilaian
        ])->output());
    
        sleep(2); // Tunggu sebentar agar pesan teks terkirim dulu
    
        // Kirim file PDF setelah pesan teks
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
    
        // Log::info("Response WhatsApp (File): " . $responseFile);
    
        // Cek response
        $responseDataText = json_decode($responseText, true);
        $responseDataFile = json_decode($responseFile, true);

        if (
            ($responseDataText && isset($responseDataText['status']) && $responseDataText['status'] === true) &&
            ($responseDataFile && isset($responseDataFile['status']) && $responseDataFile['status'] === true)
        )
        
        
        {
    
            // Log::info("WhatsApp terkirim ke: $noWaWali untuk siswa {$siswa->nama_lengkap}");
            LaporanPengiriman::updateOrCreate(
                ['siswa_id' => $siswa_id, 'bulan' => $bulan],
                ['wa_terkirim' => true, 'wa_tanggal' => now()]
            );
            // Log::info("Berhasil update laporan pengiriman WhatsApp untuk siswa ID: $siswa_id");
            session()->flash('success', 'Data berhasil dikirim ke WhatsApp Wali!');
            
        } else {
            Log::error("Gagal mengirim WhatsApp: " . (($responseDataText['message'] ?? '') . ' | ' . ($responseDataFile['message'] ?? 'Tidak diketahui')));
        }
    
        // Hapus file setelah dikirim
        Storage::delete("public/{$pdfFilename}");
    }
    
}
