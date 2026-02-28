@php
    // Ambil nama_role dari session, berikan string kosong jika tidak ada (untuk keamanan)
    $namaRole = session('user_role.nama_role', '');
    
    // Cek Hak Akses
    $hasAdminAccess = str_contains(strtolower($namaRole), 'admin') || str_contains(strtolower($namaRole), 'pemilik');
    $hasApotekerAccess = str_contains(strtolower($namaRole), 'apoteker');
    // Jika bukan Admin dan bukan Apoteker, asumsikan sebagai Pelanggan (atau role terbatas lainnya)
@endphp

<div class="flex h-full flex-col justify-between relative transition-all duration-300 ease-in-out bg-slate-800 border-r border-slate-700"
    :class="sidebarExpanded ? 'w-64' : 'w-20'">

    <button @click="sidebarExpanded = !sidebarExpanded"
        class="absolute -right-3 top-5 z-50 flex size-6 items-center justify-center rounded-full border border-slate-600 bg-slate-800 text-slate-300 shadow-sm hover:bg-slate-700 hover:text-white transition-all duration-300">
        <svg :class="sidebarExpanded ? 'rotate-180' : ''" xmlns="http://www.w3.org/2000/svg"
            class="size-3 transition-transform duration-300" fill="none" viewBox="0 0 24 24" stroke="currentColor"
            stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
    </button>

    <div>
        <div class="flex h-16 items-center border-b border-slate-700 transition-all duration-300 ease-in-out">
            <div class="flex w-20 shrink-0 items-center justify-center">
                <span
                    class="grid size-10 shrink-0 place-content-center rounded-lg bg-slate-900 text-sm font-bold text-white border border-slate-600 shadow-inner">
                    {{ Str::upper(
                        Str::limit(
                            collect(explode(' ', session('user')['name']))->map(fn($word) => substr($word, 0, 1))->join(''),
                            3,
                            '',
                        ),
                    ) }}
                </span>
            </div>
            <div class="flex flex-col whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                :class="sidebarExpanded ? 'max-w-[200px] opacity-100' : 'max-w-0 opacity-0'">
                <span class="text-sm font-semibold text-slate-100">
                    {{ session('user')['name'] }}
                </span>
                <span class="text-xs text-slate-400">
                    {{ session('user_role')['nama_role'] ?? 'Pelanggan' }}
                </span>
            </div>
        </div>

        <div class="py-4 px-3">
            <ul class="space-y-2">

                {{-- MENU DASHBOARD: Untuk Admin dan Apoteker
                @if ($hasAdminAccess || $hasApotekerAccess)
                <li>
                    <a href="{{ route('dashboard.index') }}" @class([
                        'group relative flex items-center rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white transition-all duration-300',
                        'bg-slate-700 text-white' => request()->routeIs('dashboard.index'),
                    ])>
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z" />
                            </svg>
                        </div>
                        <div class="whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out" :class="sidebarExpanded ? 'max-w-[200px] opacity-100' : 'max-w-0 opacity-0'">
                            <span class="text-sm font-medium pr-4">Dashboard</span>
                        </div>
                        <span x-show="!sidebarExpanded" class="invisible absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded-sm bg-slate-900 border border-slate-700 px-2 py-1.5 text-xs font-medium text-white group-hover:visible shadow-lg z-50 whitespace-nowrap">Dashboard</span>
                    </a>
                </li>
                @endif --}}

                {{-- MENU OBAT: Untuk SEMUA (Admin, Apoteker, Pelanggan) --}}
                <li>
                    <a href="{{ route('dashboard.obat.index') }}" @class([
                        'group relative flex items-center rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white transition-all duration-300',
                        'bg-slate-700 text-white' => request()->routeIs('dashboard.obat.index'),
                    ])>
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                            </svg>
                        </div>
                        <div class="whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out" :class="sidebarExpanded ? 'max-w-[200px] opacity-100' : 'max-w-0 opacity-0'">
                            <span class="text-sm font-medium pr-4">Halaman Obat</span>
                        </div>
                        <span x-show="!sidebarExpanded" class="invisible absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded-sm bg-slate-900 border border-slate-700 px-2 py-1.5 text-xs font-medium text-white group-hover:visible shadow-lg z-50 whitespace-nowrap">Halaman Obat</span>
                    </a>
                </li>

                {{-- MENU PEMBELIAN: Hanya untuk Admin --}}
                @if ($hasAdminAccess)
                <li>
                    <a href="{{ route('dashboard.pembelian.index') }}" @class([
                        'group relative flex items-center rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white transition-all duration-300',
                        'bg-slate-700 text-white' => request()->routeIs('dashboard.pembelian.index'),
                    ])>
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                        </div>
                        <div class="whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out" :class="sidebarExpanded ? 'max-w-[200px] opacity-100' : 'max-w-0 opacity-0'">
                            <span class="text-sm font-medium pr-4">Pembelian</span>
                        </div>
                        <span x-show="!sidebarExpanded" class="invisible absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded-sm bg-slate-900 border border-slate-700 px-2 py-1.5 text-xs font-medium text-white group-hover:visible shadow-lg z-50 whitespace-nowrap">Pembelian</span>
                    </a>
                </li>
                @endif

                {{-- MENU PENJUALAN & REPORT: Untuk Admin dan Apoteker --}}
                @if ($hasAdminAccess || $hasApotekerAccess)
                <li>
                    <a href="{{ route('dashboard.penjualan.index') }}" @class([
                        'group relative flex items-center rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white transition-all duration-300',
                        'bg-slate-700 text-white' => request()->routeIs('dashboard.penjualan.index'),
                    ])>
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out" :class="sidebarExpanded ? 'max-w-[200px] opacity-100' : 'max-w-0 opacity-0'">
                            <span class="text-sm font-medium pr-4">Penjualan</span>
                        </div>
                        <span x-show="!sidebarExpanded" class="invisible absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded-sm bg-slate-900 border border-slate-700 px-2 py-1.5 text-xs font-medium text-white group-hover:visible shadow-lg z-50 whitespace-nowrap">Penjualan</span>
                    </a>
                </li>

                <li>
                    <a href="{{ route('dashboard.penjualan.report') }}" @class([
                        'group relative flex items-center rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white transition-all duration-300',
                        'bg-slate-700 text-white' => request()->routeIs('dashboard.penjualan.report'),
                    ])>
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                        </div>
                        <div class="whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out" :class="sidebarExpanded ? 'max-w-[200px] opacity-100' : 'max-w-0 opacity-0'">
                            <span class="text-sm font-medium pr-4">Report Penjualan</span>
                        </div>
                        <span x-show="!sidebarExpanded" class="invisible absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded-sm bg-slate-900 border border-slate-700 px-2 py-1.5 text-xs font-medium text-white group-hover:visible shadow-lg z-50 whitespace-nowrap">Report Penjualan</span>
                    </a>
                </li>
                @endif

                {{-- MENU SUPPLIER: Hanya untuk Admin --}}
                @if ($hasAdminAccess)
                <li>
                    <a href="{{ route('dashboard.supplier.index') }}" @class([
                        'group relative flex items-center rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white transition-all duration-300',
                        'bg-slate-700 text-white' => request()->routeIs('dashboard.supplier.index'),
                    ])>
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 14v3m4-3v3m4-3v3M3 21h18M3 10h18M3 7l9-4 9 4M4 10h16v11H4V10z" />
                            </svg>
                        </div>
                        <div class="whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out" :class="sidebarExpanded ? 'max-w-[200px] opacity-100' : 'max-w-0 opacity-0'">
                            <span class="text-sm font-medium pr-4">Supplier</span>
                        </div>
                        <span x-show="!sidebarExpanded" class="invisible absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded-sm bg-slate-900 border border-slate-700 px-2 py-1.5 text-xs font-medium text-white group-hover:visible shadow-lg z-50 whitespace-nowrap">Supplier</span>
                    </a>
                </li>
                @endif

                {{-- MENU PELANGGAN: Hanya untuk Admin --}}
                @if ($hasAdminAccess)
                <li>
                    <a href="{{ route('dashboard.pelanggan.index') }}" @class([
                        'group relative flex items-center rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white transition-all duration-300',
                        'bg-slate-700 text-white' => request()->routeIs('dashboard.pelanggan.index'),
                    ])>
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div class="whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out" :class="sidebarExpanded ? 'max-w-[200px] opacity-100' : 'max-w-0 opacity-0'">
                            <span class="text-sm font-medium pr-4">Pelanggan</span>
                        </div>
                        <span x-show="!sidebarExpanded" class="invisible absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded-sm bg-slate-900 border border-slate-700 px-2 py-1.5 text-xs font-medium text-white group-hover:visible shadow-lg z-50 whitespace-nowrap">Pelanggan</span>
                    </a>
                </li>
                @endif

                {{-- MENU USER MANAGEMENT: Hanya untuk Admin --}}
                @if ($hasAdminAccess)
                <li>
                    <a href="{{ route('dashboard.access.index') }}" @class([
                        'group relative flex items-center rounded-lg text-slate-400 hover:bg-slate-700 hover:text-white transition-all duration-300',
                        'bg-slate-700 text-white' => request()->routeIs('dashboard.access.index'),
                    ])>
                        <div class="flex h-10 w-14 shrink-0 items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0a2 2 0 104 0m-5 8a2 2 0 100-4 2 2 0 000 4zm0 0c1.306 0 2.417.835 2.83 2M9 14a3.001 3.001 0 00-2.83 2M15 11h3m-3 4h2" />
                            </svg>
                        </div>
                        <div class="whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out" :class="sidebarExpanded ? 'max-w-[200px] opacity-100' : 'max-w-0 opacity-0'">
                            <span class="text-sm font-medium pr-4">User Management</span>
                        </div>
                        <span x-show="!sidebarExpanded" class="invisible absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded-sm bg-slate-900 border border-slate-700 px-2 py-1.5 text-xs font-medium text-white group-hover:visible shadow-lg z-50 whitespace-nowrap">User Management</span>
                    </a>
                </li>
                @endif
            </ul>
        </div>
    </div>

    <div class="py-2 border-t border-slate-700 px-3 transition-all duration-300">
        <button type="button"
            @click="window.dispatchEvent(new CustomEvent('open-confirm', {
                detail: {
                    title: 'Konfirmasi Logout',
                    message: 'Apakah Anda yakin ingin logout dari sistem?',
                    actionUrl: '{{ route('logout') }}',
                    method: 'POST',
                    btnText: 'Logout',
                    btnColor: 'bg-red-600 hover:bg-red-700 focus:ring-red-500'
                }
            }))"
            class="group cursor-pointer relative w-full text-left flex items-center rounded-lg text-red-400 hover:bg-red-500/10 hover:text-red-500 transition-all duration-300">
            <div class="flex h-10 w-14 shrink-0 items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="size-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
            </div>
            <div class="whitespace-nowrap overflow-hidden transition-all duration-300 ease-in-out"
                :class="sidebarExpanded ? 'max-w-[200px] opacity-100' : 'max-w-0 opacity-0'">
                <span class="text-sm font-medium pr-4">Logout</span>
            </div>
            <span x-show="!sidebarExpanded"
                class="invisible absolute start-full top-1/2 ms-4 -translate-y-1/2 rounded-sm bg-slate-900 border border-slate-700 px-2 py-1.5 text-xs font-medium text-red-500 group-hover:visible shadow-lg z-50 whitespace-nowrap">
                Logout
            </span>
        </button>
    </div>

</div>