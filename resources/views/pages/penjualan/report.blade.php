@extends('layouts.main-layout')

@section('content')
<div class="flex flex-col gap-6 pb-12">
    
    {{-- Header --}}
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">Laporan Penjualan</h1>
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z" /></svg>
                Ringkasan performa penjualan dan pendapatan
            </p>
        </div>
        <div class="flex flex-wrap gap-2">
            <a href="{{ route('dashboard.penjualan.index') }}" class="px-4 py-2 bg-slate-800 hover:bg-slate-700 border border-slate-600 text-slate-300 rounded-lg text-sm font-medium transition-colors">
                Kembali ke Data
            </a>
            
            {{-- Tombol Export Excel --}}
            <button type="button" onclick="document.getElementById('exportExcelFlag').value='excel'; document.getElementById('filterReportForm').submit(); document.getElementById('exportExcelFlag').value='';" 
                    class="px-4 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2 print:hidden">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" /></svg>
                Export Excel
            </button>

            <button onclick="window.print()" class="px-4 py-2 bg-indigo-600 hover:bg-indigo-700 text-white rounded-lg text-sm font-medium transition-colors flex items-center gap-2 print:hidden">
                <svg class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z" /></svg>
                Cetak Laporan
            </button>
        </div>
    </div>

    {{-- Filter Laporan --}}
    <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-sm p-5 print:hidden">
        <form id="filterReportForm" action="{{ route('dashboard.penjualan.report') }}" method="GET" class="flex flex-col md:flex-row gap-4 items-end">
            {{-- Flag tersembunyi untuk mentrigger download excel --}}
            <input type="hidden" name="export" id="exportExcelFlag" value="">
            
            <div class="w-full md:w-auto flex-1">
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-1.5">Dari Tanggal</label>
                <input type="date" name="start_date" value="{{ $startDate }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 [color-scheme:dark]">
            </div>
            <div class="w-full md:w-auto flex-1">
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-1.5">Sampai Tanggal</label>
                <input type="date" name="end_date" value="{{ $endDate }}" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 [color-scheme:dark]">
            </div>
            <div class="w-full md:w-auto flex-1">
                <label class="block text-xs font-semibold text-slate-400 uppercase mb-1.5">Filter Pelanggan</label>
                <select name="pelanggan" class="w-full px-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500">
                    <option value="">Semua Pelanggan</option>
                    @foreach($pelanggans as $pelanggan)
                        <option value="{{ $pelanggan->kode_pelanggan }}" {{ request('pelanggan') == $pelanggan->kode_pelanggan ? 'selected' : '' }}>{{ $pelanggan->nama_pelanggan }}</option>
                    @endforeach
                </select>
            </div>
            <div class="w-full md:w-auto flex gap-2">
                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors w-full md:w-auto">Hasilkan Laporan</button>
                <a href="{{ route('dashboard.penjualan.report') }}" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors flex justify-center items-center" title="Reset Filter">
                    <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15" /></svg>
                </a>
            </div>
        </form>
    </div>

    {{-- Keterangan Periode untuk Cetak --}}
    <div class="hidden print:block mb-6">
        <h2 class="text-2xl font-bold text-slate-900">LAPORAN PENJUALAN APOTEK</h2>
        <p class="text-slate-600">Periode: {{ \Carbon\Carbon::parse($startDate)->translatedFormat('d F Y') }} s/d {{ \Carbon\Carbon::parse($endDate)->translatedFormat('d F Y') }}</p>
    </div>

    {{-- Ringkasan Kartu (Summary Cards) --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        <div class="bg-slate-800 print:bg-white print:border-slate-300 rounded-xl p-5 border border-slate-700 shadow-sm">
            <p class="text-slate-400 print:text-slate-600 text-sm font-medium mb-1">Total Transaksi</p>
            <h3 class="text-2xl font-bold text-blue-400 print:text-blue-700">{{ number_format($totalTransaksi) }} <span class="text-sm font-normal text-slate-500">Nota</span></h3>
        </div>
        <div class="bg-slate-800 print:bg-white print:border-slate-300 rounded-xl p-5 border border-slate-700 shadow-sm">
            <p class="text-slate-400 print:text-slate-600 text-sm font-medium mb-1">Total Penjualan Kotor</p>
            <h3 class="text-2xl font-bold text-slate-100 print:text-slate-900">Rp {{ number_format($totalPendapatanKotor, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-slate-800 print:bg-white print:border-slate-300 rounded-xl p-5 border border-slate-700 shadow-sm">
            <p class="text-slate-400 print:text-slate-600 text-sm font-medium mb-1">Total Diskon Diberikan</p>
            <h3 class="text-2xl font-bold text-red-400">Rp {{ number_format($totalDiskonDiberikan, 0, ',', '.') }}</h3>
        </div>
        <div class="bg-slate-800 print:bg-white print:border-slate-300 rounded-xl p-5 border border-slate-700 shadow-sm border-l-4 border-l-emerald-500">
            <p class="text-slate-400 print:text-slate-600 text-sm font-medium mb-1">Total Pendapatan Bersih</p>
            <h3 class="text-2xl font-bold text-emerald-400 print:text-emerald-600">Rp {{ number_format($totalPendapatanBersih, 0, ',', '.') }}</h3>
        </div>
    </div>

    {{-- Tabel Rincian Data --}}
    <div class="bg-slate-800 print:bg-white rounded-xl border border-slate-700 print:border-slate-300 shadow-sm overflow-hidden mt-2">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-900/50 print:bg-slate-100 border-b border-slate-700 print:border-slate-300 text-slate-400 print:text-slate-700 text-xs uppercase tracking-wider">
                        <th class="px-5 py-4 font-semibold">Tgl Transaksi</th>
                        <th class="px-5 py-4 font-semibold">No. Nota</th>
                        <th class="px-5 py-4 font-semibold">Pelanggan</th>
                        <th class="px-5 py-4 font-semibold text-right">Harga Kotor</th>
                        <th class="px-5 py-4 font-semibold text-center">Diskon</th>
                        <th class="px-5 py-4 font-semibold text-right">Total Bersih</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50 print:divide-slate-300">
                    @forelse($laporanPenjualan as $item)
                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-slate-300 print:text-slate-800">
                            {{ \Carbon\Carbon::parse($item->tanggal_nota)->format('d/m/Y H:i') }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm font-mono text-blue-400 print:text-blue-700">
                            {{ $item->nota }}
                        </td>
                        <td class="px-5 py-4 text-sm text-slate-200 print:text-slate-800">
                            {{ $item->pelanggan->nama_pelanggan ?? 'Umum/Dihapus' }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-right text-slate-300 print:text-slate-800">
                            {{ number_format($item->total_harga, 0, ',', '.') }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-center text-red-400">
                            {{ $item->diskon ? (float)$item->diskon . '%' : '-' }}
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap text-sm text-right font-medium text-emerald-400 print:text-emerald-700">
                            {{ number_format($item->grand_total, 0, ',', '.') }}
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6" class="px-5 py-10 text-center text-slate-500 print:text-slate-600">
                            Tidak ada transaksi penjualan pada periode ini.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        
        {{-- Custom Pagination --}}
        <div class="print:hidden">
            @if ($laporanPenjualan->hasPages())
            <div class="px-5 py-4 border-t border-slate-700 bg-slate-800/50">
                <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                    <div class="text-sm text-slate-400">
                        Menampilkan <span class="font-medium text-slate-200">{{ $laporanPenjualan->firstItem() }}</span> 
                        - <span class="font-medium text-slate-200">{{ $laporanPenjualan->lastItem() }}</span> 
                        dari <span class="font-medium text-slate-200">{{ $laporanPenjualan->total() }}</span>
                    </div>

                    <div class="flex items-center gap-1">
                        @if ($laporanPenjualan->onFirstPage())
                            <span class="p-2 text-slate-600 cursor-not-allowed">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                            </span>
                        @else
                            <a href="{{ $laporanPenjualan->previousPageUrl() }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
                                <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                            </a>
                        @endif

                        @foreach ($laporanPenjualan->links()->elements as $element)
                            @if (is_string($element))
                                <span class="px-2 text-slate-500">{{ $element }}</span>
                            @endif

                            @if (is_array($element))
                                @foreach ($element as $page => $url)
                                    @if ($page == $laporanPenjualan->currentPage())
                                        <span class="px-3 py-1 bg-blue-600 text-white rounded font-medium text-sm">{{ $page }}</span>
                                    @else
                                        <a href="{{ $url }}" class="px-3 py-1 text-slate-400 hover:text-white hover:bg-slate-700 rounded text-sm transition-colors">{{ $page }}</a>
                                    @endif
                                @endforeach
                            @endif
                        @endforeach

                        @if ($laporanPenjualan->hasMorePages())
                            <a href="{{ $laporanPenjualan->nextPageUrl() }}" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
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
    </div>

</div>

{{-- Style khusus untuk hasil Print --}}
<style>
    @media print {
        body { background-color: white !important; }
        /* Sembunyikan sidebar/navbar utama layout jika perlu */
        aside, nav, header { display: none !important; }
        main, #content { padding: 0 !important; margin: 0 !important; }
    }
</style>
@endsection