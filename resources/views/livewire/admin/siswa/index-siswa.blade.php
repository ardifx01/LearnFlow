<div class="animate__animated p-6 mb-3" :class="[$store.app.animation]">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Siswa</span>
        </li>
    </ul>
    @if (session()->has('success'))
    <div
        class="relative mb-3 mt-3 flex items-center border p-3.5 rounded text-success bg-success-light border-success ltr:border-l-[64px] rtl:border-r-[64px] dark:bg-success-dark-light">
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
        <span class="ltr:pr-2 rtl:pl-2"><strong
                class="ltr:mr-1 rtl:ml-1">Succes!</strong>{{ session('success') }}</span>
        <button type="button" class="ltr:ml-auto rtl:mr-auto hover:opacity-80">
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    @endif
    @if (session()->has('error'))
    <div
        class="relative mb-3 mt-3 flex items-center border p-3.5 rounded text-danger bg-danger-light border-danger ltr:border-l-[64px] rtl:border-r-[64px] dark:bg-danger-dark-light">
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
            <svg xmlns="http://www.w3.org/2000/svg" width="24px" height="24px" viewBox="0 0 24 24" fill="none"
                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" class="h-5 w-5">
                <line x1="18" y1="6" x2="6" y2="18"></line>
                <line x1="6" y1="6" x2="18" y2="18"></line>
            </svg>
        </button>
    </div>
    @endif

    <!-- Modal Import -->
    {{-- @if($isImporting)
        <div class="panel mt-5 mb-5">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">
                    Import Data Excel |
                    <a href="#" wire:click="downloadTemplate" style="color: blue" class="text-blue-500 hover:underline">
                        Download Template
                    </a>
                </h5>
            </div>
            <div class="mb-5">
                <input type="file" id="file" wire:model.live="file"
                    class="form-input w-full border-gray-300 rounded-md
                    @error('file') border-danger @elseif($file) border-success @enderror" />

                @error('file')
                    <p class="text-danger mt-1">{{ $message }}</p>
                @enderror

                <!-- Flex container untuk tombol -->
                <div class="flex items-center gap-3 mt-4">
                    <button wire:click="$set('isImporting', false)" class="btn btn-warning">Batal</button>
                    <button wire:click="import" class="btn btn-success">Upload</button>
                </div>
            </div>
        </div>
    @endif --}}

    @if($isImporting)
        <div class="panel mt-5 mb-5">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">
                    Import Data Excel |
                    <a href="#" wire:click="downloadTemplate" class="text-blue-500 hover:underline">
                        Unduh format
                    </a>
                </h5>
            </div>

            <div class="mb-5">
                <input type="file" id="file" wire:model="file"
                    class="form-input w-full border-gray-300 rounded-md
                    @error('file') border-danger @elseif($file) border-success @enderror" />

                    @error('file')
                        <p class="text-danger mt-1">{{ $message }}</p>
                    @else
                        @if($file)
                            <p class="text-success mt-1">Looks Good!</p>
                        @endif
                    @enderror

                <!-- TOMBOL -->
                <div class="flex flex-col sm:flex-row gap-3 mt-4">
                    <button wire:click="$set('isImporting', false)"
                        class="btn btn-warning w-full sm:w-auto text-center">
                        Batal
                    </button>

                    <button wire:click="import"
                    class="btn btn-success w-full sm:w-auto flex items-center justify-center gap-2 px-4 py-2 whitespace-nowrap">

                    Unggah

                    <div wire:loading wire:target="import" class="flex items-center gap-2">
                        <svg class="animate-spin h-5 w-5 text-white" viewBox="0 0 24 24" fill="none">
                            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8H4z"></path>
                        </svg>
                        <span class="sr-only">Loading...</span>
                    </div>
                </button>

                </div>
            </div>
        </div>
    @endif





    <div class="flex flex-wrap items-center justify-between mt-3 gap-4">
        <h2 class="text-xl">
            Data Siswa
        </h2>
        <div class="flex w-full flex-col gap-4 sm:w-auto sm:flex-row sm:items-center sm:gap-3">
            @if(auth()->user()->role === 'admin')
                <div class="flex gap-3">
                    <div>
                        <button wire:click="$set('isImporting', true)" type="button" class="btn btn-warning">
                            <svg width="24" class="h-5 w-5 ltr:mr-2 rtl:ml-2" height="24" viewBox="0 0 24 24" fill="none"
                                xmlns="http://www.w3.org/2000/svg">
                                <path
                                    d="M19.3517 7.61665L15.3929 4.05375C14.2651 3.03868 13.7012 2.53114 13.0092 2.26562L13 5.00011C13 7.35713 13 8.53564 13.7322 9.26787C14.4645 10.0001 15.643 10.0001 18 10.0001H21.5801C21.2175 9.29588 20.5684 8.71164 19.3517 7.61665Z"
                                    fill="currentColor" />
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M14 22H10C6.22876 22 4.34315 22 3.17157 20.8284C2 19.6569 2 17.7712 2 14V10C2 6.22876 2 4.34315 3.17157 3.17157C4.34315 2 6.23869 2 10.0298 2C10.6358 2 11.1214 2 11.53 2.01666C11.5166 2.09659 11.5095 2.17813 11.5092 2.26057L11.5 5.09497C11.4999 6.19207 11.4998 7.16164 11.6049 7.94316C11.7188 8.79028 11.9803 9.63726 12.6716 10.3285C13.3628 11.0198 14.2098 11.2813 15.0569 11.3952C15.8385 11.5003 16.808 11.5002 17.9051 11.5001L18 11.5001H21.9574C22 12.0344 22 12.6901 22 13.5629V14C22 17.7712 22 19.6569 20.8284 20.8284C19.6569 22 17.7712 22 14 22ZM4.25 11.5C4.25 10.2574 5.25736 9.25 6.5 9.25H9.5C10.7426 9.25 11.75 10.2574 11.75 11.5C11.75 12.0763 11.5334 12.6019 11.1771 13C11.5334 13.3981 11.75 13.9237 11.75 14.5C11.75 15.7426 10.7426 16.75 9.5 16.75C9.23702 16.75 8.98458 16.7049 8.75 16.622V17.5C8.75 18.7426 7.74264 19.75 6.5 19.75C5.25736 19.75 4.25 18.7426 4.25 17.5C4.25 16.9237 4.46664 16.3981 4.82292 16C4.46664 15.6019 4.25 15.0763 4.25 14.5C4.25 13.9237 4.46664 13.3981 4.82292 13C4.46664 12.6019 4.25 12.0763 4.25 11.5ZM5.75 14.5C5.75 14.0858 6.08579 13.75 6.5 13.75H7.25V15.25H6.5C6.08579 15.25 5.75 14.9142 5.75 14.5ZM7.25 12.25H6.5C6.08579 12.25 5.75 11.9142 5.75 11.5C5.75 11.0858 6.08579 10.75 6.5 10.75H7.25V12.25ZM10.25 11.5C10.25 11.9142 9.91421 12.25 9.5 12.25H8.75V10.75H9.5C9.91421 10.75 10.25 11.0858 10.25 11.5ZM8.75 14.5C8.75 14.0858 9.08579 13.75 9.5 13.75C9.91421 13.75 10.25 14.0858 10.25 14.5C10.25 14.9142 9.91421 15.25 9.5 15.25C9.08579 15.25 8.75 14.9142 8.75 14.5ZM6.5 16.75H7.25V17.5C7.25 17.9142 6.91421 18.25 6.5 18.25C6.08579 18.25 5.75 17.9142 5.75 17.5C5.75 17.0858 6.08579 16.75 6.5 16.75Z"
                                    fill="currentColor" />
                            </svg>

                            Impor .xlsx
                        </button>

                    </div>
                </div>
                <div class="flex gap-3">
                    <div>
                        <a href="{{route('siswa.create')}}" wire:navigate type="button" class="btn btn-primary">
                            <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 ltr:mr-2 rtl:ml-2">
                                <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="currentColor"
                                    stroke-width="1.5" stroke-linecap="round" />
                                <path
                                    d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8"
                                    stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                            </svg>
                            Tambah
                        </a>

                    </div>
                </div>
                <div class="relative">
                    <select id="kelas_id" wire:model.live="kelas_id" class="form-select w-64 border-gray-300 rounded-md px-12 py-2">
                        <option value="">Semua Kelas</option>
                        @foreach($kelasList as $kelas)
                            <option value="{{ $kelas->id }}">{{ $kelas->nama }}</option>
                        @endforeach
                    </select>
                </div>
            @endif

            @if(in_array(Auth::user()->role, ['admin', 'wali_kelas']))
                <div class="relative">
                    <input type="text" placeholder="Cari Siswa" class="peer form-input py-2 ltr:pr-11 rtl:pl-11"
                        wire:model.live="search">
                    <div class="absolute top-1/2 -translate-y-1/2 peer-focus:text-primary ltr:right-[11px] rtl:left-[11px]">
                        <svg class="mx-auto" width="16" height="16" viewBox="0 0 24 24" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <circle cx="11.5" cy="11.5" r="9.5" stroke="currentColor" stroke-width="1.5" opacity="0.5">
                            </circle>
                            <path d="M18.5 18.5L22 22" stroke="currentColor" stroke-width="1.5" stroke-linecap="round">
                            </path>
                        </svg>
                    </div>
                </div>
            @endif
        </div>
    </div>
    <div class="panel mt-5 overflow-hidden border-0 p-0">
        <div class="table-responsive">
            <table class="table-striped table-hover w-full">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Nama Lengkap</th>
                        <th>Email</th>
                        <th>Jenis Kelamin</th>
                        <th>Alamat</th>
                        <th>Kelas</th>
                        <th>Nama Wali</th>
                        <th>Kontak</th>
                        @if(auth()->user()->role === 'admin' || auth()->user()->role === 'wali_siswa')
                            <th class="!text-center">Aksi</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach ($siswa as $index => $item)
                    <tr>
                        <td>{{ $siswa->firstItem() + $index }}</td>
                        <td>{{ $item->nama_lengkap }}</td>
                        <td>{{ $item->wali->user->email ?? '-' }}</td>
                        <td>{{ $item->jk == 'Laki-Laki' ? 'Laki-Laki' : 'Perempuan' }}</td>
                        <td>{{ $item->alamat ?? '-' }}</td>
                        <td>{{ $item->kelas->nama ?? '-' }}</td>
                        <td>{{ $item->wali->user->name ?? '-' }}</td>
                        <td>{{ $item->wali->kontak ?? '-' }}</td>
                            <td>
                                <div class="flex items-center justify-center gap-4">
                                @if(auth()->user()->role === 'admin' || auth()->user()->role === 'wali_siswa')
                                    <a href="{{route('siswa.edit', $item->id)}}" wire:navigate
                                        class="btn btn-sm btn-outline-primary">
                                        Ubah
                                    </a>
                                @endif
                                @if(auth()->user()->role === 'admin')
                                    <button type="button" wire:click.prevent="deleteContirmation({{ $item->id }})"
                                        class="btn btn-sm btn-outline-danger">
                                        Hapus
                                    </button>
                                 @endif

                                </div>
                            </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        @if ($siswa->hasPages())
            <div class="p-4">
                {{ $siswa->links() }}
            </div>
        @endif

</div>
</div>
