<div class="animate__animated p-6 mb-3" :class="[$store.app.animation]">
    <ul class="flex space-x-2 rtl:space-x-reverse">
        <li>
            <a href="javascript:;" class="text-primary hover:underline">Dashboard</a>
        </li>
        <li class="before:content-['/'] ltr:before:mr-1 rtl:before:ml-1">
            <span>Admin</span>
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
            Data Admin
        </h2>
        <div class="flex w-full flex-col gap-4 sm:w-auto sm:flex-row sm:items-center sm:gap-3">
            <div class="flex gap-3">
                <div>
                    <a href="{{route('create.user')}}" wire:navigate type="button" class="btn btn-primary">
                        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" xmlns="http://www.w3.org/2000/svg"
                            class="h-5 w-5 ltr:mr-2 rtl:ml-2">
                            <path d="M15 12L12 12M12 12L9 12M12 12L12 9M12 12L12 15" stroke="currentColor"
                                stroke-width="1.5" stroke-linecap="round" />
                            <path
                                d="M22 12C22 16.714 22 19.0711 20.5355 20.5355C19.0711 22 16.714 22 12 22C7.28595 22 4.92893 22 3.46447 20.5355C2 19.0711 2 16.714 2 12C2 7.28595 2 4.92893 3.46447 3.46447C4.92893 2 7.28595 2 12 2C16.714 2 19.0711 2 20.5355 3.46447C21.5093 4.43821 21.8356 5.80655 21.9449 8"
                                stroke="currentColor" stroke-width="1.5" stroke-linecap="round" />
                        </svg>
                        Tambah Admin
                    </a>

                </div>
            </div>
            <div class="relative">
                <div class="relative">
                    <select id="kategori" wire:model.live="filter" class="form-select w-64 border-gray-300 rounded-md px-12 py-2">
                        <option value="admin">Admin</option>
                        <option value="wali_kelas">Wali Kelas</option>
                        <option value="wali_siswa">Wali Siswa</option>
                    </select>
                </div>
            </div>
            
            <div class="relative">
                <input type="text" placeholder="Cari User" class="peer form-input py-2 ltr:pr-11 rtl:pl-11" wire:model.live="search">
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
                        <th>Nama</th>
                        <th>E-mail</th>
                        <th>Role</th>
                        <th class="!text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($users as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->name }}</td>
                            <td>{{ $item->email }}</td>
                            <td>
                                @if ($item->role == 'wali_kelas')
                                    <span class="badge bg-primary">Wali Kelas</span>
                                @elseif ($item->role == 'wali_siswa')
                                    <span class="badge bg-success">Wali Siswa</span>
                                @elseif ($item->role == 'admin')
                                    <span class="badge bg-danger">Admin</span>
                                @endif
                            </td>
                            <td>
                                    <div class="flex items-center justify-center gap-4">
                                        <a href="{{route('edit.user', $item->id)}}" wire:navigate class="btn btn-sm btn-outline-primary">
                                            Edit
                                        </a>
                                        <button type="button" wire:click.prevent="deleteContirmation({{ $item->id }})" class="btn btn-sm btn-outline-danger">
                                            Delete
                                        </button>
                                    </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @if ($users->hasPages())
        <div class="p-4">
            {{ $users->links() }}
        </div>
    @endif
    
    </div>
</div>