@extends('layouts.main-layout')

@section('content')
{{-- Alpine Data --}}
<div x-data="{ 
        showAddSheet: {{ old('_method') !== 'PUT' && $errors->any() ? 'true' : 'false' }},
        showEditSheet: {{ old('_method') === 'PUT' && $errors->any() ? 'true' : 'false' }},
        editFormAction: '{{ old('_method') === 'PUT' && old('kode_supplier_edit') ? route('dashboard.supplier.update', old('kode_supplier_edit')) : '' }}',
        editData: {
            kode_supplier: '{{ old('kode_supplier_edit') }}',
            nama_supplier: '{{ old('nama_supplier') }}',
            alamat: '{{ old('alamat') }}',
            kota: '{{ old('kota') }}',
            telpon: '{{ old('telpon') }}',
            aktif: {{ old('aktif', 'true') === 'on' || old('aktif') === '1' || old('aktif') === 1 ? 'true' : 'false' }},
            catatan: '{{ old('catatan') }}'
        },
        
        showDetailSheet: false,
        detailData: {
            kode_supplier: '',
            nama_supplier: '',
            alamat: '',
            kota: '',
            telpon: '',
            aktif: false,
            catatan: '',
            created_at: ''
        }
    }" 
    @open-edit.window="
        const item = $event.detail.supplier;
        editFormAction   = $event.detail.actionUrl;
        editData.kode_supplier = item.kode_supplier;
        editData.nama_supplier = item.nama_supplier;
        editData.alamat = item.alamat;
        editData.kota = item.kota;
        editData.telpon = item.telpon;
        editData.aktif = item.aktif;
        editData.catatan = item.catatan;
        showEditSheet = true;
    "
    @open-detail.window="
        const item = $event.detail.supplier;
        detailData.kode_supplier = item.kode_supplier;
        detailData.nama_supplier = item.nama_supplier;
        detailData.alamat = item.alamat;
        detailData.kota = item.kota;
        detailData.telpon = item.telpon;
        detailData.aktif = item.aktif;
        detailData.catatan = item.catatan;
        detailData.created_at = item.created_at;
        showDetailSheet = true;
    "
    class="flex flex-col gap-6 pb-12 relative">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">Data Supplier</h1>
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg>
                Manajemen data mitra penyedia dan pemasok obat
            </p>
        </div>
        <button type="button" @click="showAddSheet = true" 
                class="inline-flex cursor-pointer text-[14px] items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-lg shadow-blue-500/20">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Supplier Baru
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-5 gap-4">
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-blue-500/10 rounded-lg"><svg class="size-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg></div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Total Supplier</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $totalSupplier }}</h3>
            </div>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-emerald-500/10 rounded-lg"><svg class="size-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
                <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-md">Mitra Aktif</span>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Status Aktif</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $supplierAktif }}</h3>
            </div>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-red-500/10 rounded-lg"><svg class="size-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 17h8m0 0V9m0 8l-8-8-4 4m0 0L3 5m0 0v8m0-8l4 4" /></svg></div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Tidak Aktif</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $supplierNonaktif }}</h3>
            </div>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-orange-500/10 rounded-lg"><svg class="size-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Cakupan Kota</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $kotaCakupan }}</h3>
            </div>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-purple-500/10 rounded-lg"><svg class="size-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" /></svg></div>
                <span class="px-2.5 py-1 bg-purple-500/10 text-purple-400 text-xs font-medium rounded-md">Bulan Ini</span>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Supplier Baru</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $supplierBaru }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & Tabel --}}
    <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-700 bg-slate-800/50">
            <form action="{{ route('dashboard.supplier.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3" x-data x-ref="filterForm">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="size-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" @input.debounce.500ms="$refs.filterForm.submit()"
                           placeholder="Cari Nama Supplier, Kota, atau Telepon..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="status" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="">Semua Status</option>
                        <option value="aktif" {{ request('status') == 'aktif' ? 'selected' : '' }}>Mitra Aktif</option>
                        <option value="nonaktif" {{ request('status') == 'nonaktif' ? 'selected' : '' }}>Tidak Aktif</option>
                    </select>
                    <select name="sort" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="nama_asc" {{ request('sort') == 'nama_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="nama_desc" {{ request('sort') == 'nama_desc' ? 'selected' : '' }}>Nama Z-A</option>
                    </select>
                    @if(request('search') || request('status') || request('sort'))
                        <a href="{{ route('dashboard.supplier.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg font-medium transition-colors flex items-center justify-center">Reset</a>
                    @endif
                    <noscript><button type="submit" class="hidden">Filter</button></noscript>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/50 border-b border-slate-700 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="px-5 py-4 font-semibold">Kode</th>
                        <th class="px-5 py-4 font-semibold">Nama Supplier</th>
                        <th class="px-5 py-4 font-semibold">Kota</th>
                        <th class="px-5 py-4 font-semibold">Telepon</th>
                        <th class="px-5 py-4 font-semibold">Status</th>
                        <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($suppliers as $item)
                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap"><span class="text-sm font-mono font-medium text-blue-400">{{ $item->kode_supplier }}</span></td>
                        <td class="px-5 py-4">
                            <div>
                                <p class="text-sm font-medium text-slate-100">{{ $item->nama_supplier }}</p>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap"><span class="text-sm text-slate-300">{{ $item->kota ?? '-' }}</span></td>
                        <td class="px-5 py-4 whitespace-nowrap"><span class="text-sm text-slate-300">{{ $item->telpon ?? '-' }}</span></td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($item->aktif)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400">Aktif</span>
                            @else
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-red-500/10 text-red-400">Tidak Aktif</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" 
                                    data-detail="{{ json_encode([
                                        'kode_supplier' => $item->kode_supplier,
                                        'nama_supplier' => $item->nama_supplier,
                                        'alamat' => $item->alamat,
                                        'kota' => $item->kota,
                                        'telpon' => $item->telpon,
                                        'aktif' => $item->aktif,
                                        'catatan' => $item->catatan,
                                        'created_at' => \Carbon\Carbon::parse($item->created_at)->translatedFormat('d F Y')
                                    ]) }}"
                                    @click="
                                        const data = JSON.parse($el.getAttribute('data-detail'));
                                        window.dispatchEvent(new CustomEvent('open-detail', {
                                            detail: { supplier: data }
                                        }))
                                    "
                                    class="p-1.5 text-slate-400 hover:text-blue-400 hover:bg-slate-700 rounded transition-colors"
                                    title="Lihat Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </button>
                                <button type="button" 
                                    data-item="{{ json_encode([
                                        'kode_supplier' => $item->kode_supplier,
                                        'nama_supplier' => $item->nama_supplier,
                                        'alamat' => $item->alamat,
                                        'kota' => $item->kota,
                                        'telpon' => $item->telpon,
                                        'aktif' => $item->aktif,
                                        'catatan' => $item->catatan
                                    ]) }}"
                                    @click="
                                        const data = JSON.parse($el.getAttribute('data-item'));
                                        window.dispatchEvent(new CustomEvent('open-edit', {
                                            detail: { supplier: data, actionUrl: '{{ route('dashboard.supplier.update', $item->kode_supplier) }}' }
                                        }))
                                    "
                                    class="p-1.5 cursor-pointer text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit Data">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                
                                <button type="button"
                                   @click="window.dispatchEvent(new CustomEvent('open-confirm', {
                                       detail: {
                                           title: 'Hapus Supplier?',
                                           message: 'Data supplier {{ $item->nama_supplier }} akan dihapus permanen. Pastikan tidak ada pembelian atau obat yang terkait!',
                                           actionUrl: '{{ route('dashboard.supplier.destroy', $item->kode_supplier) }}',
                                           method: 'DELETE',
                                           btnText: 'Hapus Supplier',
                                           btnColor: 'bg-red-600 hover:bg-red-700 focus:ring-red-500'
                                       }
                                   }))"
                                   class="p-1.5 cursor-pointer text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Hapus">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                            Tidak ada data supplier. Silakan tambah supplier baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination yang Konsisten --}}
        @if ($suppliers->hasPages())
        <div class="px-5 py-4 border-t border-slate-700 bg-slate-800/50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">

                <div class="text-sm text-slate-400">
                    Menampilkan <span class="font-medium text-slate-200">{{ $suppliers->firstItem() }}</span>
                    - <span class="font-medium text-slate-200">{{ $suppliers->lastItem() }}</span>
                    dari <span class="font-medium text-slate-200">{{ $suppliers->total() }}</span>
                </div>

                <div class="flex items-center gap-1">
                    {{-- Tombol Previous --}}
                    @if ($suppliers->onFirstPage())
                        <span class="p-2 text-slate-600 cursor-not-allowed">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $suppliers->previousPageUrl() }}"
                            class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    @endif

                    {{-- Angka Pagination dengan separator (...) --}}
                    @foreach ($suppliers->links()->elements as $element)
                        {{-- Separator Tiga Titik --}}
                        @if (is_string($element))
                            <span class="px-2 text-slate-500">{{ $element }}</span>
                        @endif

                        {{-- Deretan Angka --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $suppliers->currentPage())
                                    <span class="px-3 py-1 bg-blue-600 text-white rounded font-medium text-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-3 py-1 text-slate-400 hover:text-white hover:bg-slate-700 rounded text-sm transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($suppliers->hasMorePages())
                        <a href="{{ $suppliers->nextPageUrl() }}"
                            class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </a>
                    @else
                        <span class="p-2 text-slate-600 cursor-not-allowed">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                            </svg>
                        </span>
                    @endif
                </div>
            </div>
        </div>
        @endif
    </div>

    {{-- Add Sheet --}}
    <div x-show="showAddSheet" style="display: none;"
         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="fixed inset-x-0 bottom-0 z-[70] w-full max-w-4xl mx-auto flex flex-col max-h-[95vh] min-h-[50vh] bg-slate-800 border-t border-x border-slate-700 rounded-t-3xl shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.7)]">
        
        <div class="w-full flex justify-center pt-3 pb-1 cursor-pointer" @click="showAddSheet = false">
            <div class="w-16 h-1.5 bg-slate-600 rounded-full hover:bg-slate-500 transition-colors"></div>
        </div>

        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between shrink-0">
            <h2 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                <span class="p-1.5 bg-blue-500/20 text-blue-400 rounded-lg"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg></span>
                Tambah Supplier Baru
            </h2>
            <button type="button" @click="showAddSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-lg text-red-400 text-sm">Ada error pada form. Silakan cek kembali data Anda.</div>
            @endif
            <form id="formTambahSupplier" action="{{ route('dashboard.supplier.store') }}" method="POST" class="space-y-6">
                @csrf
                
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <div class="md:col-span-2 text-sm font-semibold text-blue-400 border-b border-slate-700 pb-2">INFORMASI SUPPLIER</div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Kode Supplier <span class="text-red-400">*</span></label>
                        <input type="text" name="kode_supplier" value="{{ old('kode_supplier') }}" required 
                            placeholder="Contoh: SUP001"
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('kode_supplier')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Supplier <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_supplier" value="{{ old('nama_supplier') }}" required 
                            placeholder="Nama supplier"
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                        @error('nama_supplier')
                            <p class="text-red-400 text-xs mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Kota</label>
                        <input type="text" name="kota" value="{{ old('kota') }}" 
                            placeholder="Kota asal supplier"
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Telepon</label>
                        <input type="text" name="telpon" value="{{ old('telpon') }}" 
                            placeholder="Nomor telepon"
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Alamat</label>
                        <textarea name="alamat" rows="2" placeholder="Alamat lengkap supplier" 
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none">{{ old('alamat') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Catatan</label>
                        <textarea name="catatan" rows="2" placeholder="Catatan tambahan (opsional)" 
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 resize-none">{{ old('catatan') }}</textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="aktif" value="1" {{ old('aktif', true) ? 'checked' : '' }}
                                class="w-5 h-5 bg-slate-900 border border-slate-700 rounded text-blue-600 focus:ring-2 focus:ring-blue-500">
                            <span class="text-sm font-medium text-slate-300">Aktifkan supplier ini</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showAddSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Batal</button>
            <button type="submit" form="formTambahSupplier" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                Simpan Supplier
            </button>
        </div>
    </div>

    {{-- Edit Sheet --}}
    <div x-show="showEditSheet" style="display: none;"
         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="fixed inset-x-0 bottom-0 z-[75] w-full max-w-4xl mx-auto flex flex-col max-h-[95vh] min-h-[50vh] bg-slate-800 border-t border-x border-slate-700 rounded-t-3xl shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.7)]">
        
        <div class="w-full flex justify-center pt-3 pb-1 cursor-pointer" @click="showEditSheet = false">
            <div class="w-16 h-1.5 bg-slate-600 rounded-full hover:bg-slate-500 transition-colors"></div>
        </div>

        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between shrink-0">
            <h2 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                <span class="p-1.5 bg-amber-500/20 text-amber-400 rounded-lg"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></span>
                Edit Data Supplier
            </h2>
            <button type="button" @click="showEditSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formEditSupplier" :action="editFormAction" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="kode_supplier_edit" x-model="editData.kode_supplier">

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <div class="md:col-span-2 text-sm font-semibold text-amber-400 border-b border-slate-700 pb-2">EDIT INFORMASI SUPPLIER</div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Kode Supplier (Read Only)</label>
                        <input type="text" x-model="editData.kode_supplier" readonly disabled 
                            class="w-full px-4 py-2.5 bg-slate-800/50 border border-slate-700 rounded-lg text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Supplier <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_supplier" x-model="editData.nama_supplier" required 
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Kota</label>
                        <input type="text" name="kota" x-model="editData.kota" 
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Telepon</label>
                        <input type="text" name="telpon" x-model="editData.telpon" 
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500">
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Alamat</label>
                        <textarea name="alamat" rows="2" x-model="editData.alamat" 
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 resize-none"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="block text-sm font-medium text-slate-300 mb-2">Catatan</label>
                        <textarea name="catatan" rows="2" x-model="editData.catatan" 
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 resize-none"></textarea>
                    </div>
                    <div class="md:col-span-2">
                        <label class="flex items-center gap-3 cursor-pointer">
                            <input type="checkbox" name="aktif" value="1" x-model="editData.aktif"
                                class="w-5 h-5 bg-slate-900 border border-slate-700 rounded text-amber-600 focus:ring-2 focus:ring-amber-500">
                            <span class="text-sm font-medium text-slate-300">Aktif</span>
                        </label>
                    </div>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showEditSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Batal</button>
            <button type="submit" form="formEditSupplier" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-900 rounded-lg font-bold transition-colors flex items-center gap-2">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg> Perbarui Data
            </button>
        </div>
    </div>

    {{-- Detail Sheet --}}
    <div x-show="showDetailSheet" style="display: none;"
         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="fixed inset-x-0 bottom-0 z-[80] w-full max-w-4xl mx-auto flex flex-col max-h-[95vh] min-h-[50vh] bg-slate-800 border-t border-x border-slate-700 rounded-t-3xl shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.7)]">
        
        <div class="w-full flex justify-center pt-3 pb-1 cursor-pointer" @click="showDetailSheet = false">
            <div class="w-16 h-1.5 bg-slate-600 rounded-full hover:bg-slate-500 transition-colors"></div>
        </div>

        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between shrink-0">
            <h2 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                <span class="p-1.5 bg-blue-500/20 text-blue-400 rounded-lg"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></span>
                Detail Supplier
            </h2>
            <button type="button" @click="showDetailSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar space-y-6">
            {{-- Header Informasi --}}
            <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Kode Supplier</label>
                        <p class="text-lg font-mono font-bold text-blue-400" x-text="detailData.kode_supplier"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Nama Supplier</label>
                        <p class="text-base font-medium text-slate-100" x-text="detailData.nama_supplier"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Kota</label>
                        <p class="text-sm text-slate-300" x-text="detailData.kota || '-'"></p>
                    </div>
                    <div>
                        <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Telepon</label>
                        <p class="text-sm text-slate-300" x-text="detailData.telpon || '-'"></p>
                    </div>
                </div>
            </div>

            {{-- Alamat --}}
            <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Alamat</label>
                <p class="text-sm text-slate-300 leading-relaxed" x-text="detailData.alamat || 'Tidak ada data'"></p>
            </div>

            {{-- Catatan --}}
            <div x-show="detailData.catatan" class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Catatan</label>
                <p class="text-sm text-slate-300 leading-relaxed" x-text="detailData.catatan"></p>
            </div>

            {{-- Status & Tanggal --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Status Mitra</label>
                    <template x-if="detailData.aktif">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-emerald-500/10 text-emerald-400">Aktif</span>
                    </template>
                    <template x-if="!detailData.aktif">
                        <span class="inline-flex items-center px-3 py-1 rounded-lg text-sm font-medium bg-red-500/10 text-red-400">Tidak Aktif</span>
                    </template>
                </div>
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-2">Tanggal Ditambahkan</label>
                    <p class="text-sm text-slate-300" x-text="detailData.created_at"></p>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showDetailSheet = false" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>
@endsection
