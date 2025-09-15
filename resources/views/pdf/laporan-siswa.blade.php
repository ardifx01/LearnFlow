<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Laporan Siswa - {{ $siswa->nama_lengkap }}</title>
    <style>
        @page {
            size: 210mm 330mm; /* kertas folio (F4) */
            margin: 15mm;
        }
        body {
            font-family: DejaVu Sans, sans-serif;
            font-size: 10pt;
            color: #333;
            line-height: 1.3;
        }

        .kop {
            text-align: center;
            margin-bottom: 10px;
            border-bottom: 2px solid #000;
            padding-bottom: 5px;
        }
        .kop h2, .kop h3 {
            margin: 0;
            font-size: 12pt;
        }

        .info {
            margin: 5px 0 12px 0;
        }
        .info table {
            width: 100%;
            font-size: 10pt;
        }
        .info td {
            padding: 2px 2px;
        }

        table.penilaian {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 12px;
            font-size: 10pt;

            border: 1px solid #444;
            border-radius: 6px;      /* sudut membulat */
            overflow: hidden;        /* supaya radius rapi */
        }

        table.penilaian th, 
        table.penilaian td {
            border: 1px solid #444;
            padding: 5px 6px;
        }

        table.penilaian th {
            background: #3498db;   /* biru */
            color: #fff;           /* teks putih */
            text-align: center;
            font-weight: bold;
        }

        table.penilaian tr:nth-child(even) td {
            background: #f9f9f9;   /* baris genap abu tipis */
        }

        table.penilaian td {
            vertical-align: top;
        }

        table.penilaian td.nilai,
        table.penilaian td.ket {
            text-align: center;
            width: 10%;
        }
        table.penilaian td.aspek, td.nilai {
            width: 18%;
            text-align: center;
            vertical-align: middle;
            font-weight: bold;
            background: #ecf6fc; /* biru muda agar beda */
        }
        table.penilaian td.indikator {
            width: 62%;
        }

        .ringkasan, .pesan-wali {
            padding: 6px;
            border: 1px solid #aaa;
            margin-top: 10px;
            border-radius: 4px;
            font-size: 10pt;
        }
        .ringkasan {
            background: #f9f9f9;
        }
        .pesan-wali {
            background: #fffef6;
            border-color: #f1c40f;
        }

        .footer {
            margin-top: 25px;
            text-align: right;
            font-size: 10pt;
        }
    </style>
</head>
<body>
    <div class="kop">
        <h2>LAPORAN PERKEMBANGAN SISWA</h2>
        <h3>Bulan: {{ $bulan }}</h3>
    </div>

    <div class="info">
        <table>
            <tr>
                <td><strong>Nama Siswa</strong></td>
                <td>: {{ $siswa->nama_lengkap }}</td>
            </tr>
            <tr>
                <td><strong>Kelas</strong></td>
                <td>: {{ $siswa->kelas->nama ?? '-' }}</td>
            </tr>
        </table>
    </div>

    <table class="penilaian">
        <thead>
            <tr>
                <th>Kategori</th>
                <th>Indikator</th>
                <th>Nilai</th>
                <th>Keterangan</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($penilaian as $p)
                @foreach ($p->penilaianDetails as $detail)
                    @php
                        if ($detail->nilai >= 8) {
                            $ket = 'Berkembang';
                        } elseif ($detail->nilai >= 6) {
                            $ket = 'Cukup Berkembang';
                        } else {
                            $ket = 'Kurang Berkembang';
                        }

                        $indikators = $p->penilaianIndikators
                            ->filter(fn($ind) => $ind->indikator->aspek_id == $detail->aspek_id)
                            ->pluck('indikator.nama_indikator');
                    @endphp
                    <tr>
                        <td class="aspek">{{ $detail->aspek->nama }}</td>
                        <td class="indikator">
                            @if($indikators->isNotEmpty())
                                <ul style="margin:0; padding-left:14px;">
                                    @foreach($indikators as $ind)
                                        <li>{{ $ind }}</li>
                                    @endforeach
                                </ul>
                            @else
                                <em>-</em>
                            @endif
                        </td>
                        <td class="nilai">{{ $detail->nilai }}</td>
                        <td class="ket">{{ $ket }}</td>
                    </tr>
                @endforeach
            @endforeach
        </tbody>
    </table>

    <div class="ringkasan">
        <p><strong>Nilai Akhir:</strong> {{ $penilaian->first()->nilai_akhir ?? '-' }}</p>
    </div>

    <div class="pesan-wali">
        <p><strong>Pesan Wali:</strong></p>
        <p>{{ $penilaian->first()->pesan_wali ?? 'Tidak ada pesan wali.' }}</p>
    </div>

    <div class="keterangan">
        <p><strong>Keterangan Berkembang:</strong></p>
        <ul style="margin:0; padding-left:18px;">
            <li>Berkembang (8 – 10)</li>
            <li>Cukup Berkembang (6 – 7)</li>
            <li>Kurang Berkembang (1 – 5)</li>
        </ul>
    </div>

    <div class="footer">
        Hormat kami, <br>
        <em>Guru/Wali Kelas</em>
    </div>
</body>
</html>
