<?php

namespace App\Livewire\Guru\PenilaianSiswa;

use Livewire\Component;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\PenilaianIndikator;
use App\Models\Siswa;   // ✅ tambahin ini
use App\Models\Aspek;
use Illuminate\Support\Facades\DB;

class PenilaianEdit extends Component
{
    public $penilaian;

    public $siswa_id;
    public $bulan;
    public $pesan_wali;
    public $nilai_aspek = [];
    public $indikatorSelected = [];
    public $siswaList;

    public $aspeks = [];

    public function mount($id)
    {
        $this->penilaian = Penilaian::with([
            'siswa.kelas',
            'penilaianDetails',
            'penilaianIndikators'
        ])->findOrFail($id);

        // ambil siswa & bulan
        $this->siswa_id   = $this->penilaian->siswa_id;
        $this->bulan      = \Carbon\Carbon::parse($this->penilaian->bulan)->format('Y-m');
        $this->pesan_wali = $this->penilaian->pesan_wali;

        // isi nilai_aspek dari detail
        foreach ($this->penilaian->penilaianDetails as $detail) {
            $this->nilai_aspek[$detail->aspek_id] = $detail->nilai;
        }

        // isi indikatorSelected dari indikator
        foreach ($this->penilaian->penilaianIndikators as $indikator) {
            $this->indikatorSelected[$indikator->indikator->aspek_id][] = $indikator->indikator_id;
        }

        // load semua aspek + indikator untuk ditampilkan di form
        $this->aspeks = Aspek::with('indikators')->get();

        // load semua siswa untuk dropdown
        $this->siswaList = Siswa::with('kelas')->get();
    }


    public function update()
    {
        $this->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'bulan'    => 'required|date_format:Y-m',
        ]);

        // update penilaian utama
        $this->penilaian->update([
            'siswa_id'   => $this->siswa_id,
            'bulan'      => $this->bulan . '-01',
            'pesan_wali' => $this->pesan_wali,
        ]);

        // hapus data lama detail & indikator
        $this->penilaian->penilaianDetails()->delete();
        $this->penilaian->penilaianIndikators()->delete();

        // simpan ulang nilai aspek
        foreach ($this->nilai_aspek as $aspek_id => $nilai) {
            if ($nilai !== null && $nilai !== '') {

                // tentukan keterangan per aspek
                if ($nilai >= 8) {
                    $keteranganDetail = 'Berkembang';
                } elseif ($nilai >= 6) {
                    $keteranganDetail = 'Cukup Berkembang';
                } else {
                    $keteranganDetail = 'Kurang Berkembang';
                }

                PenilaianDetail::create([
                    'penilaian_id' => $this->penilaian->id,
                    'aspek_id'     => $aspek_id,
                    'nilai'        => (int) $nilai,
                    'keterangan'   => $keteranganDetail, // ✅ simpan keterangan per aspek
                ]);
            }
        }

        // simpan ulang indikator
        foreach ($this->indikatorSelected as $aspek_id => $indikators) {
            foreach ((array) $indikators as $indikator_id) {
                PenilaianIndikator::create([
                    'penilaian_id' => $this->penilaian->id,
                    'indikator_id' => $indikator_id,
                ]);
            }
        }

        // === Hitung ulang nilai akhir dari semua detail ===
        $totalNilai = PenilaianDetail::where('penilaian_id', $this->penilaian->id)->sum('nilai');

        // tentukan keterangan total
        if ($totalNilai >= 40) {
            $keterangan = 'Berkembang';
        } elseif ($totalNilai >= 25) {
            $keterangan = 'Cukup Berkembang';
        } else {
            $keterangan = 'Kurang Berkembang';
        }

        // update nilai akhir & keterangan total
        $this->penilaian->update([
            'nilai_akhir' => $totalNilai,
            'keterangan'  => $keterangan,
        ]);

        session()->flash('success', 'Data berhasil disimpan!');
        return redirect()->route('penilaian.index');
    }

    public function render()
    {
        return view('livewire.guru.penilaian-siswa.penilaian-edit', [
            'penilaian' => $this->penilaian,
            'aspeks'    => $this->aspeks,
        ]);
    }
}
