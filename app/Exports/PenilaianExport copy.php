<?php

namespace App\Exports;

use App\Models\Penilaian;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PenilaianExport implements WithMultipleSheets
{
    protected $bulan;

    public function __construct($bulan)
    {
        $this->bulan = $bulan;
    }

    public function sheets(): array
    {
        $sheets = [];

        if ($this->bulan) {
            // Jika hanya satu bulan, buat satu sheet saja
            $sheets[] = new PenilaianPerBulanExport($this->bulan);
        } else {
            // Jika semua bulan, ambil data unik bulan
            $bulanList = Penilaian::selectRaw("strftime('%Y-%m', tgl) as bulan")
                ->distinct()
                ->orderBy('bulan', 'desc')
                ->pluck('bulan');

            foreach ($bulanList as $bulan) {
                $sheets[] = new PenilaianPerBulanExport($bulan);
            }
        }

        return $sheets;
    }
}
