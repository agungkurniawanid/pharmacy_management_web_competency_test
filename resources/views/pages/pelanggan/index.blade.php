@extends('layouts.main-layout')

@section('content')
<div class="flex flex-col gap-6" 
    x-data="{ 
        showAddSheet: {{ old('_method') !== 'PUT' && $errors->any() ? 'true' : 'false' }},
        showEditSheet: {{ old('_method') === 'PUT' && $errors->any() ? 'true' : 'false' }},
        createAccount: {{ old('create_account') ? 'true' : 'false' }},
        editFormAction: '{{ old('_method') === 'PUT' && old('kode_pelanggan') ? route('dashboard.pelanggan.update', old('kode_pelanggan')) : '' }}',
        editData: {
            kode_pelanggan: '{{ old('kode_pelanggan') }}',
            nama_pelanggan: '{{ old('nama_pelanggan') }}',
            alamat: '{{ old('alamat') }}',
            kota: '{{ old('kota') }}',
            telpon: '{{ old('telpon') }}',
            has_account: false
        }
    }"
    @open-edit.window="
        const item = $event.detail.pelanggan;
        editFormAction = $event.detail.actionUrl;
        editData.kode_pelanggan = item.kode_pelanggan;
        editData.nama_pelanggan = item.nama_pelanggan;
        editData.alamat = item.alamat;
        editData.kota = item.kota;
        editData.telpon = item.telpon;
        editData.has_account = item.has_account;
        showEditSheet = true;
    ">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">Data Pelanggan</h1>
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" /></svg>
                Manajemen data pelanggan, apotek rekanan, atau pembeli umum
            </p>
        </div>
        <button type="button" @click="showAddSheet = true; createAccount = false" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Tambah Pelanggan Baru
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
                <p class="text-slate-400 text-sm font-medium mb-1">Total Pelanggan</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ number_format($totalPelanggan) }}</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
                <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-md">Total Semua</span>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Aktif Transaksi</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ number_format($aktifTransaksi) }}</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-orange-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" /></svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Asal Kota</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $totalKota }} Kota</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-purple-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" /></svg>
                </div>
                <span class="px-2.5 py-1 bg-purple-500/10 text-purple-400 text-xs font-medium rounded-md">Bulan Ini</span>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Pelanggan Baru</p>
                <h3 class="text-2xl font-bold text-slate-100">+{{ $pelangganBaruBulanIni }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & Tabel --}}
    <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-sm overflow-hidden">
        
        <div class="p-5 border-b border-slate-700 bg-slate-800/50">
            <form action="{{ route('dashboard.pelanggan.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3" x-data x-ref="filterForm">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" @input.debounce.500ms="$refs.filterForm.submit()"
                           placeholder="Cari Kode atau Nama Pelanggan..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="kota" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="">Semua Kota</option>
                        @foreach($kotasList as $kota)
                            <option value="{{ $kota }}" {{ request('kota') == $kota ? 'selected' : '' }}>{{ $kota }}</option>
                        @endforeach
                    </select>

                    <select name="sort" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru Ditambahkan</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="name_desc" {{ request('sort') == 'name_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>

                    @if(request('search') || request('kota') || request('sort'))
                        <a href="{{ route('dashboard.pelanggan.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg font-medium transition-colors flex items-center justify-center">Reset</a>
                    @endif
                    <noscript><button type="submit" class="hidden">Filter</button></noscript>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/50 border-b border-slate-700 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="px-5 py-4 font-semibold">Kode & Status Akun</th>
                        <th class="px-5 py-4 font-semibold">Nama Pelanggan</th>
                        <th class="px-5 py-4 font-semibold">Alamat</th>
                        <th class="px-5 py-4 font-semibold">Kota</th>
                        <th class="px-5 py-4 font-semibold">No. Telepon</th>
                        <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    
                    @forelse($pelanggans as $item)
                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex flex-col gap-1">
                                <span class="text-sm font-mono font-medium text-blue-400">{{ $item->kode_pelanggan }}</span>
                                @if($item->user_id)
                                    <span class="inline-flex items-center gap-1 w-max px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg> Member
                                    </span>
                                @else
                                    <span class="inline-flex items-center gap-1 w-max px-2 py-0.5 rounded text-[10px] font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" /></svg> Offline
                                    </span>
                                @endif
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-slate-100">{{ $item->nama_pelanggan }}</span>
                        </td>
                        <td class="px-5 py-4">
                            @if($item->alamat)
                                <span class="text-sm text-slate-300">{{ Str::limit($item->alamat, 40) }}</span>
                            @else
                                <span class="text-sm text-slate-500 italic">Belum ada alamat</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-300">{{ $item->kota ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-300">{{ $item->telpon ?? '-' }}</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" 
                                    data-item="{{ json_encode([
                                        'kode_pelanggan' => $item->kode_pelanggan,
                                        'nama_pelanggan' => $item->nama_pelanggan,
                                        'alamat' => $item->alamat,
                                        'kota' => $item->kota,
                                        'telpon' => $item->telpon,
                                        'has_account' => $item->user_id ? true : false
                                    ]) }}"
                                    @click="
                                        const data = JSON.parse($el.getAttribute('data-item'));
                                        window.dispatchEvent(new CustomEvent('open-edit', {
                                            detail: { pelanggan: data, actionUrl: '{{ route('dashboard.pelanggan.update', $item->kode_pelanggan) }}' }
                                        }))
                                    "
                                    class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                <button type="button"
                                    @click="window.dispatchEvent(new CustomEvent('open-confirm', {
                                        detail: {
                                            title: 'Hapus Pelanggan?',
                                            message: 'Data {{ $item->nama_pelanggan }} akan dihapus secara permanen dari sistem.',
                                            actionUrl: '{{ route('dashboard.pelanggan.destroy', $item->kode_pelanggan) }}',
                                            method: 'DELETE',
                                            btnText: 'Hapus',
                                            btnColor: 'bg-red-600 hover:bg-red-700 focus:ring-red-500'
                                        }
                                    }))"
                                    class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                            Tidak ada data pelanggan yang ditemukan.
                        </td>
                    </tr>
                    @endforelse

                </tbody>
            </table>
        </div>

        {{-- Pagination Dinamis --}}
        @if ($pelanggans->hasPages())
        <div class="px-5 py-4 border-t border-slate-700 bg-slate-800/50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-slate-400">
                    Menampilkan <span class="font-medium text-slate-200">{{ $pelanggans->firstItem() }}</span> 
                    - <span class="font-medium text-slate-200">{{ $pelanggans->lastItem() }}</span> 
                    dari <span class="font-medium text-slate-200">{{ $pelanggans->total() }}</span>
                </div>

                <div class="flex items-center gap-1">
                    @if ($pelanggans->onFirstPage())
                        <span class="p-2 text-slate-600 cursor-not-allowed">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                        </span>
                    @else
                        <a href="{{ $pelanggans->previousPageUrl() }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                        </a>
                    @endif

                    @foreach ($pelanggans->links()->elements as $element)
                        @if (is_string($element))
                            <span class="px-2 text-slate-500">{{ $element }}</span>
                        @endif

                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $pelanggans->currentPage())
                                    <span class="px-3 py-1 bg-blue-600 text-white rounded font-medium text-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}" class="px-3 py-1 text-slate-400 hover:text-white hover:bg-slate-700 rounded text-sm transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    @if ($pelanggans->hasMorePages())
                        <a href="{{ $pelanggans->nextPageUrl() }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
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

    {{-- MODAL TAMBAH PELANGGAN --}}
    <div x-show="showAddSheet" style="display: none;"
         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="fixed inset-x-0 bottom-0 z-[70] w-full max-w-2xl mx-auto flex flex-col max-h-[90vh] bg-slate-800 border-t border-x border-slate-700 rounded-t-3xl shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.7)]">
        
        <div class="w-full flex justify-center pt-3 pb-1 cursor-pointer" @click="showAddSheet = false">
            <div class="w-16 h-1.5 bg-slate-600 rounded-full hover:bg-slate-500 transition-colors"></div>
        </div>

        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between shrink-0">
            <h2 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                <span class="p-1.5 bg-blue-500/20 text-blue-400 rounded-lg"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg></span>
                Tambah Data Pelanggan
            </h2>
            <button type="button" @click="showAddSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formTambahPelanggan" action="{{ route('dashboard.pelanggan.store') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- TOGGLE BUAT AKUN --}}
                <div class="p-4 bg-slate-900/50 border border-slate-700 rounded-xl flex items-center justify-between">
                    <div>
                        <h4 class="text-sm font-semibold text-slate-200">Buatkan Akun Login?</h4>
                        <p class="text-xs text-slate-400 mt-0.5">Jika aktif, pelanggan ini bisa login ke aplikasi (Member).</p>
                    </div>
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" name="create_account" value="1" class="sr-only peer" x-model="createAccount">
                        <div class="w-11 h-6 bg-slate-600 rounded-full peer peer-checked:after:translate-x-full peer-checked:after:border-white after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-slate-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all peer-checked:bg-blue-500"></div>
                    </label>
                </div>

                {{-- FORM EMAIL & PASSWORD (Animasi Muncul) --}}
                <div x-show="createAccount" x-collapse>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 p-4 bg-blue-500/10 border border-blue-500/20 rounded-xl mb-6">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Alamat Email <span class="text-red-400">*</span></label>
                            <input type="email" name="email" value="{{ old('email') }}" :required="createAccount" placeholder="email@contoh.com"
                                class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            @error('email') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-1.5">Password <span class="text-red-400">*</span></label>
                            <input type="password" name="password" :required="createAccount" placeholder="Minimal 6 karakter"
                                class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            @error('password') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                        </div>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_pelanggan" value="{{ old('nama_pelanggan') }}" required 
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('nama_pelanggan') <span class="text-xs text-red-400 mt-1 block">{{ $message }}</span> @enderror
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">No. Telepon / WA</label>
                        <input type="text" name="telpon" value="{{ old('telpon') }}" placeholder="Contoh: 08123456789"
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>

                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Kota</label>
                        <input type="text" name="kota" value="{{ old('kota') }}" placeholder="Contoh: Surabaya"
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>

                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Alamat Lengkap</label>
                        <textarea name="alamat" rows="2" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">{{ old('alamat') }}</textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showAddSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Batal</button>
            <button type="submit" form="formTambahPelanggan" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                Simpan
            </button>
        </div>
    </div>

    {{-- MODAL EDIT PELANGGAN --}}
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
                Edit Data Pelanggan
            </h2>
            <button type="button" @click="showEditSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formEditPelanggan" :action="editFormAction" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                
                {{-- Info Peringatan --}}
                <template x-if="editData.has_account">
                    <div class="flex gap-3 p-4 bg-amber-500/10 border border-amber-500/20 rounded-lg text-amber-400 text-sm mb-4">
                        <svg class="size-5 flex-shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                        <div>Perhatian: Pelanggan ini memiliki akun login. Mengubah "Nama Lengkap" di sini juga akan otomatis mengubah nama profil akun mereka.</div>
                    </div>
                </template>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Kode Pelanggan (Read Only)</label>
                        <input type="text" x-model="editData.kode_pelanggan" readonly disabled class="w-full px-4 py-2 bg-slate-800 border border-slate-700 rounded-lg text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Nama Lengkap <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_pelanggan" x-model="editData.nama_pelanggan" required 
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">No. Telepon / WA</label>
                        <input type="text" name="telpon" x-model="editData.telpon" 
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Kota</label>
                        <input type="text" name="kota" x-model="editData.kota" 
                            class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-1.5">Alamat Lengkap</label>
                        <textarea name="alamat" x-model="editData.alamat" rows="2" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500"></textarea>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showEditSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Batal</button>
            <button type="submit" form="formEditPelanggan" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-900 rounded-lg font-bold transition-colors flex items-center gap-2">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg> Update
            </button>
        </div>
    </div>
</div>
@endsection