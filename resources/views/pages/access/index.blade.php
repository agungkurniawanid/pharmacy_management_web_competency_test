@extends('layouts.main-layout')

@section('content')
<div class="flex flex-col gap-6"
    x-data="{ 
        showAddSheet: {{ old('_method') !== 'PUT' && $errors->any() ? 'true' : 'false' }},
        showEditSheet: {{ old('_method') === 'PUT' && $errors->any() ? 'true' : 'false' }},
        selectedRoleId: '{{ old('role_id') }}',
        editFormAction: '',
        editData: {
            id: '', name: '', email: '', role_id: ''
        },
        // Fungsi helper untuk mengecek apakah role ID yang dipilih adalah pelanggan
        isPelangganRole: function(roleId) {
            if(!roleId) return false;
            // Cari nama role dari option yang terpilih (asumsi nama rolenya mengandung kata 'pelanggan')
            const el = document.querySelector(`select[name='role_id'] option[value='${roleId}']`);
            return el ? el.text.toLowerCase().includes('pelanggan') : false;
        }
    }"
    @open-edit.window="
        const item = $event.detail.user;
        editFormAction = $event.detail.actionUrl;
        editData.id = item.id;
        editData.name = item.name;
        editData.email = item.email;
        editData.role_id = item.role_id;
        showEditSheet = true;
    ">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">Manajemen Pengguna</h1>
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" /></svg>
                Kelola akun staf, kasir, admin, dan hak akses sistem
            </p>
        </div>
        <button type="button" @click="showAddSheet = true; selectedRoleId = ''" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
            Tambah User Baru
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-blue-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Total Pengguna</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $totalPengguna }}</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-purple-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="px-2.5 py-1 bg-purple-500/10 text-purple-400 text-xs font-medium rounded-md">Full Access</span>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Pemilik / Manajer</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $totalPemilik }}</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-orange-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" /></svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Admin Gudang</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $totalGudang }}</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" /></svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Kasir Aktif</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $totalKasir }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & Tabel --}}
    <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-700 bg-slate-800/50">
            <form action="{{ route('dashboard.access.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3" x-data x-ref="filterForm">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" @input.debounce.500ms="$refs.filterForm.submit()"
                           placeholder="Cari Nama Pengguna atau Email..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="role" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="">Semua Role</option>
                        @foreach($roles as $role)
                            <option value="{{ $role->id }}" {{ request('role') == $role->id ? 'selected' : '' }}>{{ $role->nama_role }}</option>
                        @endforeach
                    </select>

                    <select name="sort" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru Ditambahkan</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>

                    @if(request('search') || request('role') || request('sort'))
                        <a href="{{ route('dashboard.access.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg font-medium transition-colors flex items-center justify-center">Reset</a>
                    @endif
                    <noscript><button type="submit" class="hidden">Filter</button></noscript>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/50 border-b border-slate-700 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="px-5 py-4 font-semibold">Pengguna</th>
                        <th class="px-5 py-4 font-semibold">Email</th>
                        <th class="px-5 py-4 font-semibold">Hak Akses (Role)</th>
                        <th class="px-5 py-4 font-semibold">Ditambahkan</th>
                        <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    
                    @forelse($users as $user)
                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                {{-- Warna inisial menyesuaikan Role --}}
                                @php
                                    $color = 'slate';
                                    $roleName = strtolower($user->role->nama_role ?? '');
                                    if(str_contains($roleName, 'pemilik') || str_contains($roleName, 'admin')) $color = 'purple';
                                    elseif(str_contains($roleName, 'gudang')) $color = 'orange';
                                    elseif(str_contains($roleName, 'kasir')) $color = 'emerald';
                                    elseif(str_contains($roleName, 'pelanggan')) $color = 'blue';
                                @endphp
                                <div class="grid size-9 shrink-0 place-content-center rounded-lg bg-{{$color}}-500/20 text-sm font-bold text-{{$color}}-400 border border-{{$color}}-500/30">
                                    {{ strtoupper(substr($user->name, 0, 2)) }}
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-100">{{ $user->name }}</span>
                                    @if(Auth::id() == $user->id)
                                        <span class="text-[10px] text-emerald-400">Sedang Anda Gunakan</span>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-300">{{ $user->email }}</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-{{$color}}-500/10 text-{{$color}}-400 border border-{{$color}}-500/20">
                                {{ $user->role->nama_role ?? 'Tanpa Role' }}
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-400">{{ \Carbon\Carbon::parse($user->created_at)->format('d M Y') }}</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" 
                                    data-item="{{ json_encode(['id' => $user->id, 'name' => $user->name, 'email' => $user->email, 'role_id' => $user->role_id]) }}"
                                    @click="
                                        const data = JSON.parse($el.getAttribute('data-item'));
                                        window.dispatchEvent(new CustomEvent('open-edit', {
                                            detail: { user: data, actionUrl: '{{ route('dashboard.access.update', $user->id) }}' }
                                        }))
                                    "
                                    class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit Pengguna">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                
                                @if(Auth::id() == $user->id)
                                    <button type="button" class="p-1.5 text-slate-600 cursor-not-allowed rounded" title="Tidak dapat menghapus akun Anda sendiri">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                @else
                                    <button type="button"
                                        @click="window.dispatchEvent(new CustomEvent('open-confirm', {
                                            detail: {
                                                title: 'Hapus Pengguna?',
                                                message: 'Anda yakin ingin menghapus akses login {{ $user->name }}?',
                                                actionUrl: '{{ route('dashboard.access.destroy', $user->id) }}',
                                                method: 'DELETE',
                                                btnText: 'Hapus Akses',
                                                btnColor: 'bg-red-600 hover:bg-red-700 focus:ring-red-500'
                                            }
                                        }))"
                                        class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Hapus Pengguna">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                    </button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-5 py-10 text-center text-slate-500">Belum ada pengguna terdaftar.</td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination --}}
        @if ($users->hasPages())
        <div class="px-5 py-4 border-t border-slate-700 bg-slate-800/50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-slate-400">
                    Menampilkan <span class="font-medium text-slate-200">{{ $users->firstItem() }}</span> 
                    - <span class="font-medium text-slate-200">{{ $users->lastItem() }}</span> 
                    dari <span class="font-medium text-slate-200">{{ $users->total() }}</span>
                </div>
                <div class="flex items-center gap-1">
                    @if ($users->onFirstPage())
                        <span class="p-2 text-slate-600 cursor-not-allowed">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                        </span>
                    @else
                        <a href="{{ $users->previousPageUrl() }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                        </a>
                    @endif
                    @foreach ($users->links()->elements as $element)
                        @if (is_string($element))
                            <span class="px-2 text-slate-500">{{ $element }}</span>
                        @endif
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $users->currentPage())
                                    <span class="px-3 py-1 bg-blue-600 text-white rounded font-medium text-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-1 text-slate-400 hover:text-white hover:bg-slate-700 rounded text-sm transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach
                    @if ($users->hasMorePages())
                        <a href="{{ $users->nextPageUrl() }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                        </a>
                    @else
                        <span class="p-2 text-slate-600 cursor-not-allowed">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- MODAL TAMBAH USER --}}
    <div x-show="showAddSheet" style="display: none;"
         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="fixed inset-x-0 bottom-0 z-[70] w-full max-w-2xl mx-auto flex flex-col max-h-[90vh] bg-slate-800 border-t border-x border-slate-700 rounded-t-3xl shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.7)]">
        
        <div class="w-full flex justify-center pt-3 pb-1 cursor-pointer" @click="showAddSheet = false">
            <div class="w-16 h-1.5 bg-slate-600 rounded-full hover:bg-slate-500 transition-colors"></div>
        </div>

        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between shrink-0">
            <h2 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                <span class="p-1.5 bg-blue-500/20 text-blue-400 rounded-lg"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg></span>
                Buat Akses Pengguna Baru
            </h2>
            <button type="button" @click="showAddSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formTambahUser" action="{{ route('dashboard.access.store') }}" method="POST" class="space-y-6">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Role (Hak Akses) <span class="text-red-400">*</span></label>
                        <select name="role_id" required x-model="selectedRoleId" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="" disabled selected>Pilih Hak Akses</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                            @endforeach
                        </select>
                        @error('role_id') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="Nama Lengkap"
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('name') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Email Login <span class="text-red-400">*</span></label>
                        <input type="email" name="email" value="{{ old('email') }}" required placeholder="email@contoh.com"
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('email') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Password <span class="text-red-400">*</span></label>
                        <input type="password" name="password" required placeholder="Minimal 6 karakter"
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('password') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>
                </div>

                {{-- FORM DINAMIS KHUSUS PELANGGAN --}}
                <div x-show="isPelangganRole(selectedRoleId)" x-collapse>
                    <div class="mt-2 p-4 bg-emerald-500/10 border border-emerald-500/20 rounded-xl space-y-4">
                        <h4 class="text-sm font-bold text-emerald-400 flex items-center gap-2">
                            <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                            Lengkapi Data Profil Pelanggan
                        </h4>
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-emerald-200/70 mb-1.5">No. Telepon / WA</label>
                                <input type="text" name="telpon" value="{{ old('telpon') }}" placeholder="Opsional" class="w-full px-4 py-2 bg-slate-900 border border-emerald-500/30 rounded-lg text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-emerald-200/70 mb-1.5">Kota</label>
                                <input type="text" name="kota" value="{{ old('kota') }}" placeholder="Opsional" class="w-full px-4 py-2 bg-slate-900 border border-emerald-500/30 rounded-lg text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                            </div>
                            <div class="md:col-span-2">
                                <label class="block text-sm font-medium text-emerald-200/70 mb-1.5">Alamat Lengkap</label>
                                <textarea name="alamat" rows="2" class="w-full px-4 py-2 bg-slate-900 border border-emerald-500/30 rounded-lg text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">{{ old('alamat') }}</textarea>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showAddSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Batal</button>
            <button type="submit" form="formTambahUser" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Simpan Pengguna</button>
        </div>
    </div>

    {{-- MODAL EDIT USER --}}
    <div x-show="showEditSheet" style="display: none;"
         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="fixed inset-x-0 bottom-0 z-[75] w-full max-w-2xl mx-auto flex flex-col max-h-[90vh] bg-slate-800 border-t border-x border-slate-700 rounded-t-3xl shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.7)]">
        
        <div class="w-full flex justify-center pt-3 pb-1 cursor-pointer" @click="showEditSheet = false">
            <div class="w-16 h-1.5 bg-slate-600 rounded-full hover:bg-slate-500 transition-colors"></div>
        </div>

        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between shrink-0">
            <h2 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                <span class="p-1.5 bg-amber-500/20 text-amber-400 rounded-lg"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></span>
                Edit Data Pengguna
            </h2>
            <button type="button" @click="showEditSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formEditUser" :action="editFormAction" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Role (Hak Akses) <span class="text-red-400">*</span></label>
                        <select name="role_id" required x-model="editData.role_id" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->nama_role }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="name" x-model="editData.name" required 
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Email Login <span class="text-red-400">*</span></label>
                        <input type="email" name="email" x-model="editData.email" required 
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Password Baru</label>
                        <input type="password" name="password" placeholder="Kosongkan jika tidak ingin diubah"
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500 placeholder-slate-600">
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showEditSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Batal</button>
            <button type="submit" form="formEditUser" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-900 rounded-lg font-bold transition-colors">Update Pengguna</button>
        </div>
    </div>
</div>
@endsection