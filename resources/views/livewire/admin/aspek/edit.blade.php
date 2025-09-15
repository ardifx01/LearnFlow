<div class="animate__animated p-6" :class="[$store.app.animation]">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Forms</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Tambah Kategori</span>
        </li>
    </ul>
    <div class="space-y-4 pt-5">
        <!-- Basic -->
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            <!-- default -->
            <div class="panel lg:col-span-2">
                <div class="mb-5 flex items-center justify-between">
                    <h5 class="text-lg font-semibold dark:text-white-light">Tambah Kategori</h5>
                </div>

                <div class="mb-5">
                    <form wire:submit.prevent="update" class="space-y-5">
                        <div>
                            <label for="nama" class="block font-medium">Nama Kategori</label>
                            <input type="text" id="nama" wire:model.live="nama" class="form-input w-full border-gray-300 rounded-md 
                            @error('nama') border-danger @elseif($nama) border-success @enderror" />
                            
                            @error('nama')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @else
                                @if($nama)
                                    <p class="text-success mt-1">Looks Good!</p>
                                @endif
                            @enderror
                        </div>   

                        <div class="flex space-x-2">
                            <a href="{{ route('aspek.index') }}" wire:navigate class="btn btn-warning w-full">Batal</a>
                            <button type="submit" class="btn btn-primary w-full">Simpan</button>
                        </div>
                    </form>
                </div>
              
            </div>
        </div>
    </div>
</div>