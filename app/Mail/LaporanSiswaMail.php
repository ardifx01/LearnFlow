<?php
namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class LaporanSiswaMail extends Mailable
{
    public $siswa;
    public $bulan;
    public $pdf;

    public function __construct($siswa, $bulan, $pdf)
    {
        $this->siswa = $siswa;
        $this->bulan = $bulan;
        $this->pdf = $pdf;
    }

    public function build()
    {
        return $this->subject("Laporan Perkembangan - {$this->bulan}")
            ->view('emails.laporan-siswa')
            ->attachData($this->pdf, "Laporan_{$this->siswa->nama_lengkap}.pdf", [
                'mime' => 'application/pdf',
            ]);
    }
}
