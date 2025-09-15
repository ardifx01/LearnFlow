<div class="max-w-3xl mx-auto bg-white border border-gray-300 rounded-lg shadow px-8 py-6 space-y-8 text-sm">

    {{-- Header Profil --}}
    <div class="border-b pb-4 text-center">
        <h1 class="text-xl font-bold text-gray-900 mb-2">Laporan Penilaian Siswa</h1>
        <p>Nama: <span class="font-semibold">{{ $penilaian->siswa->nama_lengkap }}</span></p>
        <p>Kelas: <span class="font-semibold">{{ $penilaian->siswa->kelas->nama }}</span></p>
        <p>Bulan: <span class="font-semibold">{{ \Carbon\Carbon::parse($penilaian->bulan)->translatedFormat('F Y') }}</span></p>
    </div>

    {{-- Tabel Penilaian --}}
    <div>
        <h3 class="text-base font-semibold text-gray-800 mb-3">Detail Penilaian</h3>
        <table class="w-full border-collapse bg-white text-left border text-gray-700 text-sm">
            <thead class="bg-gray-100 text-gray-700 uppercase text-xs tracking-wider">
                <tr>
                    <th class="px-4 py-2 border">Kategori</th>
                    <th class="px-4 py-2 border">Indikator</th>
                    <th class="px-4 py-2 border text-center">Nilai</th>
                    <th class="px-4 py-2 border">Keterangan</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($penilaian->penilaianDetails as $detail)
                    @php
                        $indikators = $penilaian->penilaianIndikators
                            ->filter(fn($ind) => $ind->indikator->aspek_id == $detail->aspek_id);

                        if ($detail->nilai >= 8) {
                            $ket = 'Berkembang';
                            $ketColor = 'text-green-700';
                        } elseif ($detail->nilai >= 6) {
                            $ket = 'Cukup Berkembang';
                            $ketColor = 'text-yellow-700';
                        } else {
                            $ket = 'Kurang Berkembang';
                            $ketColor = 'text-red-700';
                        }
                    @endphp
                    <tr>
                        <td class="px-4 py-2 border font-medium">{{ $detail->aspek->nama }}</td>
                        <td class="px-4 py-2 border leading-snug">
                            @forelse($indikators as $ind)
                                <ul class="list-disc pl-5 space-y-1">
                                    <li>{{ $ind->indikator->nama_indikator }}</li>
                                </ul>
                            @empty
                                <span class="text-gray-400 italic">Tidak ada indikator</span>
                            @endforelse
                        </td>

                        <td class="px-4 py-2 border text-center font-semibold text-blue-700">
                            {{ $detail->nilai }}
                        </td>
                        <td class="px-4 py-2 border font-medium {{ $ketColor }}">
                            {{ $ket }}
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>

    {{-- Pesan Wali --}}
    <div class="bg-gray-50 border px-4 py-3 rounded">
        <h3 class="font-semibold text-sm mb-1">Pesan Wali</h3>
        <p class="text-gray-700 text-sm leading-snug">
            {{ $penilaian->pesan_wali ?? 'Tidak ada pesan dari wali.' }}
        </p>
    </div>

    {{-- Ringkasan --}}
    <div>
        <h3 class="font-semibold text-sm mb-1 text-gray-800">Ringkasan</h3>
        <p class="text-gray-700 text-sm">
            <strong>Nilai Akhir:</strong> 
            <span class="font-bold text-indigo-600">{{ $penilaian->nilai_akhir }}</span>
        </p>
        <ul class="list-disc list-inside text-xs text-gray-600 mt-2 leading-snug">
            <li>Berkembang (8 – 10)</li>
            <li>Cukup Berkembang (6 – 7)</li>
            <li>Kurang Berkembang (1 – 5)</li>
        </ul>
    </div>

</div>
