<div class="animate__animated p-6" :class="[$store.app.animation]">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Forms</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Tambah Wali Siswa</span>
        </li>
    </ul>
    <div class="space-y-4 pt-5">
        <!-- Basic -->
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            <!-- default -->
            <div class="panel lg:col-span-2">
                <div class="mb-5 flex items-center justify-between">
                    <h5 class="text-lg font-semibold dark:text-white-light">Tambah Wali Siswa</h5>
                </div>

                <div class="mb-5">
                    <form wire:submit.prevent="store" class="space-y-5">
                        <div>
                            <label for="name" class="block font-medium">Nama Wali Siswa</label>
                            <input type="text" id="name" wire:model.live="name" class="form-input w-full border-gray-300 rounded-md 
                            @error('name') border-danger @elseif($name) border-success @enderror" />
                            
                            @error('name')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @else
                                @if($name)
                                    <p class="text-success mt-1">Looks Good!</p>
                                @endif
                            @enderror
                        </div>   

                        <div>
                            <label for="email" class="block font-medium">Email</label>
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
                        
                        <div>
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

                        <div>
                            <label for="kontak" class="block font-medium">Kontak </label>
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

                        <div class="flex space-x-2">
                            <a href="{{ route('walikelas.index') }}" wire:navigate class="btn btn-warning w-full">Batal</a>
                            <button type="submit" class="btn btn-primary w-full">Simpan</button>
                        </div>
                    </form>
                </div>
              
            </div>
        </div>
    </div>
</div>