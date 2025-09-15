<?php

namespace App\Exports;

use App\Models\Penilaian;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class PenilaianExport implements WithMultipleSheets
{
    protected $bulan;
    protected $kelas;

    public function __construct($bulan = null, $kelas = null)
    {
        $this->bulan = $bulan;
        $this->kelas = $kelas;
    }

    public function sheets(): array
    {
        $sheets = [];

        if ($this->bulan) {
            $sheets[] = new PenilaianPerBulanExport($this->bulan, $this->kelas);
        } else {
            $bulanList = Penilaian::selectRaw("strftime('%Y-%m', bulan) as bulan")
                ->distinct()
                ->orderBy('bulan', 'desc')
                ->pluck('bulan');

            foreach ($bulanList as $bulan) {
                $sheets[] = new PenilaianPerBulanExport($bulan, $this->kelas);
            }
        }

        return $sheets;
    }
}