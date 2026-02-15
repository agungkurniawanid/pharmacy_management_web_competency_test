@extends('layouts.main-layout')

@section('content')
{{-- Alpine Data memuat Arrays untuk Detail Obat Dinamis --}}
<div x-data="{ 
        showAddSheet: {{ old('_method') !== 'PUT' && $errors->any() ? 'true' : 'false' }},
        addDetails: [{ kode_obat: '', jumlah: 1 }],

        showEditSheet: {{ old('_method') === 'PUT' && $errors->any() ? 'true' : 'false' }},
        editFormAction: '{{ old('_method') === 'PUT' && old('nota_edit') ? route('dashboard.penjualan.update', old('nota_edit')) : '' }}',
        editData: {
            nota: '{{ old('nota_edit') }}',
            tanggal_nota: '{{ old('tanggal_nota') }}',
            kode_pelanggan: '{{ old('kode_pelanggan') }}',
            diskon: '{{ old('diskon') }}',
            details: []
        },
        
        showDetailSheet: false,
        detailData: {
            nota: '',
            tanggal_nota: '',
            pelanggan_name: '',
            diskon: 0,
            details: [],
            pelanggan_info: {}
        }
    }" 
    @open-edit.window="
        const item = $event.detail.penjualan;
        editFormAction = $event.detail.actionUrl;
        editData.nota = item.nota;
        editData.tanggal_nota = item.tanggal_nota;
        editData.kode_pelanggan = item.kode_pelanggan;
        editData.diskon = item.diskon;
        editData.details = item.details;
        showEditSheet = true;
    "
    @open-detail.window="
        const item = $event.detail.penjualan;
        detailData.nota = item.nota;
        detailData.tanggal_nota = item.tanggal_nota;
        detailData.pelanggan_name = item.pelanggan_name;
        detailData.diskon = item.diskon;
        detailData.details = item.details;
        detailData.pelanggan_info = item.pelanggan_info;
        showDetailSheet = true;
    "
    class="flex flex-col gap-6 pb-12 relative">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">Data Penjualan</h1>
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" /></svg>
                Manajemen transaksi barang keluar (Otomatis Kurangi Stok)
            </p>
        </div>
        <button type="button" @click="showAddSheet = true; addDetails = [{ kode_obat: '', jumlah: 1 }]" 
                class="inline-flex cursor-pointer text-[14px] items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors shadow-lg shadow-blue-500/20">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Penjualan Baru
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
                <p class="text-slate-400 text-sm font-medium mb-1">Penjualan Baru</p>
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
                <div class="p-2.5 bg-purple-500/10 rounded-lg"><svg class="size-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 6a3 3 0 11-6 0 3 3 0 016 0zM6 20a6 6 0 0112 0v2H6v-2z" /></svg></div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Pelanggan Terlibat</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $pelangganTerlibat }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & Tabel --}}
    <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-700 bg-slate-800/50">
            <form action="{{ route('dashboard.penjualan.index') }}" method="GET" class="flex flex-col lg:flex-row gap-3" x-data x-ref="filterForm">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg class="size-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" @input.debounce.500ms="$refs.filterForm.submit()"
                           placeholder="Cari No. Nota atau Nama Pelanggan..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                </div>
                <div class="flex flex-col sm:flex-row gap-3">
                    <select name="pelanggan" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="">Semua Pelanggan</option>
                        @foreach($pelanggans as $pelanggan)
                            <option value="{{ $pelanggan->kode_pelanggan }}" {{ request('pelanggan') == $pelanggan->kode_pelanggan ? 'selected' : '' }}>{{ $pelanggan->nama_pelanggan }}</option>
                        @endforeach
                    </select>
                    <select name="sort" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="oldest" {{ request('sort') == 'oldest' ? 'selected' : '' }}>Terlama</option>
                        <option value="diskon_high" {{ request('sort') == 'diskon_high' ? 'selected' : '' }}>Diskon Terbesar</option>
                    </select>
                    @if(request('search') || request('pelanggan') || request('sort'))
                        <a href="{{ route('dashboard.penjualan.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg font-medium transition-colors flex items-center justify-center">Reset</a>
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
                        <th class="px-5 py-4 font-semibold">Pelanggan</th>
                        <th class="px-5 py-4 font-semibold">Total Item (Obat)</th>
                        <th class="px-5 py-4 font-semibold">Diskon</th>
                        <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($penjualans as $item)
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
                                <div class="p-1.5 bg-slate-700 rounded-md"><svg class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 6a3 3 0 11-6 0 3 3 0 016 0zM6 20a6 6 0 0112 0v2H6v-2z" /></svg></div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-100">{{ $item->pelanggan->nama_pelanggan ?? 'Dihapus' }}</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap"><span class="text-sm text-slate-300">{{ $item->penjualanDetails->count() }} Jenis Obat</span></td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            @if($item->diskon)
                                <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-emerald-500/10 text-emerald-400">{{ (float) $item->diskon }}%</span>
                            @else
                                <span class="text-sm text-slate-500">-</span>
                            @endif
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <button type="button" 
                                    data-detail="{{ json_encode([
                                        'nota' => $item->nota,
                                        'tanggal_nota' => \Carbon\Carbon::parse($item->tanggal_nota)->format('d M Y'),
                                        'pelanggan_name' => $item->pelanggan->nama_pelanggan,
                                        'diskon' => $item->diskon,
                                        'details' => $item->penjualanDetails->map(fn($d) => ['kode_obat' => $d->kode_obat, 'nama_obat' => $d->obat->nama_obat, 'jumlah' => $d->jumlah]),
                                        'pelanggan_info' => ['kode' => $item->pelanggan->kode_pelanggan, 'alamat' => $item->pelanggan->alamat, 'telpon' => $item->pelanggan->telpon]
                                    ]) }}"
                                    @click="
                                        const data = JSON.parse($el.getAttribute('data-detail'));
                                        window.dispatchEvent(new CustomEvent('open-detail', {
                                            detail: { penjualan: data }
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
                                        'nota' => $item->nota,
                                        'tanggal_nota' => \Carbon\Carbon::parse($item->tanggal_nota)->format('Y-m-d\TH:i'),
                                        'kode_pelanggan' => $item->kode_pelanggan,
                                        'diskon' => $item->diskon,
                                        'details' => $item->penjualanDetails->map(fn($d) => ['kode_obat' => $d->kode_obat, 'jumlah' => $d->jumlah])
                                    ]) }}"
                                    @click="
                                        const data = JSON.parse($el.getAttribute('data-item'));
                                        window.dispatchEvent(new CustomEvent('open-edit', {
                                            detail: { penjualan: data, actionUrl: '{{ route('dashboard.penjualan.update', $item->nota) }}' }
                                        }))
                                    "
                                    class="p-1.5 cursor-pointer text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit Transaksi">
                                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                </button>
                                
                                <button type="button"
                                   @click="window.dispatchEvent(new CustomEvent('open-confirm', {
                                       detail: {
                                           title: 'Hapus & Batalkan Nota?',
                                           message: 'Nota {{ $item->nota }} akan dihapus. Perhatian: Stok obat yang tadinya berkurang dari nota ini akan OTOMATIS DITAMBAHKAN kembali!',
                                           actionUrl: '{{ route('dashboard.penjualan.destroy', $item->nota) }}',
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
                            Tidak ada data penjualan. Silakan buat nota baru.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination yang Konsisten dengan Desain Obat --}}
        @if ($penjualans->hasPages())
        <div class="px-5 py-4 border-t border-slate-700 bg-slate-800/50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">

                <div class="text-sm text-slate-400">
                    Menampilkan <span class="font-medium text-slate-200">{{ $penjualans->firstItem() }}</span>
                    - <span class="font-medium text-slate-200">{{ $penjualans->lastItem() }}</span>
                    dari <span class="font-medium text-slate-200">{{ $penjualans->total() }}</span>
                </div>

                <div class="flex items-center gap-1">
                    {{-- Tombol Previous --}}
                    @if ($penjualans->onFirstPage())
                        <span class="p-2 text-slate-600 cursor-not-allowed">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </span>
                    @else
                        <a href="{{ $penjualans->previousPageUrl() }}"
                            class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
                            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
                            </svg>
                        </a>
                    @endif

                    {{-- Angka Pagination dengan separator (...) --}}
                    @foreach ($penjualans->links()->elements as $element)
                        {{-- Separator Tiga Titik --}}
                        @if (is_string($element))
                            <span class="px-2 text-slate-500">{{ $element }}</span>
                        @endif

                        {{-- Deretan Angka --}}
                        @if (is_array($element))
                            @foreach ($element as $page => $url)
                                @if ($page == $penjualans->currentPage())
                                    <span class="px-3 py-1 bg-blue-600 text-white rounded font-medium text-sm">{{ $page }}</span>
                                @else
                                    <a href="{{ $url }}"
                                        class="px-3 py-1 text-slate-400 hover:text-white hover:bg-slate-700 rounded text-sm transition-colors">{{ $page }}</a>
                                @endif
                            @endforeach
                        @endif
                    @endforeach

                    {{-- Tombol Next --}}
                    @if ($penjualans->hasMorePages())
                        <a href="{{ $penjualans->nextPageUrl() }}"
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
                Buat Nota Penjualan
            </h2>
            <button type="button" @click="showAddSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar">
            @if($errors->any())
                <div class="mb-4 p-3 bg-red-500/10 border border-red-500/20 rounded-lg text-red-400 text-sm">Cek kembali form Anda, ada data yang belum valid (termasuk list obat).</div>
            @endif
            <form id="formTambahPenjualan" action="{{ route('dashboard.penjualan.store') }}" method="POST" class="space-y-6">
                @csrf
                
                {{-- Info Auto-Generate Nota --}}
                <div class="flex gap-3 p-4 bg-blue-500/10 border border-blue-500/20 rounded-lg text-blue-400 text-sm">
                    <svg class="size-5 flex-shrink-0 mt-0.5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 5v8a2 2 0 01-2 2h-5l-5 4v-4H4a2 2 0 01-2-2V5a2 2 0 012-2h12a2 2 0 012 2zm-11-1a1 1 0 11-2 0 1 1 0 012 0zM8 9a1 1 0 100-2 1 1 0 000 2zm5-1a1 1 0 11-2 0 1 1 0 012 0z" clip-rule="evenodd"></path></svg>
                    <div><strong>Nomor Nota Otomatis:</strong> Nomor nota akan otomatis ter-generate dengan format PEN-XXXXXXXXXXXXXXXX. Tidak perlu di-input manual!</div>
                </div>
                
                {{-- Data Header Nota --}}
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <div class="md:col-span-2 text-sm font-semibold text-blue-400 border-b border-slate-700 pb-2">INFORMASI NOTA</div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Transaksi <span class="text-red-400">*</span></label>
                        <input type="datetime-local" name="tanggal_nota" value="{{ old('tanggal_nota', \Carbon\Carbon::now()->format('Y-m-d\TH:i')) }}" required
                            class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Pelanggan <span class="text-red-400">*</span></label>
                        <select name="kode_pelanggan" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                            <option value="" disabled {{ old('kode_pelanggan') ? '' : 'selected' }}>Pilih Pelanggan</option>
                            @foreach($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->kode_pelanggan }}" {{ old('kode_pelanggan') == $pelanggan->kode_pelanggan ? 'selected' : '' }}>{{ $pelanggan->kode_pelanggan }} - {{ $pelanggan->nama_pelanggan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Diskon Keseluruhan (%)</label>
                        <div class="relative">
                            <input type="text" inputmode="decimal" name="diskon" value="{{ old('diskon') }}" placeholder="0" 
                                class="w-full pl-4 pr-10 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500"
                                @input="
                                    let val = $el.value;
                                    let parts = val.split('.');
                                    if (parts.length > 2) {
                                        $el.value = parts[0] + '.' + parts.slice(1).join('');
                                    }
                                    $el.value = $el.value.replace(/[^0-9.]/g, '');
                                    
                                    if ($el.value.includes('.')) {
                                        let [intPart, decPart] = $el.value.split('.');
                                        intPart = intPart === '' ? '0' : String(parseInt(intPart) || 0);
                                        decPart = decPart.substring(0, 2);
                                        $el.value = intPart + '.' + decPart;
                                    } else {
                                        $el.value = String(parseInt($el.value) || 0);
                                    }
                                    
                                    let num = parseFloat($el.value) || 0;
                                    if (num > 100) {
                                        $el.value = '100';
                                    }
                                "
                                @blur="
                                    let num = parseFloat($el.value) || 0;
                                    num = Math.min(100, Math.max(0, num));
                                    $el.value = num.toString();
                                "
                                @change="
                                    let num = parseFloat($el.value) || 0;
                                    num = Math.min(100, Math.max(0, num));
                                    $el.value = num.toString();
                                ">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500 text-sm">%</div>
                        </div>
                    </div>
                </div>

                {{-- Data Dinamis Baris Obat --}}
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <div class="text-sm font-semibold text-blue-400 border-b border-slate-700 pb-2 mb-4 flex justify-between items-center">
                        <span>DAFTAR OBAT KELUAR</span>
                        <span class="text-xs text-red-400">(Stok Otomatis Dikurangi)</span>
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
            <button type="submit" form="formTambahPenjualan" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors flex items-center gap-2">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg>
                Simpan & Kurangi Stok
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
            <form id="formEditPenjualan" :action="editFormAction" method="POST" class="space-y-6">
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
                        <label class="block text-sm font-medium text-slate-300 mb-2">Pelanggan <span class="text-red-400">*</span></label>
                        <select name="kode_pelanggan" x-model="editData.kode_pelanggan" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500">
                            @foreach($pelanggans as $pelanggan)
                                <option value="{{ $pelanggan->kode_pelanggan }}">{{ $pelanggan->kode_pelanggan }} - {{ $pelanggan->nama_pelanggan }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Diskon Keseluruhan (%)</label>
                        <div class="relative">
                            <input type="text" inputmode="decimal" name="diskon" placeholder="0" 
                                class="w-full pl-4 pr-10 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500"
                                :value="editData.diskon ? editData.diskon.toString() : ''"
                                @input="
                                    let val = $el.value;
                                    let parts = val.split('.');
                                    if (parts.length > 2) {
                                        $el.value = parts[0] + '.' + parts.slice(1).join('');
                                    }
                                    $el.value = $el.value.replace(/[^0-9.]/g, '');
                                    
                                    if ($el.value.includes('.')) {
                                        let [intPart, decPart] = $el.value.split('.');
                                        intPart = intPart === '' ? '0' : String(parseInt(intPart) || 0);
                                        decPart = decPart.substring(0, 2);
                                        $el.value = intPart + '.' + decPart;
                                    } else {
                                        $el.value = String(parseInt($el.value) || 0);
                                    }
                                    
                                    let num = parseFloat($el.value) || 0;
                                    if (num > 100) {
                                        $el.value = '100';
                                    }
                                    editData.diskon = parseFloat($el.value) || 0;
                                "
                                @blur="
                                    let num = parseFloat($el.value) || 0;
                                    num = Math.min(100, Math.max(0, num));
                                    $el.value = num.toString();
                                    editData.diskon = num;
                                "
                                @change="
                                    let num = parseFloat($el.value) || 0;
                                    num = Math.min(100, Math.max(0, num));
                                    $el.value = num.toString();
                                    editData.diskon = num;
                                ">
                            <div class="absolute inset-y-0 right-0 pr-4 flex items-center pointer-events-none text-slate-500 text-sm">%</div>
                        </div>
                    </div>
                </div>

                {{-- Data Dinamis Baris Obat --}}
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <div class="text-sm font-semibold text-amber-400 border-b border-slate-700 pb-2 mb-4">DAFTAR OBAT KELUAR (UBAH JIKA ADA REVISI)</div>
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
            <button type="submit" form="formEditPenjualan" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-900 rounded-lg font-bold transition-colors flex items-center gap-2">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" /></svg> Update & Koreksi Stok
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
                <span class="p-1.5 bg-blue-500/20 text-blue-400 rounded-lg"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg></span>
                Detail Penjualan
            </h2>
            <button type="button" @click="showDetailSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors">
                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
            </button>
        </div>

        <div class="p-6 overflow-y-auto custom-scrollbar space-y-6">
            {{-- Header Informasi --}}
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">No. Nota</label>
                    <p class="text-lg font-mono font-bold text-blue-400" x-text="detailData.nota"></p>
                </div>
                <div>
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Tanggal Transaksi</label>
                    <p class="text-base text-slate-200 flex items-center gap-2">
                        <svg class="size-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                        <span x-text="detailData.tanggal_nota"></span>
                    </p>
                </div>
                <div class="md:col-span-2">
                    <label class="block text-xs font-semibold text-slate-400 uppercase mb-1">Pelanggan</label>
                    <p class="text-base text-slate-200 flex items-center gap-2">
                        <svg class="size-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.856-1.487M15 6a3 3 0 11-6 0 3 3 0 016 0zM6 20a6 6 0 0112 0v2H6v-2z" /></svg>
                        <span class="font-medium" x-text="detailData.pelanggan_name"></span>
                    </p>
                </div>
            </div>

            {{-- Detail Obat --}}
            <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                <h3 class="text-sm font-semibold text-blue-400 border-b border-slate-700 pb-2 mb-4">DAFTAR OBAT YANG TERJUAL</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-slate-700">
                                <th class="text-left py-2 px-2 text-slate-400 font-semibold">Kode Obat</th>
                                <th class="text-left py-2 px-2 text-slate-400 font-semibold">Nama Obat</th>
                                <th class="text-right py-2 px-2 text-slate-400 font-semibold">Jumlah</th>
                            </tr>
                        </thead>
                        <tbody>
                            <template x-for="detail in detailData.details" :key="detail.kode_obat">
                                <tr class="border-b border-slate-700/50 hover:bg-slate-700/30 transition-colors">
                                    <td class="py-3 px-2 font-mono text-blue-300" x-text="detail.kode_obat"></td>
                                    <td class="py-3 px-2 text-slate-200" x-text="detail.nama_obat"></td>
                                    <td class="py-3 px-2 text-right text-slate-200 font-medium" x-text="detail.jumlah"></td>
                                </tr>
                            </template>
                        </tbody>
                    </table>
                </div>
                <div class="mt-4 pt-4 border-t border-slate-700 flex justify-between">
                    <span class="text-slate-400">Total Jenis Obat:</span>
                    <span class="font-bold text-blue-400" x-text="detailData.details.length"></span>
                </div>
            </div>

            {{-- Informasi Diskon --}}
            <div class="bg-emerald-500/10 border border-emerald-500/20 rounded-xl p-4">
                <div class="flex items-center justify-between">
                    <span class="text-slate-300 font-medium">Diskon Total</span>
                    <span class="text-lg font-bold text-emerald-400"><span x-text="detailData.diskon || '0'"></span>%</span>
                </div>
            </div>

            {{-- Info Pelanggan --}}
            <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                <h3 class="text-sm font-semibold text-slate-300 border-b border-slate-700 pb-2 mb-4">INFORMASI PELANGGAN</h3>
                <div class="space-y-3">
                    <div>
                        <label class="text-xs text-slate-400 font-semibold uppercase">Kode Pelanggan</label>
                        <p class="text-slate-200 font-mono mt-1" x-text="detailData.pelanggan_info.kode || '-'"></p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-400 font-semibold uppercase">Alamat</label>
                        <p class="text-slate-200 mt-1" x-text="detailData.pelanggan_info.alamat || '-'"></p>
                    </div>
                    <div>
                        <label class="text-xs text-slate-400 font-semibold uppercase">No. Telepon</label>
                        <p class="text-slate-200 mt-1" x-text="detailData.pelanggan_info.telpon || '-'"></p>
                    </div>
                </div>
            </div>
        </div>

        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showDetailSheet = false" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Tutup</button>
        </div>
    </div>
</div>
@endsection
