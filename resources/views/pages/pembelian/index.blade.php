@extends('layouts.main-layout')

@section('content')
{{-- Alpine Data memuat Arrays untuk Detail Obat Dinamis --}}
<div x-data="{ 
        showAddSheet: {{ old('_method') !== 'PUT' && $errors->any() ? 'true' : 'false' }},
        addDetails: [{ kode_obat: '', jumlah: 1 }],

        showEditSheet: {{ old('_method') === 'PUT' && $errors->any() ? 'true' : 'false' }},
        editFormAction: '{{ old('_method') === 'PUT' && old('nota_edit') ? route('dashboard.pembelian.update', old('nota_edit')) : '' }}',
        editData: {
            nota: '{{ old('nota_edit') }}',
            tanggal_nota: '{{ old('tanggal_nota') }}',
            kode_supplier: '{{ old('kode_supplier') }}',
            diskon: '{{ old('diskon') }}',
            details: []
        }
    }" 
    @open-edit.window="
        const item = $event.detail.pembelian;
        editFormAction = $event.detail.actionUrl;
        editData.nota = item.nota;
        editData.tanggal_nota = item.tanggal_nota;
        editData.kode_supplier = item.kode_supplier;
        editData.diskon = item.diskon;
        editData.details = item.details;
        showEditSheet = true;
    "
    class="flex flex-col gap-6 pb-12 relative">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">Data Pembelian</h1>
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Manajemen transaksi barang masuk (Otomatis Tambah Stok)
            </p>
        </div>
        <button type="button" @click="showAddSheet = true; addDetails = [{ kode_obat: '', jumlah: 1 }]" 
                class="inline-flex cursor-pointer text-[14px] items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-lg shadow-blue-500/20">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Pembelian Baru
        </button>
    </div>

    {{-- Stats Cards --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-blue-500/10 rounded-lg"><svg class="size-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" /></svg></div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Total Transaksi</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $totalNota }}</h3>
            </div>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-emerald-500/10 rounded-lg"><svg class="size-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg></div>
                <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-md">Bulan Ini</span>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Pembelian Baru</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $notaBulanIni }}</h3>
            </div>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-orange-500/10 rounded-lg"><svg class="size-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Rata-rata Diskon</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ number_format($avgDiskon, 1) }}%</h3>
            </div>
        </div>
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-purple-500/10 rounded-lg"><svg class="size-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg></div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Supplier Terlibat</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $supplierTerlibat }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & Tabel --}}
    <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-700 bg-slate-800/50">
            <form action="{{ route('dashboard.pembelian.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3" x-data x-ref="filterForm">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="size-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" @input.debounce.500ms="$refs.filterForm.submit()"
                           placeholder="Cari No. Nota atau Nama Supplier..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="supplier" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="">Semua Supplier</option>
                        @foreach($suppliers as $supplier)
                            <option value="{{ $supplier->kode_supplier }}" {{ request('supplier') == $supplier->kode_supplier ? 'selected' : '' }}>{{ $supplier->nama_supplier }}</option>
                        @endforeach
                    </select>
                    <select name="sort" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="diskon_high" {{ request('sort') == 'diskon_high' ? 'selected' : '' }}>Diskon Terbesar</option>
                    </select>
                    @if(request('search') || request('supplier') || request('sort'))
                        <a href="{{ route('dashboard.pembelian.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg font-medium transition-colors flex items-center justify-center">Reset</a>
                    @endif
                    <noscript><button type="submit" class="hidden">Filter</button></noscript>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/50 border-b border-slate-700 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="px-5 py-4 font-semibold">No. Nota</th>
                        <th class="px-5 py-4 font-semibold">Tanggal Nota</th>
                        <th class="px-5 py-4 font-semibold">Supplier</th>
                        <th class="px-5 py-4 font-semibold">Total Item (Obat)</th>
                        <th class="px-5 py-4 font-semibold">Diskon</th>
                        <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($pembelians as $item)
                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap"><span class="text-sm font-mono font-medium text-blue-400">{{ $item->nota }}</span></td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2 text-slate-300">
                                <svg class="size-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                <span class="text-sm">{{ \Carbon\Carbon::parse($item->tanggal_nota)->translatedFormat('d F Y, H:i') }}</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-slate-700 rounded-md"><svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" /></svg></div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-100">{{ $item->supplier->nama_supplier ?? 'Dihapus' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap"><span class="text-sm text-slate-300">{{ $item->pembelianDetails->count() }} Jenis Obat</span></td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($item->diskon)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400">{{ (float) $item->diskon }}%</span>
                            @else
                                <span class="text-sm text-slate-500">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                 <a href=""
                                                class="p-1.5 text-slate-400 hover:text-blue-400 hover:bg-slate-700 rounded transition-colors"
                                                title="Lihat Detail">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none"
                                                    viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                                </svg>
                                            </a>
                                <button type="button" 
                                    data-item="{{ json_encode([
                                        'nota' => $item->nota,
                                        'tanggal_nota' => \Carbon\Carbon::parse($item->tanggal_nota)->format('Y-m-d\TH:i'),
                                        'kode_supplier' => $item->kode_supplier,
                                        'diskon' => $item->diskon,
                                        'details' => $item->pembelianDetails->map(fn($d) => ['kode_obat' => $d->kode_obat, 'jumlah' => $d->jumlah])
                                    ]) }}"
                                    @click="
                                        const data = JSON.parse($el.getAttribute('data-item'));
                                        window.dispatchEvent(new CustomEvent('open-edit', {
                                            detail: { pembelian: data, actionUrl: '{{ route('dashboard.pembelian.update', $item->nota) }}' }
                                        }))
                                    "
                                    class="p-1.5 cursor-pointer text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit Transaksi">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                
                                <button type="button"
                                   @click="window.dispatchEvent(new CustomEvent('open-confirm', {
                                       detail: {
                                           title: 'Hapus & Batalkan Nota?',
                                           message: 'Nota {{ $item->nota }} akan dihapus. Perhatian: Stok obat yang tadinya bertambah dari nota ini akan OTOMATIS DIKURANGI kembali!',
                                           actionUrl: '{{ route('dashboard.pembelian.destroy', $item->nota) }}',
                                           method: 'DELETE',
                                           btnText: 'Batalkan Nota',
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
                            Tidak ada data pembelian. Silakan buat nota baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination yang Konsisten dengan Desain Obat --}}
        @if ($pembelians->hasPages())
        <div class="px-5 py-4 border-t border-slate-700 bg-slate-800/50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">

                <div class="text-sm text-slate-400">
                    Menampilkan <span class="font-medium text-slate-200">{{ $pembelians->firstItem() }}</span>
                    - <span class="font-medium text-slate-200">{{ $pembelians->lastItem() }}</span>
                    dari <span class="font-medium text-slate-200">{{ $pembelians->total() }}</span>
                </div>

                <div class="flex items-center gap-1">
                    {{-- Tombol Previous --}}
                    @if ($pembelians->onFirstPage())
                        <span class="p-2 text-slate-600 cursor-not-allowed">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $pembelians->previousPageUrl() }}"
                            class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    @endif

                    {{-- Angka Pagination dengan separator (...) --}}
                    @foreach ($pembelians->links()->elements as $element)
                        {{-- Separator Tiga Titik --}}
                        @if (is_string($element))
                            <span class="px-2 text-slate-500">{{ $element }}</span>
                        @endif

                        {{-- Deretan Angka --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $pembelians->currentPage())
                                    <span class="px-3 py-1 bg-blue-600 text-white rounded font-medium text-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-3 py-1 text-slate-400 hover:text-white hover:bg-slate-700 rounded text-sm transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($pembelians->hasMorePages())
                        <a href="{{ $pembelians->nextPageUrl() }}"
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
                Buat Nota Pembelian
            </h2>
            <button type="button" @click="showAddSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-lg text-red-400 text-sm">Cek kembali form Anda, ada data yang belum valid (termasuk list obat).</div>
            @endif
            <form id="formTambahPembelian" action="{{ route('dashboard.pembelian.store') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- Data Header Nota --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <div class="md:col-span-2 text-sm font-semibold text-blue-400 border-b border-slate-700 pb-2">INFORMASI NOTA</div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">No. Nota <span class="text-red-400">*</span></label>
                        <input type="text" name="nota" value="{{ old('nota') }}" required maxlength="20" placeholder="INV-001"
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Transaksi <span class="text-red-400">*</span></label>
                        <input type="datetime-local" name="tanggal_nota" value="{{ old('tanggal_nota', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}" required
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Supplier <span class="text-red-400">*</span></label>
                        <select name="kode_supplier" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="" disabled {{ old('kode_supplier') ? '' : 'selected' }}>Pilih Supplier</option>
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->kode_supplier }}" {{ old('kode_supplier') == $supplier->kode_supplier ? 'selected' : '' }}>{{ $supplier->kode_supplier }} - {{ $supplier->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Diskon Keseluruhan (%)</label>
                        <div class="relative">
                            <input type="number" name="diskon" value="{{ old('diskon') }}" min="0" max="100" step="0.01" placeholder="0" class="w-full pl-4 pr-10 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500">%</div>
                        </div>
                    </div>
                </div>

                {{-- Data Dinamis Baris Obat --}}
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <div class="text-sm font-semibold text-blue-400 border-b border-slate-700 pb-2 mb-4 flex justify-between items-center">
                        <span>DAFTAR OBAT MASUK</span>
                        <span class="text-xs text-emerald-400">(Stok Otomatis Ditambahkan)</span>
                    </div>
                    
                    <div class="space-y-3">
                        <template x-for="(detail, index) in addDetails" :key="index">
                            <div class="flex items-start gap-3">
                                <div class="flex-1">
                                    <select :name="'details['+index+'][kode_obat]'" x-model="detail.kode_obat" required class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                                        <option value="" disabled>Pilih Obat...</option>
                                        @foreach($obats as $obat)
                                            <option value="{{ $obat->kode_obat }}">{{ $obat->kode_obat }} - {{ $obat->nama_obat }} (Stok: {{ $obat->stok }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-24 shrink-0">
                                    <input type="number" :name="'details['+index+'][jumlah]'" x-model="detail.jumlah" required min="1" placeholder="Qty" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-blue-500 focus:ring-1 focus:ring-blue-500 text-sm">
                                </div>
                                <div class="shrink-0 w-10 text-right">
                                    <button type="button" @click="addDetails.splice(index, 1)" x-show="addDetails.length > 1" class="p-2 text-slate-500 hover:text-red-400 hover:bg-red-500/10 rounded transition-colors" title="Hapus Baris">
                                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                    
                    <button type="button" @click="addDetails.push({ kode_obat: '', jumlah: 1 })" class="mt-4 flex items-center gap-1 text-sm text-blue-400 hover:text-blue-300 font-medium">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
                        Tambah Baris Obat
                    </button>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showAddSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Batal</button>
            <button type="submit" form="formTambahPembelian" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                Simpan & Tambah Stok
            </button>
        </div>
    </div>


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
                Edit Transaksi (Otomatis Koreksi Stok)
            </h2>
            <button type="button" @click="showEditSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formEditPembelian" :action="editFormAction" method="POST" class="space-y-6">
                @csrf
                @method('PUT')
                <input type="hidden" name="nota_edit" x-model="editData.nota">

                {{-- Data Header Nota --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">No. Nota (Read Only)</label>
                        <input type="text" x-model="editData.nota" readonly disabled class="w-full px-4 py-2.5 bg-slate-800/50 border border-slate-700 rounded-lg text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Transaksi <span class="text-red-400">*</span></label>
                        <input type="datetime-local" name="tanggal_nota" x-model="editData.tanggal_nota" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Supplier <span class="text-red-400">*</span></label>
                        <select name="kode_supplier" x-model="editData.kode_supplier" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500">
                            @foreach($suppliers as $supplier)
                                <option value="{{ $supplier->kode_supplier }}">{{ $supplier->kode_supplier }} - {{ $supplier->nama_supplier }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Diskon Keseluruhan (%)</label>
                        <input type="number" name="diskon" x-model="editData.diskon" min="0" max="100" step="0.01" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500">
                    </div>
                </div>

                {{-- Data Dinamis Baris Obat --}}
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <div class="text-sm font-semibold text-amber-400 border-b border-slate-700 pb-2 mb-4">DAFTAR OBAT MASUK (UBAH JIKA ADA REVISI)</div>
                    <div class="space-y-3">
                        <template x-for="(detail, index) in editData.details" :key="index">
                            <div class="flex items-start gap-3">
                                <div class="flex-1">
                                    <select :name="'details['+index+'][kode_obat]'" x-model="detail.kode_obat" required class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 text-sm">
                                        <option value="" disabled>Pilih Obat...</option>
                                        @foreach($obats as $obat)
                                            <option value="{{ $obat->kode_obat }}">{{ $obat->kode_obat }} - {{ $obat->nama_obat }} (Stok saat ini: {{ $obat->stok }})</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="w-24 shrink-0">
                                    <input type="number" :name="'details['+index+'][jumlah]'" x-model="detail.jumlah" required min="1" placeholder="Qty" class="w-full px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 text-sm">
                                </div>
                                <div class="shrink-0 w-10 text-right">
                                    <button type="button" @click="editData.details.splice(index, 1)" x-show="editData.details.length > 1" class="p-2 text-slate-500 hover:text-red-400 hover:bg-red-500/10 rounded">
                                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                                    </button>
                                </div>
                            </div>
                        </template>
                    </div>
                    <button type="button" @click="editData.details.push({ kode_obat: '', jumlah: 1 })" class="mt-4 flex items-center gap-1 text-sm text-amber-400 hover:text-amber-300 font-medium">
                        <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg> Tambah Baris Obat
                    </button>
                </div>
            </form>
        </div>

        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showEditSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Batal</button>
            <button type="submit" form="formEditPembelian" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-900 rounded-lg font-bold transition-colors flex items-center gap-2">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg> Update & Koreksi Stok
            </button>
        </div>
    </div>
</div>
@endsection