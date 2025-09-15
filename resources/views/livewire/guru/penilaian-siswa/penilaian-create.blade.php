<div class="animate__animated p-6 mb-3">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li><a href="javascript:;" class="text-primary hover:underline">Forms</a></li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1"><span>Tambah Penilaian</span></li>
    </ul>

    <div class="space-y-4 pt-5">
        <div class="panel lg:col-span-2">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Tambah Penilaian</h5>
            </div>

            <div class="mb-5">


<div style="position: fixed; top: 100px; right: 20px; width: 350px; z-index: 50;">
    <div class="border rounded-lg shadow p-4 bg-success">
        <h4 style="color: aliceblue" class="text-lg font-semibold mb-2">Keterangan Perkembangan</h4>
        <ul class="space-y-1">
            <li><span style="color: aliceblue" class="font-semibold text-green-600">Berkembang: 8-10</span> </li>
            <li><span style="color: aliceblue" class="font-semibold text-yellow-600">Cukup berkembang: 6-7</span> </li>
            <li><span style="color: aliceblue" class="font-semibold text-red-600">Kurang berkembang: 1-5</span> </li>
        </ul>
    </div>
</div>




                <form wire:submit.prevent="save" class="space-y-5">
                    {{-- Dropdown Siswa --}}
                    <div>
                        <label for="siswa" class="block font-medium">Pilih Siswa</label>
                        <select wire:model="siswa_id" class="w-full border rounded p-2">
                            <option value="">-- Pilih Siswa --</option>
                            @foreach($siswaList as $s)
                                <option value="{{ $s->id }}">
                                    {{ $s->nama_lengkap }} ({{ $s->kelas->nama }})
                                </option>
                            @endforeach
                        </select>
                        @error('siswa_id') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Bulan (format YYYY-MM) --}}
                    <div>
                        <label for="bulan" class="block font-medium">Bulan</label>
                        <input type="month" id="bulan" wire:model="bulan"
                            class="form-input w-full @error('bulan') border-danger @enderror" />
                        @error('bulan') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Loop Aspek --}}
                    @foreach($aspeks as $aspek)
                        <div class="border rounded-md p-4">
                            <h4 class="text-md font-semibold">{{ $aspek->nama }}</h4>

                            {{-- Multiple Select Indikator (murni Livewire, bukan textarea) --}}
                            <div wire:ignore>
                                <label for="indikator-{{ $aspek->id }}" class="block font-medium mt-2">Pilih Indikator</label>
                                <select id="indikator-{{ $aspek->id }}" data-id="{{ $aspek->id }}" class="form-input w-full" multiple>

                                    @foreach($aspek->indikators as $indikator)
                                        <option value="{{ $indikator->id }}">
                                            {{ $indikator->deskripsi ?? $indikator->nama_indikator }}
                                        </option>
                                    @endforeach
                                </select>
                            </div>



                            @error('indikatorSelected.' . $aspek->id)
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror
                            {{-- Input Nilai --}}
                            <label for="nilai-{{ $aspek->id }}" class="mt-2 block font-medium">Nilai Aspek</label>
                            <select id="nilai-{{ $aspek->id }}"
                                    wire:model.defer="nilai_aspek.{{ $aspek->id }}"
                                    class="form-select w-full @error('nilai_aspek.' . $aspek->id) border-danger @enderror">
                                <option value="">-- Pilih Nilai --</option>
                                @for ($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">{{ $i }}</option>
                                @endfor
                            </select>
                            @error('nilai_aspek.' . $aspek->id)
                                <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                            @enderror

                        </div>
                    @endforeach


                    {{-- Pesan Wali --}}
                    <div>
                        <label for="pesanWali" class="block font-medium">Pesan Wali (Opsional)</label>
                        <textarea id="pesanWali" wire:model.defer="pesan_wali" rows="3"
                                class="form-textarea w-full @error('pesan_wali') border-danger @enderror"></textarea>
                        @error('pesan_wali') <p class="text-danger mt-1">{{ $message }}</p> @enderror
                    </div>

                    {{-- Tombol Simpan --}}
                    <div class="flex space-x-2">
                        <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">
                            <span wire:loading.remove>Simpan Penilaian</span>
                            <span wire:loading>Menyimpan...</span>
                        </button>
                    </div>
                </form>

            </div>

        </div>
    </div>
</div>

@push('js')
<script>
document.addEventListener("livewire:navigated", () => {
    document.querySelectorAll("select[id^='indikator-']").forEach(select => {
        let id = select.dataset.id;
        new TomSelect(select, {
            plugins: ['remove_button'],
            create: false,
            onChange: (values) => {
                @this.set(`indikatorSelected.${id}`, values);
            }
        });
    });
});
</script>
@endpush
