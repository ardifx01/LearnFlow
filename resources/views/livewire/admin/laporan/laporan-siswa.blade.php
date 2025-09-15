<div class="animate__animated p-6 mb-3" :class="[$store.app.animation]">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Penilaian</span>
        </li>
    </ul>
    @if (session()->has('success'))
        <div class="relative mb-3 mt-3 flex items-center border p-3.5 rounded text-success bg-success-light border-success ltr:border-l-[64px] rtl:border-r-[64px] dark:bg-success-dark-light">
            <span class="absolute ltr:-left-11 rtl:-right-11 inset-y-0 text-white w-6 h-6 m-auto">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6">
                    <path
                        d="M19.0001 9.7041V9C19.0001 5.13401 15.8661 2 12.0001 2C8.13407 2 5.00006 5.13401 5.00006 9V9.7041C5.00006 10.5491 4.74995 11.3752 4.28123 12.0783L3.13263 13.8012C2.08349 15.3749 2.88442 17.5139 4.70913 18.0116C9.48258 19.3134 14.5175 19.3134 19.291 18.0116C21.1157 17.5139 21.9166 15.3749 20.8675 13.8012L19.7189 12.0783C19.2502 11.3752 19.0001 10.5491 19.0001 9.7041Z"
                        stroke="currentColor" stroke-width="1.5"></path>
                    <path d="M7.5 19C8.15503 20.7478 9.92246 22 12 22C14.0775 22 15.845 20.7478 16.5 19"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    <path d="M12 6V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
            </span>
            <span class="ltr:pr-2 rtl:pl-2"><strong class="ltr:mr-1 rtl:ml-1">Succes!</strong>{{ session('success') }}</span>
            <button type="button" class="ltr:ml-auto rtl:mr-auto hover:opacity-80">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    @endif
    @if (session()->has('error'))
        <div class="relative mb-3 mt-3 flex items-center border p-3.5 rounded text-danger bg-danger-light border-danger ltr:border-l-[64px] rtl:border-r-[64px] dark:bg-danger-dark-light">
            <span class="absolute ltr:-left-11 rtl:-right-11 inset-y-0 text-white w-6 h-6 m-auto">
                <svg width="20" height="20" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                    class="h-6 w-6">
                    <path
                        d="M19.0001 9.7041V9C19.0001 5.13401 15.8661 2 12.0001 2C8.13407 2 5.00006 5.13401 5.00006 9V9.7041C5.00006 10.5491 4.74995 11.3752 4.28123 12.0783L3.13263 13.8012C2.08349 15.3749 2.88442 17.5139 4.70913 18.0116C9.48258 19.3134 14.5175 19.3134 19.291 18.0116C21.1157 17.5139 21.9166 15.3749 20.8675 13.8012L19.7189 12.0783C19.2502 11.3752 19.0001 10.5491 19.0001 9.7041Z"
                        stroke="currentColor" stroke-width="1.5"></path>
                    <path d="M7.5 19C8.15503 20.7478 9.92246 22 12 22C14.0775 22 15.845 20.7478 16.5 19"
                        stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    <path d="M12 6V10" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                </svg>
            </span>
            <span class="ltr:pr-2 rtl:pl-2"><strong class="ltr:mr-1 rtl:ml-1">Error!</strong>{{ session('error') }}</span>
            <button type="button" class="ltr:ml-auto rtl:mr-auto hover:opacity-80">
                <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                    <line x1="18" y1="6" x2="6" y2="18"></line>
                    <line x1="6" y1="6" x2="18" y2="18"></line>
                </svg>
            </button>
        </div>
    @endif

    <div class="flex flex-wrap items-center justify-between mt-3 gap-4">
        <h2 class="text-xl">
            Data Penilaian
        </h2>
        <div class="flex w-full flex-col gap-4 sm:w-auto sm:flex-row sm:items-center sm:gap-3">
            @if(auth()->user()->role === 'wali_kelas')
                <div class="flex gap-3">
                    <div>
                        <a href="{{route('penilaian.create')}}" type="button" class="btn btn-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ltr:mr-2 rtl:ml-2">
                                <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" />
                                <path
                                    d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Add
                        </a>

                    </div>
                </div>
            @endif



            <div class="relative">
                <div class="flex">
                    @if(auth()->user()->role === 'admin')
                    <!-- Filter Kelas -->
                    <select id="kelas" wire:model.live="kelas_id" class="border rounded p-2">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                        @endforeach
                    </select>
                    @endif
                    <!-- Filter Bulan -->
                    <input type="month" id="bulan" wire:model.live="bulan" class="border rounded p-2">
                </div>
            </div>
            
            <div class="relative">
                <input type="text" placeholder="Cari berdasarkan nama" class="peer form-input py-2 ltr:pr-11 rtl:pl-11" wire:model.live="search">
                <div class="absolute top-1/2 -translate-y-1/2 peer-focus:text-primary ltr:right-[11px] rtl:left-[11px]">
                    <svg class="mx-auto" width="16" height="16" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5"></circle>
                        <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"></path>
                    </svg>
                </div>
            </div>
        </div>
    </div>
    <div class="panel mt-5 overflow-hidden border-0 p-0">
        <div class="table-responsive">
            <table class="table-striped table-hover">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Siswa</th>
                        <th>Kelas</th>
                        <th>Tes</th>
                        <th class="!text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswaList as $index => $siswa)
                    <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $siswa->nama_lengkap }}</td>
                            <td>{{ $siswa->kelas->nama }}</td>
                            <td>{{ optional($siswa->penilaian->first())->nilai_agama ?? '-' }}</td>
                            <td>
                                <div class="flex items-center justify-center gap-4">
                                    <button wire:click="generatePDF({{ $siswa->id }})" class="btn btn-sm btn-primary">
                                        <svg class="h-5 w-5 shrink-0 ltr:mr-1.5 rtl:ml-1.5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M19.3517 7.61665L15.3929 4.05375C14.2651 3.03868 13.7012 2.53114 13.0092 2.26562L13 5.00011C13 7.35713 13 8.53564 13.7322 9.26787C14.4645 10.0001 15.643 10.0001 18 10.0001H21.5801C21.2175 9.29588 20.5684 8.71164 19.3517 7.61665Z" fill="currentColor"/>
                                            <path fill-rule="evenodd" clip-rule="evenodd" d="M10 22H14C17.7712 22 19.6569 22 20.8284 20.8284C22 19.6569 22 17.7712 22 14V13.5629C22 12.6901 22 12.0344 21.9574 11.5001H18L17.9051 11.5001C16.808 11.5002 15.8385 11.5003 15.0569 11.3952C14.2098 11.2813 13.3628 11.0198 12.6716 10.3285C11.9803 9.63726 11.7188 8.79028 11.6049 7.94316C11.4998 7.16164 11.4999 6.19207 11.5 5.09497L11.5092 2.26057C11.5095 2.17813 11.5166 2.09659 11.53 2.01666C11.1214 2 10.6358 2 10.0298 2C6.23869 2 4.34315 2 3.17157 3.17157C2 4.34315 2 6.22876 2 10V14C2 17.7712 2 19.6569 3.17157 20.8284C4.34315 22 6.22876 22 10 22ZM7.98704 19.0472C8.27554 19.3176 8.72446 19.3176 9.01296 19.0472L11.013 17.1722C11.3151 16.8889 11.3305 16.4142 11.0472 16.112C10.7639 15.8099 10.2892 15.7945 9.98704 16.0778L9.25 16.7688L9.25 13.5C9.25 13.0858 8.91421 12.75 8.5 12.75C8.08579 12.75 7.75 13.0858 7.75 13.5V16.7688L7.01296 16.0778C6.71077 15.7945 6.23615 15.8099 5.95285 16.112C5.66955 16.4142 5.68486 16.8889 5.98704 17.1722L7.98704 19.0472Z" fill="currentColor"/>
                                            </svg>
                                            
                                        PDF
                                    </button>

                                    @if(auth()->user()->role === 'wali_kelas')

                                    <button type="button" wire:click="kirimEmail({{ $siswa->id }})" 
                                        class="btn btn-sm {{ $siswa->laporanPengiriman && $siswa->laporanPengiriman->email_terkirim ? 'btn-success' : 'btn-warning' }}">

                                        <!-- Loading indicator when the specific email is being sent -->
                                        <span wire:loading.remove wire:target="kirimEmail({{ $siswa->id }})">
                                            <svg class="h-5 w-5 shrink-0 ltr:mr-1.5 rtl:ml-1.5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M22 6C22 7.65685 20.6569 9 19 9C17.3431 9 16 7.65685 16 6C16 4.34315 17.3431 3 19 3C20.6569 3 22 4.34315 22 6Z" fill="currentColor"/>
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M14 5H10C6.22876 5 4.34315 5 3.17157 6.17157C2 7.34315 2 9.22876 2 13C2 16.7712 2 18.6569 3.17157 19.8284C4.34315 21 6.22876 21 10 21H14C17.7712 21 19.6569 21 20.8284 19.8284C22 18.6569 22 16.7712 22 13C22 11.5466 22 10.3733 21.9329 9.413C21.1453 10.0905 20.1205 10.5 19 10.5C18.5213 10.5 18.0601 10.4253 17.6274 10.2868L16.2837 11.4066C15.3973 12.1452 14.6789 12.7439 14.0448 13.1517C13.3843 13.5765 12.7411 13.8449 12 13.8449C11.2589 13.8449 10.6157 13.5765 9.95518 13.1517C9.32112 12.7439 8.60271 12.1452 7.71636 11.4066L5.51986 9.57617C5.20165 9.31099 5.15866 8.83807 5.42383 8.51986C5.68901 8.20165 6.16193 8.15866 6.48014 8.42383L8.63903 10.2229C9.57199 11.0004 10.2197 11.5384 10.7666 11.8901C11.2959 12.2306 11.6549 12.3449 12 12.3449C12.3451 12.3449 12.7041 12.2306 13.2334 11.8901C13.7803 11.5384 14.428 11.0004 15.361 10.2229L16.2004 9.52335C15.1643 8.69893 14.5 7.42704 14.5 6C14.5 5.65638 14.5385 5.32175 14.6115 5.0002C14.4133 5 14.2096 5 14 5Z" fill="currentColor"/>
                                            </svg>
                                        </span>
                                        
                                        <span wire:loading wire:target="kirimEmail({{ $siswa->id }})">
                                            <svg class="h-5 w-5 shrink-0 ltr:mr-1.5 rtl:ml-1.5 animate-spin h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                        </span>
                                        
                                        Gmail
                                    </button>

                                    <button wire:click="kirimWhatsApp({{ $siswa->id }}, '{{ $bulan }}')" 
                                        class="btn btn-sm {{ $siswa->laporanPengiriman && $siswa->laporanPengiriman->wa_terkirim ? 'btn-success' : 'btn-warning' }}">

                                        <!-- Loading indicator when the specific WhatsApp is being sent -->
                                        <span wire:loading.remove wire:target="kirimWhatsApp({{ $siswa->id }}, '{{ $bulan }}')">
                                            <svg class="h-5 w-5 shrink-0 ltr:mr-1.5 rtl:ml-1.5" width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M22 12C22 17.5228 17.5228 22 12 22C10.4003 22 8.88837 21.6244 7.54753 20.9565C7.19121 20.7791 6.78393 20.72 6.39939 20.8229L4.17335 21.4185C3.20701 21.677 2.32295 20.793 2.58151 19.8267L3.17712 17.6006C3.28001 17.2161 3.22094 16.8088 3.04346 16.4525C2.37562 15.1116 2 13.5997 2 12C2 6.47715 6.47715 2 12 2C17.5228 2 22 6.47715 22 12ZM15.5303 9.46967C15.8232 9.76256 15.8232 10.2374 15.5303 10.5303L11.5303 14.5303C11.2417 14.819 10.7751 14.8238 10.4806 14.541L8.4806 12.621C8.18179 12.3342 8.1721 11.8594 8.45896 11.5606C8.74582 11.2618 9.22059 11.2521 9.5194 11.539L10.9893 12.9501L14.4697 9.46967C14.7626 9.17678 15.2374 9.17678 15.5303 9.46967Z" fill="currentColor"/>
                                            </svg>
                                        </span>
                                        
                                        <span wire:loading wire:target="kirimWhatsApp({{ $siswa->id }}, '{{ $bulan }}')">
                                            <svg class="h-5 w-5 shrink-0 ltr:mr-1.5 rtl:ml-1.5 animate-spin h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                                                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                                            </svg>
                                        </span>
                                        
                                        WhatsApp
                                    </button>

                                    @endif
                                    
                                    
                                </div>
                            </td>
                            
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($siswaList->hasPages())
            <div class="p-4">
                {{ $siswaList->links() }}
            </div>
        @endif
    </div>
</div>