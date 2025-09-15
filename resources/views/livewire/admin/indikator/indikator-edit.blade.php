<div class="animate__animated p-6" :class="[$store.app.animation]">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Forms</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Tambah Indikator</span>
        </li>
    </ul>
    <div class="space-y-4 pt-5">
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            <div class="panel lg:col-span-2">
                <div class="mb-5 flex items-center justify-between">
                    <h5 class="text-lg font-semibold dark:text-white-light">Tambah Indikator</h5>
                </div>

                <div class="mb-5">
                    <form wire:submit.prevent="update" class="space-y-5">
                        
                        <!-- Pilih Aspek -->
                        <div>
                            <label for="aspek_id" class="block font-medium">Pilih Kategori</label>
                            <select id="aspek_id" wire:model.live="aspek_id" 
                                class="form-select w-full border-gray-300 rounded-md
                                @error('aspek_id') border-danger @elseif($aspek_id) border-success @enderror">
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($aspeks as $aspek)
                                    <option value="{{ $aspek->id }}">{{ $aspek->nama }}</option>
                                @endforeach
                            </select>
                            @error('aspek_id')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <!-- Input Indikator Dinamis -->
                        <div>
                            <label class="block font-medium">Nama Indikator</label>
                            
                            @foreach($nama_indikator as $index => $value)
                                <div class="flex items-center space-x-2 mb-2">
                                    <input type="text" wire:model.live="nama_indikator.{{ $index }}" 
                                        class="form-input w-full border-gray-300 rounded-md
                                        @error('nama_indikator.' . $index) border-danger @enderror" 
                                        placeholder="Masukkan nama indikator ke-{{ $index+1 }}" />

                                    <button type="button" class="btn btn-danger"
                                        wire:click="removeNamaIndikator({{ $index }})">Hapus</button>
                                </div>
                                @error('nama_indikator.' . $index)
                                    <p class="text-danger text-sm">{{ $message }}</p>
                                @enderror
                            @endforeach

                            <button type="button" class="btn btn-success mt-2"
                                wire:click="addNamaIndikator">+ Tambah Indikator</button>
                        </div>

                        <!-- Tombol -->
                        <div class="flex space-x-2">
                            <a href="{{ route('indikator.index') }}" wire:navigate class="btn btn-warning w-full">Batal</a>
                            <button type="submit" class="btn btn-primary w-full">Simpan</button>
                        </div>
                    </form>
                </div>
              
            </div>
        </div>
    </div>
</div>
