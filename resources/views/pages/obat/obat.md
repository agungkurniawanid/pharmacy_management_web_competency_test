@php
    $namaRole = session('user_role.nama_role', '');
    $hasApotekerAccess = str_contains($namaRole, 'Apoteker');
    $hasAdminAccess = str_contains($namaRole, 'Admin');
@endphp

@extends('layouts.main-layout')

@section('content')
<div x-data="{
        showAddSheet: {{ old('_method') !== 'PUT' && $errors->any() ? 'true' : 'false' }},
        showEditSheet: {{ old('_method') === 'PUT' && $errors->any() ? 'true' : 'false' }},
        showDetailSheet: false,
        editFormAction: '{{ old('_method') === 'PUT' && old('kode_obat_edit') ? route('dashboard.obat.update', old('kode_obat_edit')) : '' }}',
        editData: {
            kode_obat: '{{ old('kode_obat_edit') }}',
            nama_obat: '{{ old('nama_obat') }}',
            jenis: '{{ old('jenis') }}',
            satuan: '{{ old('satuan') }}',
            harga_beli: '{{ old('harga_beli') }}',
            harga_jual: '{{ old('harga_jual') }}',
            stok: '{{ old('stok') }}',
            tgl_kadaluarsa: '{{ old('tgl_kadaluarsa') }}',
            status: '{{ old('status', 'Aktif') }}',
            kode_supplier: '{{ old('kode_supplier') }}'
        },
        detailData: {} // Tempat menampung data untuk modal detail
    }"
    @open-edit.window="
        editData = $event.detail.obat;
        editFormAction = $event.detail.actionUrl;
        showEditSheet = true;
        setTimeout(() => {
            const hb = document.getElementById('edit_harga_beli');
            const hj = document.getElementById('edit_harga_jual');
            if(hb) hb.value = formatCurrencyInput(String(editData.harga_beli));
            if(hj) hj.value = formatCurrencyInput(String(editData.harga_jual));
        }, 50);
    "
    @open-detail.window="
        detailData = $event.detail.obat;
        showDetailSheet = true;
    "
    class="flex flex-col gap-6 pb-12 relative">

    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">Data Obat</h1>
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                </svg>
                Manajemen inventory dan data produk obat
            </p>
        </div>

        <button type="button" @click="showAddSheet = true" class="inline-flex cursor-pointer text-[14px] items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200 shadow-lg shadow-blue-500/20">
            <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            Tambah Obat Baru
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        {{-- Card 1: Total Obat --}}
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-blue-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Total Obat (Semua)</p>
                <h3 class="text-2xl font-bold text-slate-100">{{ $obats->total() }}</h3>
            </div>
        </div>

        {{-- Card 2: Stok Menipis --}}
        <a href="{{ route('dashboard.obat.index', ['status_stok' => 'menipis']) }}" class="block bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm hover:border-orange-500/50 hover:bg-slate-700/50 transition-all duration-300 group cursor-pointer relative overflow-hidden">
            <div class="relative">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-2.5 bg-orange-500/10 rounded-lg group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z" /></svg>
                    </div>
                </div>
                <div>
                    <p class="text-slate-400 text-sm font-medium mb-1">Stok Menipis</p>
                    <h3 class="text-2xl font-bold text-slate-100">{{ $lowStockCount ?? 0 }}</h3>
                </div>
            </div>
        </a>

        {{-- Card 3: Obat Hampir Kedaluwarsa --}}
        <a href="{{ route('dashboard.obat.index', ['filter_exp' => 'hampir_habis']) }}" class="block bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm hover:border-red-500/50 hover:bg-slate-700/50 transition-all duration-300 group cursor-pointer relative overflow-hidden">
            <div class="absolute inset-0 bg-gradient-to-r from-red-500/0 via-red-500/0 to-red-500/5 opacity-0 group-hover:opacity-100 transition-opacity"></div>
            <div class="relative">
                <div class="flex items-start justify-between mb-4">
                    <div class="p-2.5 bg-red-500/10 rounded-lg group-hover:scale-110 transition-transform">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                    </div>
                    @if($expiringCount > 0)
                        <span class="px-2.5 py-1 bg-red-500/10 text-red-400 text-xs font-bold animate-pulse rounded-md flex items-center gap-1">Warning</span>
                    @endif
                </div>
                <div>
                    <p class="text-slate-400 text-sm font-medium mb-1">Hampir Expired</p>
                    <h3 class="text-2xl font-bold text-red-400">{{ $expiringCount ?? 0 }}</h3>
                </div>
            </div>
        </a>

        {{-- Card 4: Total Nilai Aset --}}
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Nilai Aset (Obat Aktif)</p>
                <h3 class="text-2xl font-bold text-slate-100">Rp {{ number_format($totalStockValue ?? 0, 0, ',', '.') }}</h3>
            </div>
        </div>
    </div>

    {{-- Filter & Tabel --}}
    <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-sm overflow-hidden">
        <div class="p-5 border-b border-slate-700 bg-slate-800/50">
            <form method="GET" action="{{ route('dashboard.obat.index') }}" class="flex flex-col lg:flex-row gap-3" x-data x-ref="filterForm">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" /></svg>
                    </div>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama obat, kode, atau jenis..." @input.debounce.500ms="$refs.filterForm.submit()" class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    {{-- Filter Status Baru --}}
                    <select name="status" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                        <option value="">Semua Status</option>
                        <option value="Aktif" {{ request('status') == 'Aktif' ? 'selected' : '' }}>Aktif Dijual</option>
                        <option value="Nonaktif" {{ request('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif / Beku</option>
                        <option value="Ditarik" {{ request('status') == 'Ditarik' ? 'selected' : '' }}>Out Produksi</option>
                    </select>

                    <select name="jenis" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                        <option value="">Semua Jenis</option>
                        @foreach ($jenisObats as $jenis)
                            <option value="{{ $jenis }}" {{ request('jenis') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option>
                        @endforeach
                    </select>

                    <select name="sort" @change="$refs.filterForm.submit()" class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors cursor-pointer">
                        <option value="newest" {{ request('sort') == 'newest' ? 'selected' : '' }}>Terbaru</option>
                        <option value="name_asc" {{ request('sort') == 'name_asc' ? 'selected' : '' }}>Nama A-Z</option>
                        <option value="stock_low" {{ request('sort') == 'stock_low' ? 'selected' : '' }}>Stok Terendah</option>
                        <option value="exp_near" {{ request('sort') == 'exp_near' ? 'selected' : '' }}>Segera Expired</option>
                    </select>

                    @if (request('search') || request('jenis') || request('supplier') || request('sort') || request('status') || request('filter_exp') || request('status_stok'))
                        <a href="{{ route('dashboard.obat.index') }}" class="px-4 py-2 bg-slate-800 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg font-medium transition-colors flex items-center justify-center">Reset</a>
                    @endif
                    <noscript><button type="submit" class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium">Filter</button></noscript>
                </div>
            </form>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/50 border-b border-slate-700 text-slate-400 text-xs uppercase tracking-wider">
                        <th class="px-5 py-4 font-semibold">Kode Obat</th>
                        <th class="px-5 py-4 font-semibold">Nama & Kategori</th>
                        <th class="px-5 py-4 font-semibold text-right">Harga Jual</th>
                        <th class="px-5 py-4 font-semibold text-center">Stok</th>
                        <th class="px-5 py-4 font-semibold">Expired & Status</th>
                        <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    @forelse($obats as $obat)
                        <tr class="hover:bg-slate-700/20 transition-colors">
                            <td class="px-5 py-4 whitespace-nowrap">
                                <span class="text-sm font-mono text-blue-400">{{ $obat->kode_obat }}</span>
                            </td>
                            <td class="px-5 py-4">
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-100">{{ $obat->nama_obat }}</span>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-xs text-slate-400">{{ $obat->jenis }}</span>
                                        <span class="w-1 h-1 rounded-full bg-slate-600"></span>
                                        <span class="text-xs text-slate-400">{{ $obat->satuan }}</span>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-right">
                                <span class="text-sm font-bold text-emerald-400">Rp {{ number_format($obat->harga_jual, 0, ',', '.') }}</span>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap text-center">
                                <div class="inline-flex items-center justify-center min-w-[3rem] px-2 py-1 rounded-md text-xs font-medium border {{ $obat->stok <= 10 ? 'bg-red-500/10 text-red-400 border-red-500/20' : ($obat->stok <= 50 ? 'bg-orange-500/10 text-orange-400 border-orange-500/20' : 'bg-slate-700 text-slate-300 border-slate-600') }}">
                                    {{ $obat->stok }}
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex flex-col gap-1.5">
                                    {{-- Hitung Status Expired Secara Visual --}}
                                    @php
                                        $expDate = \Carbon\Carbon::parse($obat->tgl_kadaluarsa);
                                        $now = \Carbon\Carbon::now();
                                        $diffDays = $now->diffInDays($expDate, false);
                                        
                                        $expColor = 'text-slate-400';
                                        $expIcon = '';
                                        if($obat->tgl_kadaluarsa) {
                                            if($diffDays < 0) { $expColor = 'text-red-500 font-bold'; $expIcon = '⚠ Expired'; }
                                            elseif($diffDays <= 90) { $expColor = 'text-orange-400'; $expIcon = '⚠ Segera'; }
                                        }
                                    @endphp
                                    <span class="text-xs {{ $expColor }} flex items-center gap-1">
                                        <svg class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                                        {{ $obat->tgl_kadaluarsa ? $expDate->format('d M Y') : 'Tanpa Expired' }}
                                        <span class="font-bold text-[10px]">{{ $expIcon }}</span>
                                    </span>

                                    {{-- Status Barang --}}
                                    @if($obat->status == 'Aktif')
                                        <span class="w-max px-2 py-0.5 rounded text-[10px] font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">Aktif Dijual</span>
                                    @elseif($obat->status == 'Nonaktif')
                                        <span class="w-max px-2 py-0.5 rounded text-[10px] font-medium bg-slate-500/10 text-slate-400 border border-slate-500/20">Dibekukan</span>
                                    @else
                                        <span class="w-max px-2 py-0.5 rounded text-[10px] font-medium bg-red-500/10 text-red-400 border border-red-500/20">Out Produksi</span>
                                    @endif
                                </div>
                            </td>
                            <td class="px-5 py-4 whitespace-nowrap">
                                <div class="flex items-center justify-center gap-2">
                                    {{-- Tombol Detail --}}
                                    <button type="button" 
                                        data-detail="{{ json_encode([
                                            'kode_obat' => $obat->kode_obat, 'nama_obat' => $obat->nama_obat, 'jenis' => $obat->jenis, 'satuan' => $obat->satuan,
                                            'harga_beli' => number_format($obat->harga_beli, 0, ',', '.'), 'harga_jual' => number_format($obat->harga_jual, 0, ',', '.'),
                                            'stok' => $obat->stok, 'status' => $obat->status, 'tgl_kadaluarsa' => $obat->tgl_kadaluarsa ? \Carbon\Carbon::parse($obat->tgl_kadaluarsa)->format('d F Y') : 'Tidak diatur',
                                            'supplier_nama' => $obat->supplier->nama_supplier ?? 'Tidak Diketahui', 'supplier_kode' => $obat->kode_supplier
                                        ]) }}"
                                        @click="$dispatch('open-detail', { obat: JSON.parse($el.getAttribute('data-detail')) })"
                                        class="p-1.5 text-slate-400 hover:text-blue-400 hover:bg-slate-700 rounded transition-colors" title="Lihat Detail">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" /><path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" /></svg>
                                    </button>

                                    @if($hasAdminAccess)
                                        <button type="button"
                                            @click="$dispatch('open-edit', {
                                                obat: {
                                                    kode_obat: '{{ $obat->kode_obat }}', nama_obat: '{{ addslashes($obat->nama_obat) }}', jenis: '{{ $obat->jenis }}',
                                                    satuan: '{{ $obat->satuan }}', harga_beli: '{{ $obat->harga_beli }}', harga_jual: '{{ $obat->harga_jual }}',
                                                    stok: '{{ $obat->stok }}', tgl_kadaluarsa: '{{ $obat->tgl_kadaluarsa ? \Carbon\Carbon::parse($obat->tgl_kadaluarsa)->format('Y-m-d') : '' }}',
                                                    status: '{{ $obat->status }}', kode_supplier: '{{ $obat->kode_supplier }}'
                                                },
                                                actionUrl: '{{ route('dashboard.obat.update', $obat->kode_obat) }}'
                                            })"
                                            class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                                        </button>
                                    @endif

                                    @if ($hasAdminAccess)
                                        <button type="button"
                                            @click="window.dispatchEvent(new CustomEvent('open-confirm', {
                                                detail: {
                                                    title: 'Hapus Data Obat', message: 'Apakah Anda yakin ingin menghapus obat {{ $obat->nama_obat }}? Data yang dihapus tidak dapat dikembalikan.',
                                                    actionUrl: '{{ route('dashboard.obat.destroy', $obat->kode_obat) }}', method: 'DELETE', btnText: 'Hapus', btnColor: 'bg-red-600 hover:bg-red-700 focus:ring-red-500'
                                                }
                                            }))"
                                            class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Hapus">
                                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                        </button>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-10 text-center text-slate-500">
                                <div class="flex flex-col items-center justify-center">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-12 mb-3 text-slate-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4" /></svg>
                                    <p class="text-base font-medium text-slate-400">Tidak ada data obat ditemukan.</p>
                                </div>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Pagination Dinamis --}}
        @if ($obats->hasPages())
            <div class="px-5 py-4 border-t border-slate-700 bg-slate-800/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-slate-400">
                        Menampilkan <span class="font-medium text-slate-200">{{ $obats->firstItem() }}</span> - <span class="font-medium text-slate-200">{{ $obats->lastItem() }}</span> dari <span class="font-medium text-slate-200">{{ $obats->total() }}</span>
                    </div>
                    <div class="flex items-center gap-1">
                        @if ($obats->onFirstPage())
                            <span class="p-2 text-slate-600 cursor-not-allowed"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg></span>
                        @else
                            <a href="{{ $obats->previousPageUrl() }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg></a>
                        @endif
                        @foreach ($obats->links()->elements as $element)
                            @if (is_string($element)) <span class="px-2 text-slate-500">{{ $element }}</span> @endif
                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $obats->currentPage())
                                        <span class="px-3 py-1 bg-blue-600 text-white rounded font-medium text-sm">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-3 py-1 text-slate-400 hover:text-white hover:bg-slate-700 rounded text-sm transition-colors">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach
                        @if ($obats->hasMorePages())
                            <a href="{{ $obats->nextPageUrl() }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></a>
                        @else
                            <span class="p-2 text-slate-600 cursor-not-allowed"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg></span>
                        @endif
                    </div>
                </div>
            </div>
        @endif
    </div>

    {{-- MODAL TAMBAH OBAT --}}
    <div x-show="showAddSheet" style="display: none;"
         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="fixed inset-x-0 bottom-0 z-[70] w-full max-w-4xl mx-auto flex flex-col max-h-[90vh] bg-slate-800 border-t border-x border-slate-700 rounded-t-3xl shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.7)]">
        <div class="w-full flex justify-center pt-3 pb-1 cursor-pointer" @click="showAddSheet = false"><div class="w-16 h-1.5 bg-slate-600 rounded-full hover:bg-slate-500 transition-colors"></div></div>
        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between shrink-0">
            <h2 class="text-xl font-bold text-slate-100 flex items-center gap-2"><span class="p-1.5 bg-blue-500/20 text-blue-400 rounded-lg"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg></span>Form Tambah Obat</h2>
            <button type="button" @click="showAddSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formTambahObat" action="{{ route('dashboard.obat.store') }}" method="POST" class="space-y-6" @submit="const hargaBeli = document.querySelector('input[name=\'harga_beli\']'); const hargaJual = document.querySelector('input[name=\'harga_jual\']'); hargaBeli.value = hargaBeli.value.replace(/\./g, ''); hargaJual.value = hargaJual.value.replace(/\./g, '');">
                @csrf
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Obat <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_obat" value="{{ old('nama_obat') }}" required maxlength="50" placeholder="Contoh: Paracetamol 500mg" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jenis <span class="text-red-400">*</span></label>
                        <select name="jenis" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                            <option value="" disabled {{ old('jenis') ? '' : 'selected' }}>Pilih Jenis Obat</option>
                            @foreach ($jenisObats as $jenis) <option value="{{ $jenis }}" {{ old('jenis') == $jenis ? 'selected' : '' }}>{{ $jenis }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Satuan <span class="text-red-400">*</span></label>
                        <select name="satuan" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                            <option value="" disabled {{ old('satuan') ? '' : 'selected' }}>Pilih Satuan</option>
                            @foreach (['Strip', 'Botol', 'Pcs', 'Tube', 'Ampul', 'Box'] as $satuan) <option value="{{ $satuan }}" {{ old('satuan') == $satuan ? 'selected' : '' }}>{{ $satuan }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Supplier Asal <span class="text-red-400">*</span></label>
                        <select name="kode_supplier" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                            <option value="" disabled {{ old('kode_supplier') ? '' : 'selected' }}>Pilih Supplier</option>
                            @foreach ($suppliers as $supplier) <option value="{{ $supplier->kode_supplier }}" {{ old('kode_supplier') == $supplier->kode_supplier ? 'selected' : '' }}>{{ $supplier->kode_supplier }} - {{ $supplier->nama_supplier }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Harga Beli (Rp) <span class="text-red-400">*</span></label>
                        <input type="text" name="harga_beli" value="{{ old('harga_beli') }}" required inputmode="numeric" placeholder="0" oninput="this.value = formatCurrencyInput(this.value)" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Harga Jual (Rp) <span class="text-red-400">*</span></label>
                        <input type="text" name="harga_jual" value="{{ old('harga_jual') }}" required inputmode="numeric" placeholder="0" oninput="this.value = formatCurrencyInput(this.value)" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Stok Awal <span class="text-red-400">*</span></label>
                        <input type="number" name="stok" value="{{ old('stok', 0) }}" required min="0" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Expired (Opsional)</label>
                            <input type="date" name="tgl_kadaluarsa" value="{{ old('tgl_kadaluarsa') }}" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 [color-scheme:dark]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Status Penjualan <span class="text-red-400">*</span></label>
                            <select name="status" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 cursor-pointer">
                                <option value="Aktif" {{ old('status') == 'Aktif' ? 'selected' : '' }}>Aktif (Dijual)</option>
                                <option value="Nonaktif" {{ old('status') == 'Nonaktif' ? 'selected' : '' }}>Nonaktif (Beku)</option>
                                <option value="Ditarik" {{ old('status') == 'Ditarik' ? 'selected' : '' }}>Out Produksi</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="px-6 py-4 border-t bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showAddSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Batal</button>
            <button type="submit" form="formTambahObat" class="px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors">Simpan Obat</button>
        </div>
    </div>

    {{-- MODAL EDIT OBAT --}}
    <div x-show="showEditSheet" style="display: none;"
         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="fixed inset-x-0 bottom-0 z-[75] w-full max-w-4xl mx-auto flex flex-col max-h-[90vh] bg-slate-800 border-t border-x border-slate-700 rounded-t-3xl shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.7)]">
        <div class="w-full flex justify-center pt-3 pb-1 cursor-pointer" @click="showEditSheet = false"><div class="w-16 h-1.5 bg-slate-600 rounded-full hover:bg-slate-500 transition-colors"></div></div>
        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between shrink-0">
            <h2 class="text-xl font-bold text-slate-100 flex items-center gap-2"><span class="p-1.5 bg-amber-500/20 text-amber-400 rounded-lg"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg></span>Form Edit Obat</h2>
            <button type="button" @click="showEditSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
        <div class="p-6 overflow-y-auto custom-scrollbar">
            <form id="formEditObat" :action="editFormAction" method="POST" class="space-y-6" @submit="const hb = document.getElementById('edit_harga_beli'); const hj = document.getElementById('edit_harga_jual'); hb.value = hb.value.replace(/\./g, ''); hj.value = hj.value.replace(/\./g, '');">
                @csrf @method('PUT')
                <input type="hidden" name="kode_obat_edit" x-model="editData.kode_obat">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Kode Obat</label>
                        <input type="text" x-model="editData.kode_obat" readonly disabled class="w-full px-4 py-2.5 bg-slate-800/50 border border-slate-700 rounded-lg text-slate-500 cursor-not-allowed">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Nama Obat <span class="text-red-400">*</span></label>
                        <input type="text" name="nama_obat" x-model="editData.nama_obat" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Jenis <span class="text-red-400">*</span></label>
                        <select name="jenis" x-model="editData.jenis" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                            @foreach (['Tablet', 'Kapsul', 'Sirup', 'Injeksi', 'Salep'] as $jenis) <option value="{{ $jenis }}">{{ $jenis }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Satuan <span class="text-red-400">*</span></label>
                        <select name="satuan" x-model="editData.satuan" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                            @foreach (['Strip', 'Botol', 'Pcs', 'Tube', 'Ampul', 'Box'] as $satuan) <option value="{{ $satuan }}">{{ $satuan }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Supplier Asal <span class="text-red-400">*</span></label>
                        <select name="kode_supplier" x-model="editData.kode_supplier" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                            @foreach ($suppliers as $supplier) <option value="{{ $supplier->kode_supplier }}">{{ $supplier->kode_supplier }} - {{ $supplier->nama_supplier }}</option> @endforeach
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Harga Beli (Rp) <span class="text-red-400">*</span></label>
                        <input type="text" id="edit_harga_beli" name="harga_beli" required inputmode="numeric" oninput="this.value = formatCurrencyInput(this.value)" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Harga Jual (Rp) <span class="text-red-400">*</span></label>
                        <input type="text" id="edit_harga_jual" name="harga_jual" required inputmode="numeric" oninput="this.value = formatCurrencyInput(this.value)" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-emerald-500 focus:ring-1 focus:ring-emerald-500">
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-slate-300 mb-2">Stok Tersedia <span class="text-red-400">*</span></label>
                        <input type="number" name="stok" x-model="editData.stok" required min="0" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                    </div>
                    <div class="grid grid-cols-2 gap-4 md:col-span-2">
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Tanggal Expired</label>
                            <input type="date" name="tgl_kadaluarsa" x-model="editData.tgl_kadaluarsa" class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500 [color-scheme:dark]">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-slate-300 mb-2">Status Penjualan <span class="text-red-400">*</span></label>
                            <select name="status" x-model="editData.status" required class="w-full px-4 py-2.5 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:border-amber-500 focus:ring-1 focus:ring-amber-500">
                                <option value="Aktif">Aktif (Dijual)</option>
                                <option value="Nonaktif">Nonaktif (Beku)</option>
                                <option value="Ditarik">Out Produksi</option>
                            </select>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="px-6 py-4 border-t bg-slate-800 flex justify-end gap-3 shrink-0 rounded-b-3xl">
            <button type="button" @click="showEditSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Batal</button>
            <button type="submit" form="formEditObat" class="px-5 py-2.5 bg-amber-500 hover:bg-amber-600 text-slate-900 rounded-lg font-bold transition-colors">Update Data</button>
        </div>
    </div>

    {{-- MODAL DETAIL OBAT --}}
    <div x-show="showDetailSheet" style="display: none;"
         x-transition:enter="transition ease-out duration-300 transform" x-transition:enter-start="translate-y-full" x-transition:enter-end="translate-y-0"
         x-transition:leave="transition ease-in duration-300 transform" x-transition:leave-start="translate-y-0" x-transition:leave-end="translate-y-full"
         class="fixed inset-x-0 bottom-0 z-[80] w-full max-w-2xl mx-auto flex flex-col max-h-[90vh] bg-slate-800 border-t border-x border-slate-700 rounded-t-3xl shadow-[0_-20px_60px_-15px_rgba(0,0,0,0.7)]">
        <div class="w-full flex justify-center pt-3 pb-1 cursor-pointer" @click="showDetailSheet = false"><div class="w-16 h-1.5 bg-slate-600 rounded-full hover:bg-slate-500 transition-colors"></div></div>
        
        <div class="px-6 py-4 border-b border-slate-700 flex items-center justify-between shrink-0">
            <h2 class="text-xl font-bold text-slate-100 flex items-center gap-2">
                <span class="p-1.5 bg-blue-500/20 text-blue-400 rounded-lg"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" /></svg></span>
                Informasi Detail Obat
            </h2>
            <button type="button" @click="showDetailSheet = false" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded-xl transition-colors"><svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg></button>
        </div>
        
        <div class="p-6 overflow-y-auto custom-scrollbar space-y-6">
            <div class="flex items-center gap-4 p-4 bg-slate-900/50 border border-slate-700 rounded-xl">
                <div class="size-16 rounded-lg bg-blue-500/10 border border-blue-500/20 flex items-center justify-center text-blue-400">
                    <svg class="size-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" /></svg>
                </div>
                <div>
                    <h3 class="text-xl font-bold text-slate-100" x-text="detailData.nama_obat"></h3>
                    <p class="text-sm font-mono text-blue-400 mt-1" x-text="detailData.kode_obat"></p>
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <span class="text-xs text-slate-500 uppercase font-semibold">Stok & Satuan</span>
                    <p class="text-lg font-medium text-slate-200 mt-1"><span x-text="detailData.stok"></span> <span class="text-sm text-slate-400" x-text="detailData.satuan"></span></p>
                </div>
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <span class="text-xs text-slate-500 uppercase font-semibold">Kategori Jenis</span>
                    <p class="text-lg font-medium text-slate-200 mt-1" x-text="detailData.jenis"></p>
                </div>
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <span class="text-xs text-slate-500 uppercase font-semibold">Harga Beli</span>
                    <p class="text-lg font-medium text-slate-200 mt-1">Rp <span x-text="detailData.harga_beli"></span></p>
                </div>
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <span class="text-xs text-slate-500 uppercase font-semibold">Harga Jual</span>
                    <p class="text-lg font-bold text-emerald-400 mt-1">Rp <span x-text="detailData.harga_jual"></span></p>
                </div>
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <span class="text-xs text-slate-500 uppercase font-semibold">Tgl. Kadaluarsa</span>
                    <p class="text-base font-medium text-slate-200 mt-1" :class="detailData.tgl_kadaluarsa.includes('Tidak') ? 'text-slate-500 italic' : ''" x-text="detailData.tgl_kadaluarsa"></p>
                </div>
                <div class="bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <span class="text-xs text-slate-500 uppercase font-semibold">Status</span>
                    <p class="text-base font-medium mt-1" :class="detailData.status === 'Aktif' ? 'text-emerald-400' : (detailData.status === 'Nonaktif' ? 'text-slate-400' : 'text-red-400')" x-text="detailData.status"></p>
                </div>
                <div class="col-span-2 bg-slate-900/30 p-4 rounded-xl border border-slate-700">
                    <span class="text-xs text-slate-500 uppercase font-semibold">Informasi Supplier</span>
                    <p class="text-base font-medium text-slate-200 mt-1"><span x-text="detailData.supplier_nama"></span> <span class="text-sm text-slate-500 font-mono ml-2" x-text="'(' + detailData.supplier_kode + ')'"></span></p>
                </div>
            </div>
        </div>
        <div class="px-6 py-4 border-t border-slate-700 bg-slate-800 flex justify-end shrink-0 rounded-b-3xl">
            <button type="button" @click="showDetailSheet = false" class="px-5 py-2.5 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors">Tutup</button>
        </div>
    </div>

    <script>
        function formatCurrencyInput(value) {
            return String(value).replace(/\D/g, '').replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        }
        document.addEventListener('DOMContentLoaded', function() {
            const hb = document.querySelector('input[name="harga_beli"]');
            const hj = document.querySelector('input[name="harga_jual"]');
            if (hb && hb.value) hb.value = formatCurrencyInput(hb.value);
            if (hj && hj.value) hj.value = formatCurrencyInput(hj.value);
        });
    </script>
</div>
@endsection