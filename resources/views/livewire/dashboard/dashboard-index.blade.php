<div class="animate__animated p-6" :class="[$store.app.animation]">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
        </li>
    </ul>

    <div class="space-y-4 pt-5">
        <!-- Panel Header -->
        <div class="panel h-full overflow-hidden border-0 p-0">
            <div class="min-h-[190px] bg-gradient-to-r from-[#4361ee] to-[#160f6b] p-6">
                <div class="mb-6 flex items-center justify-between">
                    <div class="flex items-center rounded-full bg-black/50 p-1 font-semibold text-white ltr:pr-3 rtl:pl-3">
                        <img class="block h-8 w-8 rounded-full border-2 border-white/50 object-cover ltr:mr-1 rtl:ml-1"
                            src="{{ asset('assets/images/user-profile.jpeg')}}" alt="image">
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
        <!-- end Panel Header -->
        @if(in_array($role, ['admin', 'wali_kelas']))
            <!-- Panel Rekap Table -->
            <div class="panel col-span-12">
                <div class="mb-5 text-lg font-bold">Rekap Per Kategori (Bulan {{ $bulan }})</div>

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

                    <!-- Filter Bulan -->
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

                <!-- Table Rekap -->
                <div x-data="{ tooltip: false, title: '', list: [] }" class="table-responsive">

                    {{-- 🔥 Tooltip Global di Atas Halaman --}}
                    <div x-show="tooltip"
                        x-transition
                        class="fixed top-6 left-1/2 -translate-x-1/2 z-50 
                                bg-white text-gray-800 shadow-xl rounded-xl p-4 w-80 border border-gray-200">
                        <h3 class="font-semibold text-lg mb-2"
                            :class="{
                                'text-green-600': title.includes('Berkembang'),
                                'text-yellow-600': title.includes('Cukup Berkembang'),
                                'text-red-600': title.includes('Kurang Berkembang')
                            }"
                            x-text="title">
                        </h3>

                        <ul class="list-disc pl-5 space-y-1 max-h-60 overflow-y-auto">
                            <template x-for="(nama, i) in list" :key="i">
                                <li x-text="nama"></li>
                            </template>
                            <li x-show="list.length === 0" class="text-gray-400">Belum ada data</li>
                        </ul>
                    </div>

                    {{-- 📊 Tabel --}}
                    <table class="w-full">
                        <thead>
                            <tr class="bg-gray-800">
                                <th class="ltr:rounded-l-md rtl:rounded-r-md px-4 py-2">Kategori</th>
                                <th class="text-center px-4 py-2">Berkembang</th>
                                <th class="text-center px-4 py-2">Cukup Berkembang</th>
                                <th class="text-center px-4 py-2 ltr:rounded-r-md rtl:rounded-l-md">Kurang Berkembang</th>
                            </tr>
                        </thead>
                        <tbody class="bg-gray-700">
                            @forelse($rekapAspek as $rekap)
                                <tr class="border-b border-gray-600">
                                    <td class="font-semibold whitespace-nowrap px-4 py-2">{{ $rekap->aspek->nama }}</td>

                                    {{-- ✅ BERKEMBANG --}}
                                    <td class="text-center px-4 py-2">
                                        <span class="badge rounded-full bg-success/20 text-success cursor-pointer"
                                            @mouseenter="tooltip = true; title = 'Siswa Berkembang (8-10)'; list = {{ json_encode(array_filter(explode(',', $rekap->siswa_berkembang ?? ''))) }}"
                                            @mouseleave="tooltip = false">
                                            {{ $rekap->berkembang }}
                                        </span>
                                    </td>

                                    {{-- ✅ CUKUP --}}
                                    <td class="text-center px-4 py-2">
                                        <span class="badge rounded-full bg-warning/20 text-warning cursor-pointer"
                                            @mouseenter="tooltip = true; title = 'Siswa Cukup Berkembang (6-7)'; list = {{ json_encode(array_filter(explode(',', $rekap->siswa_cukup ?? ''))) }}"
                                            @mouseleave="tooltip = false">
                                            {{ $rekap->cukup }}
                                        </span>
                                    </td>

                                    {{-- ✅ KURANG --}}
                                    <td class="text-center px-4 py-2">
                                        <span class="badge rounded-full bg-danger/20 text-danger cursor-pointer"
                                            @mouseenter="tooltip = true; title = 'Siswa Kurang Berkembang (1-5)'; list = {{ json_encode(array_filter(explode(',', $rekap->siswa_kurang ?? ''))) }}"
                                            @mouseleave="tooltip = false">
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
            <!-- end Panel Rekap Table -->
        @endif

        <!-- Panel Chart -->
        <div class="p-12">
            <div class="panel bg-gray-900 p-6 rounded-2xl shadow-xl">
                <h2 class="text-lg font-semibold text-gray-200 mb-3">
                    📊 Grafik Perkembangan 
                    @if($role === 'wali_siswa')
                        Anak Didik
                    @else
                        Siswa
                    @endif
                </h2>
                <div class="flex flex-col sm:flex-row gap-3 sm:items-center mb-4">
        
                    <div class="w-full sm:w-48">
                        <label class="block text-sm mb-1">Chart</label>
                        <select wire:model.live="chartType" class="form-select">
                            <option value="line">Line Chart</option>
                            <option value="bar">Bar Chart</option>
                        </select>
                    </div>
                    @if($role === 'wali_siswa')

                        <div class="w-full sm:w-48">
                            <label for="tahun">Filter Tahun:</label>
                            <select wire:model.live="tahun" id="tahun" class="form-select">
                                @foreach(range(date('Y'), date('Y') - 5) as $y)
                                    <option value="{{ $y }}">{{ $y }}</option>
                                @endforeach
                            </select>
                        </div>
                    @endif


                </div>

                @if(in_array($role, ['admin', 'wali_kelas']))
                    <div id="chart" wire:ignore class="w-full h-[400px]"></div>
                @endif

                @if($role === 'wali_siswa')
                    <div id="chartWali" wire:ignore class="w-full h-[400px]"></div>
                @endif
            </div>
        </div>


    </div> <!-- end space-y-4 -->
</div> <!-- end animate__animated -->

@push('js')
<script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>
<script>
    let chart;

    function renderChart(elId, type, categories, values) {
        const options = {
            chart: {
                type: type,
                height: 400,
                toolbar: {
                    show: true,
                    tools: {
                        download: true,
                        selection: true,
                        zoom: true,
                        zoomin: true,
                        zoomout: true,
                        pan: true,
                        reset: true
                    }
                },
                foreColor: '#d1d5db',
                fontFamily: 'Inter, sans-serif',
                animations: {
                    enabled: true,
                    easing: 'easeinout',
                    speed: 800,
                    animateGradually: { enabled: true, delay: 150 },
                    dynamicAnimation: { enabled: true, speed: 350 }
                }
            },
            series: [{
                name: 'Nilai Akhir',
                data: values
            }],
            colors: [
                '#3b82f6', // biru
                '#10b981', // hijau
                '#f59e0b', // kuning
                '#ef4444', // merah
                '#8b5cf6', // ungu
                '#ec4899', // pink
                '#14b8a6', // tosca
                '#f97316', // oranye
            ],
            xaxis: {
                categories: categories,
                labels: {
                    style: {
                        fontSize: '12px',
                        colors: categories.map((_, i) => [
                            '#3b82f6','#10b981','#f59e0b','#ef4444',
                            '#8b5cf6','#ec4899','#14b8a6','#f97316'
                        ][i % 8])
                    },
                    rotate: -45
                }
            },
            yaxis: {
                min: 0,
                max: 100,
                labels: {
                    style: { fontSize: '12px', colors: '#d1d5db' }
                }
            },
            grid: {
                borderColor: '#374151',
                strokeDashArray: 4
            },
            stroke: {
                width: type === 'line' || type === 'area' ? 3 : 0,
                curve: 'smooth'
            },
            fill: {
                type: type === 'area' ? 'gradient' : 'solid',
                gradient: {
                    shadeIntensity: 0.8,
                    opacityFrom: 0.6,
                    opacityTo: 0.1,
                    stops: [0, 90, 100]
                }
            },
            dataLabels: {
                enabled: true,
                style: { fontSize: '11px', colors: ['#fff'] },
                background: {
                    enabled: true,
                    foreColor: '#000',
                    borderRadius: 4,
                    padding: 4,
                    opacity: 0.8,
                    dropShadow: { enabled: true, top: 1, left: 1, blur: 2, opacity: 0.3 }
                }
            },
            tooltip: {
                theme: 'dark',
                style: { fontSize: '12px' },
                y: { formatter: (val) => val + " poin" }
            },
            legend: {
                show: true,
                position: 'top',
                horizontalAlign: 'center',
                labels: { colors: '#d1d5db' }
            },
            plotOptions: {
                bar: {
                    distributed: true, // 🔹 bikin tiap bar beda warna
                    borderRadius: 6
                }
            }
        };

        if (chart) chart.destroy();
        chart = new ApexCharts(document.querySelector(elId), options);
        chart.render();
    }


    // 🔹 Tangkap event dari Livewire
    Livewire.on('refreshChart', (payload) => {
        console.log("📊 Data chart diterima:", payload);

        if (payload.chartData && payload.chartData.categories && payload.chartData.values) {
            // Tentukan id elemen sesuai role
            const elId = @json($role) === 'wali_siswa' ? "#chartWali" : "#chart";
            renderChart(elId, payload.chartType, payload.chartData.categories, payload.chartData.values);
        }
    });
</script>
@endpush
