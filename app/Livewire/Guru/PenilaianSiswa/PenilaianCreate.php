<?php

namespace App\Livewire\Guru\PenilaianSiswa;

use Livewire\Component;
use App\Models\Siswa;
use App\Models\Aspek;
use App\Models\Penilaian;
use App\Models\PenilaianDetail;
use App\Models\PenilaianIndikator;
use Illuminate\Support\Facades\Auth;

// (opsional) use App\Models\PenilaianIndikator;

class PenilaianCreate extends Component
{
    public $siswa_id;
    public $bulan;            // YYYY-MM (untuk input)
    public $pesan_wali;
    public $indikatorSelected = [];   // [aspek_id => [indikator_id, ...]]
    public $nilai_aspek = [];         // [aspek_id => nilai]

    public function mount()
    {
        $this->bulan = date('Y-m'); // FIX: cocok dengan <input type="month">
    }

    public function save()
    {
        $this->validate([
            'siswa_id' => 'required|exists:siswa,id',
            'bulan'    => 'required|date_format:Y-m',
        ]);

        $penilaian = Penilaian::create([
            'siswa_id'   => $this->siswa_id,
            'bulan'      => $this->bulan . '-01',
            'pesan_wali' => $this->pesan_wali,
        ]);

        $totalNilai = 0;

        // simpan nilai aspek + keterangan
        foreach ($this->nilai_aspek as $aspek_id => $nilai) {
            if ($nilai !== null && $nilai !== '') {
                $nilai = (int) $nilai;

                // tentukan keterangan per aspek
                if ($nilai >= 8) {
                    $keterangan = 'Berkembang';
                } elseif ($nilai >= 6) {
                    $keterangan = 'Cukup Berkembang';
                } else {
                    $keterangan = 'Kurang Berkembang';
                }

                PenilaianDetail::create([
                    'penilaian_id' => $penilaian->id,
                    'aspek_id'     => $aspek_id,
                    'nilai'        => $nilai,
                    'keterangan'   => $keterangan,
                ]);

                $totalNilai += $nilai;
            }
        }

        // simpan indikator
        foreach ($this->indikatorSelected as $aspek_id => $indikators) {
            foreach ((array) $indikators as $indikator_id) {
                PenilaianIndikator::create([
                    'penilaian_id' => $penilaian->id,
                    'indikator_id' => $indikator_id,
                ]);
            }
        }

        // update nilai akhir (total semua aspek)
        $penilaian->update([
            'nilai_akhir' => $totalNilai,
        ]);

        session()->flash('success', 'Data berhasil disimpan!');
        return redirect()->route('penilaian.index');
    }



    public function render()
    {
        $user = Auth::user();

        $siswaListQuery = Siswa::with('kelas');

        if ($user->role === 'wali_kelas') {
            // cari wali_kelas dari user login
            $waliKelas = \App\Models\WaliKelas::where('users_id', $user->id)->first();

            if ($waliKelas) {
                $siswaListQuery->whereHas('kelas', function ($q) use ($waliKelas) {
                    $q->where('guru_id', $waliKelas->id);
                });
            }
        }

        // admin / role lain otomatis ambil semua
        $siswaList = $siswaListQuery->get();

        return view('livewire.guru.penilaian-siswa.penilaian-create', [
            'siswaList' => $siswaList,
            'aspeks'    => Aspek::with('indikators')->get(),
        ]);
    }

}
