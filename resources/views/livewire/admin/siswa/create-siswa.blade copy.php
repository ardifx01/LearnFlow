<div class="animate__animated p-6" :class="[$store.app.animation]">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Forms</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Tambah Siswa</span>
        </li>
    </ul>
    <div class="space-y-4 pt-5">
        <!-- Basic -->
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            <!-- default -->
            <div class="panel lg:row-span-2">
                <div class="mb-5 flex items-center justify-between">
                    <h5 class="text-lg font-semibold dark:text-white-light">Tambah Data</h5>
                </div>
                <div class="mb-5" x-data="{ activeTab: 1}">
                    <div class="inline-block w-full">
                        <ul class="mb-5 grid grid-cols-2">
                            <li>
                                <a href="javascript:;" class="bg-[#f3f2ee] dark:bg-[#1b2e4b] flex justify-center items-center p-2.5 rounded-full" :class="{'!bg-primary text-white': activeTab === 1}" @click="activeTab = 1">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M14.217 3.49965C12.796 2.83345 11.2035 2.83345 9.78252 3.49965L5.48919 5.51246C6.27114 5.59683 6.98602 6.0894 7.31789 6.86377C7.80739 8.00594 7.2783 9.32867 6.13613 9.81817L5.06046 10.2792C4.52594 10.5082 4.22261 10.6406 4.01782 10.7456C4.0167 10.7619 4.01564 10.7788 4.01465 10.7962L9.78261 13.5003C11.2036 14.1665 12.7961 14.1665 14.2171 13.5003L20.9082 10.3634C22.3637 9.68105 22.3637 7.31899 20.9082 6.63664L14.217 3.49965Z" fill="currentColor"/>
                                        <path d="M4.9998 12.9147V16.6254C4.9998 17.6334 5.50331 18.5772 6.38514 19.0656C7.85351 19.8787 10.2038 21 11.9998 21C13.7958 21 16.1461 19.8787 17.6145 19.0656C18.4963 18.5772 18.9998 17.6334 18.9998 16.6254V12.9148L14.8538 14.8585C13.0294 15.7138 10.9703 15.7138 9.14588 14.8585L4.9998 12.9147Z" fill="currentColor"/>
                                        <path d="M5.54544 8.43955C5.92616 8.27638 6.10253 7.83547 5.93936 7.45475C5.7762 7.07403 5.33529 6.89767 4.95456 7.06083L3.84318 7.53714C3.28571 7.77603 2.81328 7.97849 2.44254 8.18705C2.04805 8.40898 1.70851 8.66944 1.45419 9.05513C1.19986 9.44083 1.09421 9.85551 1.04563 10.3055C0.999964 10.7284 0.999981 11.2424 1 11.8489V14.7502C1 15.1644 1.33579 15.5002 1.75 15.5002C2.16422 15.5002 2.5 15.1644 2.5 14.7502V11.8878C2.5 11.232 2.50101 10.7995 2.53696 10.4665C2.57095 10.1517 2.63046 9.99612 2.70645 9.88087C2.78244 9.76562 2.90202 9.64964 3.178 9.49438C3.46985 9.33019 3.867 9.15889 4.46976 8.90056L5.54544 8.43955Z" fill="currentColor"/>
                                        </svg>
                                        Data Siswa
                                </a>
                            </li>
                            <li>
                                <a href="javascript:;" class="bg-[#f3f2ee] dark:bg-[#1b2e4b] flex justify-center items-center p-2.5 rounded-full" :class="{'!bg-primary text-white': activeTab === 2}" @click="activeTab = 2">
                                    <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <circle cx="9.00098" cy="6" r="4" fill="currentColor"/>
                                        <ellipse cx="9.00098" cy="17.001" rx="7" ry="4" fill="currentColor"/>
                                        <path d="M20.9996 17.0005C20.9996 18.6573 18.9641 20.0004 16.4788 20.0004C17.211 19.2001 17.7145 18.1955 17.7145 17.0018C17.7145 15.8068 17.2098 14.8013 16.4762 14.0005C18.9615 14.0005 20.9996 15.3436 20.9996 17.0005Z" fill="currentColor"/>
                                        <path d="M17.9996 6.00073C17.9996 7.65759 16.6565 9.00073 14.9996 9.00073C14.6383 9.00073 14.292 8.93687 13.9712 8.81981C14.4443 7.98772 14.7145 7.02522 14.7145 5.99962C14.7145 4.97477 14.4447 4.01294 13.9722 3.18127C14.2927 3.06446 14.6387 3.00073 14.9996 3.00073C16.6565 3.00073 17.9996 4.34388 17.9996 6.00073Z" fill="currentColor"/>
                                        </svg>  Data Wali Siswa
                                </a>
                            </li>
                        </ul>
                        <div class="mb-5">
                            <form wire:submit.prevent="store" class="space-y-5">
                                <template x-if="activeTab === 1">
                                    <div class="mb-5">
                                            <div>
                                                <label for="nama_lengkap" class="block font-medium">Nama Lengkap Siswa</label>
                                                <input type="text" id="nama_lengkap" wire:model.live="nama_lengkap" class="form-input w-full border-gray-300 rounded-md 
                                                @error('nama_lengkap') border-danger @elseif($nama_lengkap) border-success @enderror" />
                                                
                                                @error('nama_lengkap')
                                                    <p class="text-danger mt-1">{{ $message }}</p>
                                                @else
                                                    @if($nama_lengkap)
                                                        <p class="text-success mt-1">Looks Good!</p>
                                                    @endif
                                                @enderror
                                            </div>   
                    
                                            <div>
                                                <label for="nama_panggilan" class="block font-medium">Nama panggilan</label>
                                                <input type="text" id="nama_panggilan" wire:model.live="nama_panggilan" class="form-input w-full border-gray-300 rounded-md 
                                                @error('nama_panggilan') border-danger @elseif($nama_panggilan) border-success @enderror" />
                                                
                                                @error('nama_panggilan')
                                                    <p class="text-danger mt-1">{{ $message }}</p>
                                                @else
                                                    @if($nama_panggilan)
                                                        <p class="text-success mt-1">Looks Good!</p>
                                                    @endif
                                                @enderror
                                            </div>   
                    
                                            <div>
                                                <label for="tetala" class="block font-medium">TGL Lahir</label>
                                                <input type="date" id="tetala" wire:model.live="tetala" class="form-input w-full border-gray-300 rounded-md 
                                                @error('tetala') border-danger @elseif($tetala) border-success @enderror" />
                                                
                                                @error('tetala')
                                                    <p class="text-danger mt-1">{{ $message }}</p>
                                                @else
                                                    @if($tetala)
                                                        <p class="text-success mt-1">Looks Good!</p>
                                                    @endif
                                                @enderror
                                            </div>   
                    
                                            <div>
                                                <label for="alamat" class="block font-medium">Alamat</label>
                                                <input type="text" id="alamat" wire:model.live="alamat" class="form-input w-full border-gray-300 rounded-md 
                                                @error('alamat') border-danger @elseif($alamat) border-success @enderror" />
                                                
                                                @error('alamat')
                                                    <p class="text-danger mt-1">{{ $message }}</p>
                                                @else
                                                    @if($alamat)
                                                        <p class="text-success mt-1">Looks Good!</p>
                                                    @endif
                                                @enderror
                                            </div>   
                    
                                            <div>
                                                <label for="jk" class="block font-medium">Jenis Kelamin</label>
                                                <select id="jk" wire:model.live="jk" class="form-input w-full border-gray-300 rounded-md
                                                @error('jk') border-danger @elseif($jk) border-success @enderror">
                                                    <option value="">-- Pilih Jenis Kelamin --</option>
                                                        <option value="Laki-Laki">Laki-Laki</option>
                                                        <option value="Perempuan">Perempuan</option>
                                                </select>
                                                @error('jk')
                                                    <p class="text-danger mt-1">{{ $message }}</p>
                                                @else
                                                    @if($jk)
                                                        <p class="text-success mt-1">Looks Good!</p>
                                                    @endif
                                                @enderror
                                            </div>
                                            <div>
                                                <label for="kelas_id" class="block font-medium">Kelas</label>
                                                <select id="kelas_id" wire:model.live="kelas_id" class="form-input w-full border-gray-300 rounded-md
                                                @error('kelas_id') border-danger @elseif($kelas_id) border-success @enderror">
                                                    <option value="">-- Pilih Kelas --</option>
                                                    @foreach ($kelas as $k)
                                                        <option value="{{ $k->id }}">{{ $k->nama }}</option>
                                                    @endforeach
                                                </select>
                                                @error('kelas_id')
                                                    <p class="text-danger mt-1">{{ $message }}</p>
                                                @else
                                                    @if($kelas_id)
                                                        <p class="text-success mt-1">Looks Good!</p>
                                                    @endif
                                                @enderror
                                            </div>
                                    </div>
                                </template>
                                <template x-if="activeTab === 2">
                                    <div class="mb-3">
                                        <div>
                                            <label for="nama_wali" class="block font-medium">Nama Wali siswa</label>
                                            <input type="text" id="nama_wali" wire:model.live="nama_wali" class="form-input w-full border-gray-300 rounded-md 
                                            @error('nama_wali') border-danger @elseif($nama_wali) border-success @enderror" />
                                            
                                            @error('nama_wali')
                                                <p class="text-danger mt-1">{{ $message }}</p>
                                            @else
                                                @if($nama_wali)
                                                    <p class="text-success mt-1">Looks Good!</p>
                                                @endif
                                            @enderror
                                        </div>  
                                        <div>
                                            <label for="kontak" class="block font-medium">No WA</label>
                                            <input type="text" id="kontak" wire:model.live="kontak" class="form-input w-full border-gray-300 rounded-md 
                                            @error('kontak') border-danger @elseif($kontak) border-success @enderror" />
                                            
                                            @error('kontak')
                                                <p class="text-danger mt-1">{{ $message }}</p>
                                            @else
                                                @if($kontak)
                                                    <p class="text-success mt-1">Looks Good!</p>
                                                @endif
                                            @enderror
                                        </div>  
                                        <div>
                                            <label for="email" class="block font-medium">E-Mail</label>
                                            <input type="email" id="email" wire:model.live="email" class="form-input w-full border-gray-300 rounded-md 
                                            @error('email') border-danger @elseif($email) border-success @enderror" />
                                            
                                            @error('email')
                                                <p class="text-danger mt-1">{{ $message }}</p>
                                            @else
                                                @if($email)
                                                    <p class="text-success mt-1">Looks Good!</p>
                                                @endif
                                            @enderror
                                        </div>  
                                        <div class="mb-3">
                                            <label for="password" class="block font-medium">Password</label>
                                            <input type="password" id="password" wire:model.live="password" class="form-input w-full border-gray-300 rounded-md 
                                            @error('password') border-danger @elseif($password) border-success @enderror" />
                                            
                                            @error('password')
                                                <p class="text-danger mt-1">{{ $message }}</p>
                                            @else
                                                @if($password)
                                                    <p class="text-success mt-1">Looks Good!</p>
                                                @endif
                                            @enderror
                                        </div>  
                                        <div class="flex space-x-2">
                                            <button type="submit" class="btn btn-success w-full">Simpan</button>
                                        </div>
                                    </div>
                                </template>
                            </form>
                        </div>
                        <div class="flex justify-between">
                            <button type="button" class="btn btn-primary" :disabled="activeTab === 1" @click="activeTab--">Back</button>
                            <button type="button" class="btn btn-primary" :disabled="activeTab === 2" @click="activeTab++">Next</button>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</div>