@extends('layouts.main-layout')

@section('content')
<div class="flex flex-col gap-6">
    
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4">
        <div>
            <h1 class="text-3xl font-bold text-slate-100 mb-2">
                Manajemen Pengguna
            </h1>
            <p class="text-slate-400 text-sm flex items-center gap-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                </svg>
                Kelola akun staf, kasir, admin, dan hak akses sistem
            </p>
        </div>

        <button type="button" class="inline-flex items-center gap-2 px-5 py-2.5 bg-blue-600 hover:bg-blue-700 text-white rounded-lg font-medium transition-colors duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z" />
            </svg>
            Tambah User Baru
        </button>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
        
        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-blue-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-blue-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Total Pengguna</p>
                <h3 class="text-2xl font-bold text-slate-100">8</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-purple-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-purple-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5.121 17.804A13.937 13.937 0 0112 16c2.5 0 4.847.655 6.879 1.804M15 10a3 3 0 11-6 0 3 3 0 016 0zm6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="px-2.5 py-1 bg-purple-500/10 text-purple-400 text-xs font-medium rounded-md">Full Access</span>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Pemilik / Manajer</p>
                <h3 class="text-2xl font-bold text-slate-100">2</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-orange-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-orange-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Admin Gudang</p>
                <h3 class="text-2xl font-bold text-slate-100">2</h3>
            </div>
        </div>

        <div class="bg-slate-800 rounded-xl p-5 border border-slate-700 shadow-sm">
            <div class="flex items-start justify-between mb-4">
                <div class="p-2.5 bg-emerald-500/10 rounded-lg">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-emerald-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                </div>
            </div>
            <div>
                <p class="text-slate-400 text-sm font-medium mb-1">Kasir Aktif</p>
                <h3 class="text-2xl font-bold text-slate-100">4</h3>
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
                           placeholder="Cari Nama Pengguna atau Email..." 
                           class="w-full pl-10 pr-4 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 placeholder-slate-500 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                </div>

                <div class="flex flex-col sm:flex-row gap-3">
                    <select class="px-3 py-2 bg-slate-900 border border-slate-700 rounded-lg text-slate-200 focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-colors">
                        <option value="">Semua Role</option>
                        <option value="1">Pemilik</option>
                        <option value="2">Admin Gudang</option>
                        <option value="3">Kasir</option>
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
                        <th class="px-5 py-4 font-semibold">Pengguna</th>
                        <th class="px-5 py-4 font-semibold">Email</th>
                        <th class="px-5 py-4 font-semibold">Hak Akses (Role)</th>
                        <th class="px-5 py-4 font-semibold">Status Email</th>
                        <th class="px-5 py-4 font-semibold">Ditambahkan</th>
                        <th class="px-5 py-4 font-semibold text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-700/50">
                    
                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="grid size-9 shrink-0 place-content-center rounded-lg bg-purple-500/20 text-sm font-bold text-purple-400 border border-purple-500/30">
                                    AG
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-100">Agung Kurniawan</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-300">agung@example.com</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-purple-500/10 text-purple-400 border border-purple-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                                Pemilik
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span class="text-sm text-emerald-400">Terverifikasi</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-400">01 Jan 2024</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit Pengguna">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-600 cursor-not-allowed rounded" title="Tidak dapat menghapus diri sendiri">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="grid size-9 shrink-0 place-content-center rounded-lg bg-orange-500/20 text-sm font-bold text-orange-400 border border-orange-500/30">
                                    BS
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-100">Budi Santoso</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-300">gudang.budi@example.com</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-orange-500/10 text-orange-400 border border-orange-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                                </svg>
                                Admin Gudang
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <span class="flex h-2 w-2 rounded-full bg-emerald-500"></span>
                                <span class="text-sm text-emerald-400">Terverifikasi</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-400">10 Feb 2024</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit Pengguna">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Hapus Pengguna">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                </button>
                            </div>
                        </td>
                    </tr>

                    <tr class="hover:bg-slate-700/20 transition-colors">
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-3">
                                <div class="grid size-9 shrink-0 place-content-center rounded-lg bg-emerald-500/20 text-sm font-bold text-emerald-400 border border-emerald-500/30">
                                    SA
                                </div>
                                <div class="flex flex-col">
                                    <span class="text-sm font-medium text-slate-100">Siti Aminah</span>
                                </div>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-300">kasir.siti@example.com</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="inline-flex items-center gap-1.5 px-2.5 py-1 rounded-md text-xs font-medium bg-emerald-500/10 text-emerald-400 border border-emerald-500/20">
                                <svg xmlns="http://www.w3.org/2000/svg" class="size-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                                </svg>
                                Kasir
                            </span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center gap-2">
                                <span class="flex h-2 w-2 rounded-full bg-slate-500"></span>
                                <span class="text-sm text-slate-400">Belum Verifikasi</span>
                            </div>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <span class="text-sm text-slate-400">12 Feb 2024</span>
                        </td>
                        <td class="px-5 py-4 whitespace-nowrap">
                            <div class="flex items-center justify-center gap-2">
                                <a href="#" class="p-1.5 text-slate-400 hover:text-amber-400 hover:bg-slate-700 rounded transition-colors" title="Edit Pengguna">
                                    <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                                    </svg>
                                </a>
                                <button type="button" class="p-1.5 text-slate-400 hover:text-red-400 hover:bg-slate-700 rounded transition-colors" title="Hapus Pengguna">
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
                    - <span class="font-medium text-slate-200">3</span> 
                    dari <span class="font-medium text-slate-200">8</span>
                </div>

                <div class="flex items-center gap-1">
                    <span class="p-2 text-slate-600 cursor-not-allowed">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" /></svg>
                    </span>

                    <span class="px-3 py-1 bg-blue-600 text-white rounded font-medium text-sm">1</span>

                    <span class="p-2 text-slate-600 cursor-not-allowed">
                        <svg class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                    </span>
                </div>
            </div>
        </div>

    </div>
</div>
@endsection