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
use Carbon\Carbon;
use CURLFile;
use DateTime;
use Illuminate\Support\Facades\Mail;
use Livewire\Attributes\On;
use Illuminate\Support\Facades\Log;

class LaporanSiswa extends Component
{
    use WithPagination;

    public $bulan;
    public $kelas_id;
    public $search = '';

    public function mount()
    {
        $this->bulan = now()->format('Y-m'); // Default bulan sekarang
        $this->kelas_id = ''; // Default tanpa filter kelas
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
        $query = Siswa::with('kelas')
            ->whereHas('penilaian', function ($q) {
                $q->whereRaw("strftime('%Y-%m', tgl) = ?", [$this->bulan]);
            });

        if (!empty($this->kelas_id)) {
            $query->where('kelas_id', $this->kelas_id);
        }

        if (!empty($this->search)) {
            $query->where('nama_lengkap', 'like', '%' . $this->search . '%');
        }

        $siswaList = $query->paginate(10);
        $kelasList = Kelas::all();

        return view('livewire.admin.laporan.laporan-siswa', compact('siswaList', 'kelasList'));
    }

    #[OnDownload]
    public function generatePDF($siswa_id)
    {
        $siswa = Siswa::with('kelas', 'wali')->findOrFail($siswa_id);

        $penilaian = Penilaian::with('materipenilaian.kategori')
            ->where('siswa_id', $siswa_id)
            ->whereRaw("strftime('%Y-%m', tgl) = ?", [$this->bulan])
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
    
        $bulanFormatted = date('F Y', strtotime($this->bulan . '-01'));
    
        $penilaian = Penilaian::where('siswa_id', $siswa_id)
            ->whereRaw("strftime('%Y-%m', tgl) = ?", [$this->bulan])
            ->get();
    
        $pdf = Pdf::loadView('pdf.laporan-siswa', [
            'siswa' => $siswa,
            'bulan' => $bulanFormatted,
            'penilaian' => $penilaian
        ])->output();
    
        try {
            Mail::to($emailWali)->send(new LaporanSiswaMail($siswa, $bulanFormatted, $pdf));
            Log::info("Email terkirim ke: " . $emailWali);
        } catch (\Exception $e) {
            Log::error("Gagal mengirim email: " . $e->getMessage());
        }
    }
    
    #[On('kirimWhatsApp')]
    public function kirimWhatsApp($siswa_id, $bulan)
    {
        Log::info("Mengirim WhatsApp untuk siswa ID: $siswa_id di bulan $bulan");
    
        // Ambil data siswa beserta wali dan nomor WA
        $siswa = Siswa::with('wali.user')->findOrFail($siswa_id);
        $noWaWali = $siswa->wali?->kontak;
    
        if (!$noWaWali) {
            Log::error("Nomor WhatsApp wali siswa tidak tersedia untuk: " . $siswa->nama_lengkap);
            return;
        }
    
        // Format nama bulan
        $bulanFormatted = Carbon::parse($bulan . '-01')->translatedFormat('F Y');
    
        // Ambil data penilaian
        $penilaian = Penilaian::where('siswa_id', $siswa_id)
            ->whereRaw("strftime('%Y-%m', tgl) = ?", [$bulan])
            ->get();
    
        if ($penilaian->isEmpty()) {
            Log::error("Tidak ada data penilaian untuk siswa {$siswa->nama_lengkap} di bulan {$bulanFormatted}");
            return;
        }
    
        // Pesan pengantar
        $message = "*Assalamualaikum Bapak/Ibu " . $siswa->wali->user->name . "*,\n\n" .
            "Berikut kami lampirkan laporan hafalan bulan *{$bulanFormatted}* untuk ananda *{$siswa->nama_lengkap}*.\n\n" .
            "Silakan cek laporan dalam file PDF terlampir. Jika ada pertanyaan, silakan hubungi kami.\n\n" .
            "*Admin Sekolah*";
    
        // Kirim pesan pengantar terlebih dahulu
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
    
        // Generate PDF laporan hafalan
        $pdf = PDF::loadView('pdf.laporan-siswa', [
            'siswa' => $siswa,
            'bulan' => $bulanFormatted,
            'penilaian' => $penilaian
        ]);
    
        // Simpan PDF ke storage sementara
        $pdfFilename = "Laporan_{$siswa->id}_{$bulan}.pdf";
        $pdfPath = storage_path("app/public/{$pdfFilename}");
        file_put_contents($pdfPath, $pdf->output());
    
        // Kirim file PDF setelah pesan teks
        sleep(2); // Tunggu sebentar agar pesan teks terkirim dulu
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
    
        Log::info("Response WhatsApp (File): " . $responseFile);
    
        // Cek response
        $responseDataText = json_decode($responseText, true);
        $responseDataFile = json_decode($responseFile, true);
    
        if (
            ($responseDataText && isset($responseDataText['status']) && $responseDataText['status'] === 'success') &&
            ($responseDataFile && isset($responseDataFile['status']) && $responseDataFile['status'] === 'success')
        ) {
            // Update status terkirim di database
            Penilaian::where('siswa_id', $siswa_id)
                ->whereRaw("strftime('%Y-%m', tgl) = ?", [$bulan])
                ->update([
                    'wa_terkirim' => true,
                    'wa_tanggal' => now(),
                ]);
    
            Log::info("WhatsApp terkirim ke: $noWaWali untuk siswa {$siswa->nama_lengkap}");
        } else {
            Log::error("Gagal mengirim WhatsApp: " . (($responseDataText['message'] ?? '') . ' | ' . ($responseDataFile['message'] ?? 'Tidak diketahui')));
        }
    
        // Hapus file setelah dikirim
        unlink($pdfPath);
    }
    

    
}
