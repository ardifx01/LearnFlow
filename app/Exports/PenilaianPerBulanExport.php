<?php

namespace App\Exports;

use App\Models\Penilaian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Border;

class PenilaianPerBulanExport implements FromCollection, WithHeadings, WithStyles, WithTitle
{
    protected $bulan;
    protected $kelas;

    public function __construct($bulan, $kelas = null)
    {
        $this->bulan = $bulan;
        $this->kelas = $kelas;
    }

    public function collection()
    {
        $query = Penilaian::with(['siswa.kelas', 'materipenilaian.kategori'])
            ->whereRaw("strftime('%Y-%m', bulan) = ?", [$this->bulan]);

        if ($this->kelas) {
            $query->whereHas('siswa.kelas', function ($q) {
                $q->where('id', $this->kelas);
            });
        }

        $data = $query->get();

        return $data->map(function ($penilaian, $index) {
            return [
                'No' => $index + 1,
                'Tanggal' => $penilaian->bulan,
                'Nama Siswa' => $penilaian->siswa->nama_lengkap,
                'Kelas' => $penilaian->siswa->kelas->nama ?? '-',
                'Nilai' => $this->convertNilai($penilaian->nilai),
                'Nilai Agama' => $penilaian->nilai_agama ?? '-',
                'Nilai Literasi' => $penilaian->nilai_literasi ?? '-',
                'Nilai Jati Diri' => $penilaian->nilai_jati_diri ?? '-',
                'Pesan Wali' => $penilaian->pesan_wali ?? '-',
            ];
        });
    }

    public function headings(): array
    {
        return [
            'No',
            'Tanggal',
            'Nama Siswa',
            'Kelas',
            'Nilai',
            'Nilai Agama & Budi Pekerti',
            'Nilai Literasi',
            'Nilai Jati Diri',
            'Pesan Wali',
            'Catatan',
        ];
    }

    public function styles(Worksheet $sheet)
    {
        $highestRow = $sheet->getHighestRow();
        $highestColumn = $sheet->getHighestColumn();
        $range = "A1:{$highestColumn}{$highestRow}";

        $sheet->getRowDimension(1)->setRowHeight(25);
        foreach (range('A', $highestColumn) as $col) {
            $sheet->getColumnDimension($col)->setAutoSize(true);
        }

        $headerStyle = [
            'font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'], 'size' => 12],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '4CAF50']],
            'alignment' => ['horizontal' => 'center', 'vertical' => 'center'],
        ];
        $sheet->getStyle('A1:' . $highestColumn . '1')->applyFromArray($headerStyle);

        for ($row = 2; $row <= $highestRow; $row++) {
            $color = ($row % 2 == 0) ? 'E8F5E9' : 'FFFFFF';
            $sheet->getStyle("A{$row}:{$highestColumn}{$row}")->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB($color);
        }

        $borderStyle = [
            'borders' => [
                'allBorders' => [
                    'borderStyle' => Border::BORDER_THIN,
                    'color' => ['rgb' => '000000'],
                ],
            ],
        ];
        $sheet->getStyle($range)->applyFromArray($borderStyle);

        return [];
    }

    public function title(): string
    {
        return date('F Y', strtotime($this->bulan . '-01'));
    }

    private function convertNilai($nilai)
    {
        $nilaiHuruf = [
            '100' => 'A (Baik)',
            '50' => 'B (Mulai Berkembang)',
            '10' => 'C (Belum Berkembang)'
        ];

        return $nilaiHuruf[$nilai] ?? $nilai;
    }
}
