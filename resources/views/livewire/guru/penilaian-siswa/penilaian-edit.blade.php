<div class="animate__animated p-6 mb-3">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li><a href="javascript:;" class="text-primary hover:underline">Forms</a></li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1"><span>Edit Penilaian</span></li>
    </ul>

    <div class="space-y-4 pt-5">
        <div class="panel lg:col-span-2">
            <div class="mb-5 flex items-center justify-between">
                <h5 class="text-lg font-semibold dark:text-white-light">Edit Penilaian</h5>
            </div>

            <div class="mb-5">
                <form wire:submit.prevent="update" class="space-y-5">

                    {{-- Nama Siswa (readonly, tidak bisa diganti) --}}
                    <div>
                        <label class="block font-medium">Siswa</label>
                        <input type="text" value="{{ $penilaian->siswa->nama_lengkap }} ({{ $penilaian->siswa->kelas->nama }})"
                            class="form-input w-full bg-gray-100 cursor-not-allowed" readonly>
                    </div>

                    {{-- Bulan --}}
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

                            {{-- Multiple Select Indikator --}}
                            <div wire:ignore>
                                <label for="indikator-{{ $aspek->id }}" class="block font-medium mt-2">Pilih Indikator</label>
                                <select id="indikator-{{ $aspek->id }}" data-id="{{ $aspek->id }}" class="form-input w-full" multiple>
                                    @foreach($aspek->indikators as $indikator)
                                        <option value="{{ $indikator->id }}"
                                            @if(isset($indikatorSelected[$aspek->id]) && in_array($indikator->id, $indikatorSelected[$aspek->id]))
                                                selected
                                            @endif
                                        >
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
                                    <option value="{{ $i }}"
                                        @if(isset($nilai_aspek[$aspek->id]) && $nilai_aspek[$aspek->id] == $i) selected @endif>
                                        {{ $i }}
                                    </option>
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

                    {{-- Tombol Update --}}
                    <div class="flex space-x-2">
                        <button type="submit" class="btn btn-primary w-full" wire:loading.attr="disabled">
                            <span wire:loading.remove>Update Penilaian</span>
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
