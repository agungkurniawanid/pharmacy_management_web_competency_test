@extends('layouts.main-layout')

@section('content')
<div class="flex flex-col gap-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">
                Data Supplier
            </h1>
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path d="M8 14H5.25A2.25 2.25 0 013 11.75V8.25A2.25 2.25 0 015.25 6H13.5M8 14v3.75a2.25 2.25 0 002.25 2.25h1.5a2.25 2.25 0 002.25-2.25V14m-6 0h6m0 0H18.75A2.25 2.25 0 0021 11.75V9.75M14 14v1.5a1.5 1.5 0 001.5 1.5h1a1.5 1.5 0 001.5-1.5v-1.5" stroke-linecap="round" stroke-linejoin="round" />
                    <circle cx="8" cy="18" r="2" />
                    <circle cx="16" cy="18" r="2" />
                </svg>
                Manajemen data mitra penyedia dan pemasok obat
            </p>
        </div>

        <button type="button" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            Tambah Supplier Baru
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-blue-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Total Supplier</p>
                <h3 class="text-2xl font-bold text-slate-100">24</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="px-2.5 py-1 bg-emerald-500/10 text-emerald-400 text-xs font-medium rounded-md">Mitra Aktif</span>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Status Aktif</p>
                <h3 class="text-2xl font-bold text-slate-100">21</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-orange-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Cakupan Kota</p>
                <h3 class="text-2xl font-bold text-slate-100">8 Kota</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-purple-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <span class="px-2.5 py-1 bg-purple-500/10 text-purple-400 text-xs font-medium rounded-md">Bulan Ini</span>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Mitra Baru</p>
                <h3 class="text-2xl font-bold text-slate-100">3</h3>
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
                           placeholder="Cari Kode atau Nama Supplier..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <select class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="">Semua Kota</option>
                        <option value="Surabaya">Surabaya</option>
                        <option value="Jakarta">Jakarta</option>
                        <option value="Semarang">Semarang</option>
                        <option value="Bandung">Bandung</option>
                    </select>

                    <select class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="newest">Terbaru Ditambahkan</option>
                        <option value="name_asc">Nama A-Z</option>
                        <option value="name_desc">Nama Z-A</option>
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
                        <th class="px-5 py-4 font-semibold">Kode Supplier</th>
                        <th class="px-5 py-4 font-semibold">Nama Supplier</th>
                        <th class="px-5 py-4 font-semibold">Alamat</th>
                        <th class="px-5 py-4 font-semibold">Kota</th>
                        <th class="px-5 py-4 font-semibold">No. Telepon</th>
                        <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    
                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-purple-400">SUP-001</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-slate-100">PT. Kimia Farma Tbk</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-sm text-slate-300">Jl. Veteran No. 10</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-1.5 text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-sm">Surabaya</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-1.5 text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="text-sm">081122334455</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-slate-400 hover:text-blue-400 hover:bg-slate-700 rounded transition-colors" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="#" class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-purple-400">SUP-002</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-slate-100">CV. Sehat Abadi</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-sm text-slate-300">Jl. Gatot Subroto Kav. 45</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-1.5 text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                <span class="text-sm">Jakarta Pusat</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-1.5 text-slate-300">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-4 text-slate-500" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                </svg>
                                <span class="text-sm">0219876543</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-slate-400 hover:text-blue-400 hover:bg-slate-700 rounded transition-colors" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="#" class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Hapus">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm font-mono font-medium text-purple-400">SUP-003</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm font-medium text-slate-100">UD. Obat Manjur</span>
                        </td>
                        <td class="px-5 py-4">
                            <span class="text-sm text-slate-500 italic">Belum ada alamat</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-500">-</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-500">-</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-slate-400 hover:text-blue-400 hover:bg-slate-700 rounded transition-colors" title="Detail">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </a>
                                <a href="#" class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Hapus">
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
                    dari <span class="font-medium text-slate-200">24</span>
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