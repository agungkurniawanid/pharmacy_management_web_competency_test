@extends('layouts.main-layout')

@section('content')
<div class="flex flex-col gap-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">
                Data Pembelian
            </h1>
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                Manajemen data transaksi pembelian dan restok dari supplier
            </p>
        </div>

        <button type="button" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Pembelian Baru
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-blue-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Total Transaksi</p>
                <h3 class="text-2xl font-bold text-slate-100">145</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                </div>
                <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-md">Bulan Ini</span>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Pembelian Baru</p>
                <h3 class="text-2xl font-bold text-slate-100">12</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-orange-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Rata-rata Diskon</p>
                <h3 class="text-2xl font-bold text-slate-100">5.5%</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-purple-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Supplier Terlibat</p>
                <h3 class="text-2xl font-bold text-slate-100">8</h3>
            </div>
        </div>
    </div>

    <div class="bg-slate-800 rounded-xl border border-slate-700 shadow-sm overflow-hidden">
        
        <div class="p-5 border-b border-slate-700 bg-slate-800/50">
            <form class="flex flex-col lg:flex-row gap-3">
                <div class="flex-1 relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                        <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <input type="text" 
                           placeholder="Cari No. Nota atau Nama Supplier..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <select class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="">Semua Supplier</option>
                        <option value="SUP01">PT. Contoh Farma</option>
                        <option value="SUP02">CV. Sehat Selalu</option>
                    </select>

                    <select class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="newest">Terbaru</option>
                        <option value="oldest">Terlama</option>
                        <option value="diskon_high">Diskon Terbesar</option>
                    </select>

                    <button type="button" class="px-4 py-2 bg-slate-700 hover:bg-slate-600 text-white rounded-lg font-medium transition-colors flex items-center justify-center">
                        Filter
                    </button>
                    
                    <button type="button" class="px-4 py-2 bg-slate-800 border border-slate-600 hover:bg-slate-700 text-slate-300 rounded-lg font-medium transition-colors flex items-center justify-center">
                        Reset
                    </button>
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
                        <th class="px-5 py-4 font-semibold">Diskon</th>
                        <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    
                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-blue-400">NOTA-202401001</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm text-slate-300">14 Februari 2024, 10:30</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-slate-700 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-100">PT. Indofarma Global</span>
                                    <span class="text-xs text-slate-500">Kode: SUP-001</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center px-2 py-1 rounded text-xs font-medium bg-orange-500/10 text-orange-400">
                                10%
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-slate-400 hover:text-blue-400 hover:bg-slate-700 rounded transition-colors" title="Lihat Detail Nota">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="#" class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit Transaksi">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Batalkan/Hapus Pembelian">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-blue-400">NOTA-202401002</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm text-slate-300">15 Februari 2024, 14:15</span>
                            </div>
                        </td>
                        <td class="px-5 py-4">
                            <div class="flex items-center gap-2">
                                <div class="p-1.5 bg-slate-700 rounded-md">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-100">CV. Sehat Sentosa</span>
                                    <span class="text-xs text-slate-500">Kode: SUP-002</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-500">-</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-slate-400 hover:text-blue-400 hover:bg-slate-700 rounded transition-colors" title="Lihat Detail Nota">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="#" class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit Transaksi">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Batalkan/Hapus Pembelian">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                </tbody>
            </table>
        </div>

        <div class="px-5 py-4 border-t border-slate-700 bg-slate-800/50">
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
                <div class="text-sm text-slate-400">
                    Menampilkan <span class="font-medium text-slate-200">1</span> 
                    - <span class="font-medium text-slate-200">10</span> 
                    dari <span class="font-medium text-slate-200">145</span>
                </div>

                <div class="flex items-center gap-1">
                    <span class="p-2 text-slate-600 cursor-not-allowed">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </span>

                    <span class="px-3 py-1 bg-blue-600 text-white rounded font-medium text-sm">1</span>
                    <a href="#" class="px-3 py-1 text-slate-400 hover:text-white hover:bg-slate-700 rounded text-sm transition-colors">2</a>
                    <a href="#" class="px-3 py-1 text-slate-400 hover:text-white hover:bg-slate-700 rounded text-sm transition-colors">3</a>

                    <a href="#" class="p-2 text-slate-400 hover:text-white hover:bg-slate-700 rounded transition-colors">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </a>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection