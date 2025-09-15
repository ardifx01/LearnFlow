<?php

use App\Http\Middleware\CekAksesEditPenilaian;
use App\Http\Middleware\EditSiswaMiddleware;
use App\Http\Middleware\RoleMiddleware;
use App\Livewire\Admin\Aspek\Index;
use App\Livewire\Admin\Aspek\Create;
use App\Livewire\Admin\Aspek\Edit;
use App\Livewire\Admin\Indikator\IndikatorCreate;
use App\Livewire\Admin\Indikator\IndikatorEdit;
use App\Livewire\Admin\Indikator\IndikatorIndex;
use App\Livewire\Admin\Indikator\IndikatorsatuEdit;
use App\Livewire\Admin\Kategori\CreateKategori;
use App\Livewire\Admin\Kategori\EditKategori;
use App\Livewire\Admin\Kategori\IndexKategori;
use App\Livewire\Admin\Kelas\CreateKelas;
use App\Livewire\Admin\Kelas\EditKelas;
use App\Livewire\Admin\Kelas\IndexKelas;
use App\Livewire\Admin\Siswa\CreateSiswa;
use App\Livewire\Admin\Siswa\EditSiswa;
use App\Livewire\Admin\Siswa\IndexSiswa;
use App\Livewire\Admin\User\CreateUser;
use App\Livewire\Admin\User\EditUser;
use App\Livewire\Admin\User\IndexUser;
use App\Livewire\Admin\WaliKelas\CreateWaliKelas;
use App\Livewire\Admin\WaliKelas\EditWaliKelas;
use App\Livewire\Admin\WaliKelas\IndexWaliKelas;
use App\Livewire\Admin\WaliSiswa\CreateWaliSiswa;
use App\Livewire\Admin\WaliSiswa\EditWaliSiswa;
use App\Livewire\Admin\WaliSiswa\IndexWaliSiswa;
use App\Livewire\Dashboard\DashboardIndex;
use App\Livewire\Guru\LaporanPengiriman\LaporanIndex;
use App\Livewire\Guru\Penilaian\CreatePenilaian;
use App\Livewire\Guru\Penilaian\EditPenilaian;
use App\Livewire\Guru\Penilaian\IndexPenilaian;
use App\Livewire\Setting\SettingApp;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Livewire\Guru\PenilaianSiswa\PenilaianCreate;
use App\Livewire\Guru\PenilaianSiswa\PenilaianIndex;

Route::get('/', function () {
    return redirect()->route('login');
});




Auth::routes(['register' => false]);

Route::middleware(['auth', RoleMiddleware::class . ':admin'])->group(function () {
    Route::get('/user', IndexUser::class)->name('user');
    Route::get('/create-user', CreateUser::class)->name('create.user');
    Route::get('/create-user', CreateUser::class)->name('create.user');

    Route::get('/setting', SettingApp::class)->name('setting');

    Route::get('/wali-kelas', IndexWaliKelas::class)->name('walikelas.index');
    Route::get('/create-wali-kelas', CreateWaliKelas::class)->name('walikelas.create');
    Route::get('/edit/{walikelas}/wali-kelas', EditWaliKelas::class)->name('walikelas.edit');

    Route::get('/wali-siswa', IndexWaliSiswa::class)->name('walisiswa.index');
    Route::get('/create-wali-siswa', CreateWaliSiswa::class)->name('walisiswa.create');
    Route::get('/edit/{walisiswa}/wali-siswa', EditWaliSiswa::class)->name('walisiswa.edit');

    Route::get('/kelas', IndexKelas::class)->name('kelas.index');
    Route::get('/kelas/create', CreateKelas::class)->name('kelas.create');
    Route::get('/kelas/edit/{kelas}', EditKelas::class)->name('kelas.edit');

    Route::get('/kategori', IndexKategori::class)->name('kategori.index');
    Route::get('/create-kategori', CreateKategori::class)->name('kategori.create');
    Route::get('/edit-kategori/{kategori}', EditKategori::class)->name('kategori.edit');

    Route::get('/kategori', Index::class)->name('aspek.index');
    Route::get('/kategori/create', Create::class)->name('aspek.create');
    Route::get('/{id}/edit/kategori', Edit::class)->name('aspek.edit');

    Route::get('/indikator', IndikatorIndex::class)->name('indikator.index');
    Route::get('/indikator/create', IndikatorCreate::class)->name('indikator.create');
    Route::get('/indikator/{id}/edit', IndikatorEdit::class)->name('indikator.edit');
    Route::get('/indikator/{id}/editsatu', IndikatorsatuEdit::class)->name('indikator1.edit');

});


Route::middleware(['auth', RoleMiddleware::class . ':admin,wali_kelas'])->group(function () {
    Route::get('/penilaian', PenilaianIndex::class)->name('penilaian.index');
    Route::get('/penilaian/create', PenilaianCreate::class)->name('penilaian.create');
    Route::get('/penilaian/{id}/edit', \App\Livewire\Guru\PenilaianSiswa\PenilaianEdit::class)->name('penilaian.edit');

    Route::get('/edit/{user}/data', EditUser::class)->name('edit.user');


});

Route::get('/laporan-siswa', LaporanIndex::class)->name('admin.laporan-siswa')->middleware(['auth', RoleMiddleware::class . ':admin,wali_kelas,wali_siswa']);


Route::middleware(['auth', RoleMiddleware::class . ':admin,wali_kelas,wali_siswa'])->group(function () {
    Route::get('/siswa', IndexSiswa::class)->name('siswa.index');
    Route::get('/siswa/create', CreateSiswa::class)->name('siswa.create');
    Route::get('/siswa/edit/{siswa}', EditSiswa::class)->name('siswa.edit')->middleware(['auth', EditSiswaMiddleware::class]);
    // Route::get('/api/chart-data', [DashboardIndex::class, 'getChartData'])->name('api.chart-data');
    Route::get('/dashboard/chart-data', [DashboardIndex::class, 'getChartData'])->name('dashboard.chart-data');
    Route::get('/dashboard', DashboardIndex::class)->name('dashboard');
    Route::get('/guru/penilaian/{id}/detail', \App\Livewire\Guru\PenilaianSiswa\PenilaianDetail::class)->name('penilaian.detail');


});

