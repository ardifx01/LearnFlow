<div class="animate__animated p-6" :class="[$store.app.animation]">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Form</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Setting</span>
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
        <div class="alert alert-danger">{{ session('error') }}</div>
    @endif

    <div class="space-y-4 pt-5">
        <!-- Basic -->
        <div class="grid grid-cols-1 gap-4 xl:grid-cols-2">
            <!-- default -->
            <div class="panel lg:col-span-2">
                <div class="mb-5 flex items-center justify-between">
                    <h5 class="text-lg font-semibold dark:text-white-light">Setting App</h5>
                </div>

                <div class="mb-5">
                    <form wire:submit.prevent="save" class="space-y-5">
                        @csrf

                        <div>
                            <label for="app_name" class="block font-medium">Nama App</label>
                            <input type="text" id="app_name" wire:model.defer="app_name" class="form-input w-full border-gray-300 rounded-md @error('app_name') border-danger @elseif($app_name) border-success @enderror" />
                            @error('app_name')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>

                        <div>
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" class="form-checkbox" wire:model="show_logo" @checked($show_logo)>
                                <span class="text-white-dark">Show Logo</span>
                            </label>
                        
                            <label class="flex items-center cursor-pointer">
                                <input type="checkbox" class="form-checkbox" wire:model="show_name" @checked($show_name)>
                                <span class="text-white-dark">Show Text Logo</span>
                            </label>
                        </div>
                        

                        <div>
                            <label for="app_logo" class="block font-medium">Logo App</label>
                            <input type="file" id="app_logo" wire:model.defer="app_logo" class="form-input w-full border-gray-300 rounded-md @error('app_logo') border-danger @elseif($app_logo) border-success @enderror" />
                            
                            @error('app_logo')
                                <p class="text-danger mt-1">{{ $message }}</p>
                            @enderror
                        </div>
                        
                        <button wire:click="save" type="submit" class="btn btn-primary w-full">Simpan</button>
                    </form>
                </div>
              
            </div>
        </div>
    </div>
</div>