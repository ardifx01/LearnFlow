<div class="animate__animated p-6" :class="[$store.app.animation]">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
        </li>
    </ul>

    <div class="space-y-4 pt-5">
        <div class="panel h-full overflow-hidden border-0 p-0">
            <div class="min-h-[190px] bg-gradient-to-r from-[#4361ee] to-[#160f6b] p-6">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center rounded-full bg-black/50 p-1 font-semibold text-white ltr:pr-3 rtl:pl-3">
                        <img class="block h-8 w-8 rounded-full border-2 border-white/50 object-cover ltr:mr-1 rtl:ml-1" src="{{ asset('assets/images/user-profile.jpeg')}}" alt="image">
                        Halo Ibu {{ Auth::user()->name }}
                    </div>
                </div>
                <div class="flex items-center justify-between text-white">
                    <p class="text-xl">Selamat Datang!</p>
                    <div class="flex flex-col text-right ltr:ml-auto rtl:mr-auto">
                        <h5 class="text-2xl">طَلَبُ الْعِلْمِ فَرِيْضَةٌ عَلَى كُلِّ مُسْلِمٍ</h5>
                        <h5 class="text-1xl mt-1">“Menuntut ilmu itu wajib atas setiap Muslim” (HR. Ibnu Majah)</h5>
                    </div>
                </div>
            </div>
        </div>

        {{-- <div class="mb-6 grid grid-cols-1 gap-6 text-white sm:grid-cols-2 xl:grid-cols-4">
            <!-- Users Visit -->
            <div class="panel bg-gradient-to-r from-cyan-500 to-cyan-400">
                <div class="flex justify-between">
                    <div class="text-md font-semibold ltr:mr-1 rtl:ml-1">Jumlah Siswa</div>
                </div>
                <div class="mt-5 flex items-center">
                    <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3 badge bg-white/30">{{ $siswa }}</div>
                </div>
                <div class="mt-5 flex items-center font-semibold">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                            <path opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" stroke="currentColor" stroke-width="1.5"></path>
                            <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
                        </svg>
                        <a href="{{route('siswa.index')}}" wire:navigate>Lihat Detail</a>
                </div>
            </div>

            <!-- Sessions -->
            <div class="panel bg-gradient-to-r from-violet-500 to-violet-400">
                <div class="flex justify-between">
                    <div class="text-md font-semibold ltr:mr-1 rtl:ml-1">Jumlah Wali Siswa</div>
                </div>
                <div class="mt-5 flex items-center">
                    <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3 badge bg-white/30">{{$walisiswa}}</div>
                </div>
                <div class="mt-5 flex items-center font-semibold">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                        <path opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" stroke="currentColor" stroke-width="1.5"></path>
                        <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
                    </svg>
                    <a href="{{route('walisiswa.index')}}" wire:navigate>Lihat Detail</a>
                </div>
            </div>

            <!-- Time On-Site -->
            <div class="panel bg-gradient-to-r from-blue-500 to-blue-400">
                <div class="flex justify-between">
                    <div class="text-md font-semibold ltr:mr-1 rtl:ml-1">Jumlah Wali Kelas</div>
                </div>
                <div class="mt-5 flex items-center">
                    <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3 badge bg-white/30">{{$walikelas}}</div>

                </div>
                <div class="mt-5 flex items-center font-semibold">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                        <path opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" stroke="currentColor" stroke-width="1.5"></path>
                        <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
                    </svg>
                    <a href="{{route('walikelas.index')}}" wire:navigate>Lihat Detail</a>
                </div>
            </div>

            <!-- Bounce Rate -->
            <div class="panel bg-gradient-to-r from-fuchsia-500 to-fuchsia-400">
                <div class="flex justify-between">
                    <div class="text-md font-semibold ltr:mr-1 rtl:ml-1">Jumlah Pengguna</div>
                </div>
                <div class="mt-5 flex items-center">
                    <div class="text-3xl font-bold ltr:mr-3 rtl:ml-3 badge bg-white/30">{{$user}}</div>
                </div>
                <div class="mt-5 flex items-center font-semibold">
                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 shrink-0 ltr:mr-2 rtl:ml-2">
                        <path opacity="0.5" d="M3.27489 15.2957C2.42496 14.1915 2 13.6394 2 12C2 10.3606 2.42496 9.80853 3.27489 8.70433C4.97196 6.49956 7.81811 4 12 4C16.1819 4 19.028 6.49956 20.7251 8.70433C21.575 9.80853 22 10.3606 22 12C22 13.6394 21.575 14.1915 20.7251 15.2957C19.028 17.5004 16.1819 20 12 20C7.81811 20 4.97196 17.5004 3.27489 15.2957Z" stroke="currentColor" stroke-width="1.5"></path>
                        <path d="M15 12C15 13.6569 13.6569 15 12 15C10.3431 15 9 13.6569 9 12C9 10.3431 10.3431 9 12 9C13.6569 9 15 10.3431 15 12Z" stroke="currentColor" stroke-width="1.5"></path>
                    </svg>
                    <a href="{{route('user')}}" wire:navigate>Lihat Detail</a>
                </div>
            </div>
        </div> --}}

        <div class="panel col-span-12">
            <div class="mb-5 text-lg font-bold">Rekap Per Aspek (Bulan {{ $bulan }})</div>
                        <div class="flex flex-col sm:flex-row gap-3 sm:items-center mb-4">
                <!-- Filter Kelas -->
                <div class="w-full sm:w-64">
                    <label class="block text-sm mb-1">Kelas</label>
                    <select wire:model.live="kelas_id" class="form-select">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $k)
                            <option value="{{ $k->id }}">{{ $k->nama }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Bulan (1–12) -->
                <div class="w-full sm:w-48">
                    <label class="block text-sm mb-1">Bulan</label>
                    <select wire:model.live="bulan" class="form-select">
                        @for($m=1;$m<=12;$m++)
                            <option value="{{ str_pad($m,2,'0',STR_PAD_LEFT) }}">
                                {{ \Carbon\Carbon::create()->month($m)->translatedFormat('F') }}
                            </option>
                        @endfor
                    </select>
                </div>
            </div>
            <div class="table-responsive">
                <table class="w-full">
                    <thead>
                        <tr class="bg-gray-800">
                            <th class="ltr:rounded-l-md rtl:rounded-r-md px-4 py-2">Aspek</th>
                            <th class="text-center px-4 py-2">Berkembang (8–10)</th>
                            <th class="text-center px-4 py-2">Cukup Berkembang (6–7)</th>
                            <th class="text-center px-4 py-2 ltr:rounded-r-md rtl:rounded-l-md">Kurang Berkembang (1–5)</th>
                        </tr>
                    </thead>
                    <tbody class="bg-gray-700">
                        @forelse($rekapAspek as $rekap)
                            <tr class="border-b border-gray-600">
                                <td class="font-semibold whitespace-nowrap px-4 py-2">{{ $rekap->aspek->nama }}</td>
                                <td class="text-center px-4 py-2">
                                    <span class="badge rounded-full bg-success/20 text-success">
                                        {{ $rekap->berkembang }}
                                    </span>
                                </td>
                                <td class="text-center px-4 py-2">
                                    <span class="badge rounded-full bg-warning/20 text-warning">
                                        {{ $rekap->cukup }}
                                    </span>
                                </td>
                                <td class="text-center px-4 py-2">
                                    <span class="badge rounded-full bg-danger/20 text-danger">
                                        {{ $rekap->kurang }}
                                    </span>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="text-center text-gray-300 px-4 py-3">Belum ada data</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>




        <div class="space-y-4 pt-5">
            <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
                <div class="panel lg:col-span-2">
                    <div class="mb-5 flex items-center justify-between">
                        <h5 class="text-lg font-semibold dark:text-white-light">Statistik Perkembangan Siswa</h5>
                    </div>
                    <div class="mb-5">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            <div>
                                <div class="flex items-center space-x-2">
                                @if(in_array($role, ['admin', 'wali_kelas']))
                                    <select wire:model.live="kelas_id" class="border rounded p-2">
                                        <option value="">Semua Kelas</option>
                                        @foreach($kelasList as $kelas)
                                            <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                                        @endforeach
                                    </select>

                                    <select wire:model.live="bulan" class="border rounded p-2">
                                        @foreach(range(1, 12) as $m)
                                            <option value="{{ str_pad($m, 2, '0', STR_PAD_LEFT) }}">{{ date('F', mktime(0, 0, 0, $m, 1)) }}</option>
                                        @endforeach
                                    </select>
                                    <button wire:ignore onclick="cetakGrafik()" class="btn btn-sm btn-info">Download</button>
                                @endif



                                </div>
                            </div>
                        </div>

                        <div class="card mt-4">
                            {{-- Hanya untuk admin & wali_kelas dan admin--}}
                            @if(in_array($role, ['admin', 'wali_kelas']))
                                <div class="card-body h-[300px]">
                                    <canvas id="chartAspek"></canvas>
                                </div>
                            @endif

                            {{-- Hanya untuk wali_siswa --}}
                            @if($role === 'wali_siswa')
                                <div class="card-body h-[300px]">
                                    <canvas id="ChartPerkembanganwali"></canvas>
                                </div>
                            @endif
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('js')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
<script>
document.addEventListener("livewire:load", () => {
    function renderChart() {
        const canvas = document.getElementById('chartAspek');
        if (!canvas) return; // kalau canvas belum ada, stop

        const ctx = canvas.getContext('2d');
        const chartData = @json($chartAspek);

        const labels = chartData.map(item => item.aspek);
        const data = chartData.map(item => item.rata_rata);

        if (window.myLineChart) {
            window.myLineChart.destroy();
        }

        window.myLineChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: labels,
                datasets: [{
                    label: 'Rata-rata Nilai',
                    data: data,
                    borderColor: '#4e73df',
                    backgroundColor: 'rgba(78, 115, 223, 0.2)',
                    tension: 0.3,
                    fill: true,
                    pointBackgroundColor: '#4e73df',
                    pointRadius: 5
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, max: 10 }
                }
            }
        });
    }

    // Render pertama kali
    renderChart();

    // Render ulang setiap Livewire update DOM
    Livewire.hook('message.processed', (message, component) => {
        renderChart();
    });
});
</script>
@endpush

