@extends('layouts.main-layout')

@section('content')

    <!-- Header -->
    <div class="mb-8">
        <h1 class="text-3xl font-bold text-white">Dashboard</h1>
        <p class="text-slate-400 mt-2">Selamat datang kembali, Agung Kurniawan</p>
    </div>

    <!-- Stats Cards -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        <!-- Card 1 - Total Obat -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 hover:border-blue-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-blue-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-purple-600 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19.428 15.428a2 2 0 00-1.022-.547l-2.387-.477a6 6 0 00-3.86.517l-.318.158a6 6 0 01-3.86.517L6.05 15.21a2 2 0 00-1.806.547M8 4h8l-1 1v5.172a2 2 0 00.586 1.414l5 5c1.26 1.26.367 3.414-1.415 3.414H4.828c-1.782 0-2.674-2.154-1.414-3.414l5-5A2 2 0 009 10.172V5L8 4z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-green-400 bg-green-400/10 px-2 py-1 rounded-full">+12%</span>
            </div>
            <h3 class="text-slate-400 text-sm font-medium mb-1">Total Obat</h3>
            <p class="text-2xl font-bold text-white">1,247</p>
        </div>

        <!-- Card 2 - Pembelian Hari Ini -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 hover:border-indigo-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-indigo-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-br from-indigo-500 to-blue-600 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-blue-400 bg-blue-400/10 px-2 py-1 rounded-full">+8%</span>
            </div>
            <h3 class="text-slate-400 text-sm font-medium mb-1">Pembelian Hari Ini</h3>
            <p class="text-2xl font-bold text-white">Rp 2.4M</p>
        </div>

        <!-- Card 3 - Penjualan Hari Ini -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 hover:border-emerald-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-emerald-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-emerald-400 bg-emerald-400/10 px-2 py-1 rounded-full">+23%</span>
            </div>
            <h3 class="text-slate-400 text-sm font-medium mb-1">Penjualan Hari Ini</h3>
            <p class="text-2xl font-bold text-white">Rp 5.7M</p>
        </div>

        <!-- Card 4 - Total Pelanggan -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50 hover:border-purple-500/50 transition-all duration-300 hover:shadow-lg hover:shadow-purple-500/20">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-gradient-to-br from-purple-500 to-pink-600 rounded-xl">
                    <svg xmlns="http://www.w3.org/2000/svg" class="size-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                </div>
                <span class="text-xs font-medium text-purple-400 bg-purple-400/10 px-2 py-1 rounded-full">+5%</span>
            </div>
            <h3 class="text-slate-400 text-sm font-medium mb-1">Total Pelanggan</h3>
            <p class="text-2xl font-bold text-white">892</p>
        </div>
    </div>

    <!-- Recent Activity Section -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <!-- Recent Transactions -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">Transaksi Terbaru</h2>
                <a href="#" class="text-sm text-blue-400 hover:text-blue-300 font-medium">Lihat Semua →</a>
            </div>
            
            <div class="space-y-4">
                <div class="flex items-center justify-between p-4 bg-slate-900/50 rounded-xl hover:bg-slate-900/80 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="p-2 bg-green-500/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium">Penjualan Obat</p>
                            <p class="text-sm text-slate-400">2 menit yang lalu</p>
                        </div>
                    </div>
                    <p class="text-green-400 font-semibold">+Rp 145.000</p>
                </div>

                <div class="flex items-center justify-between p-4 bg-slate-900/50 rounded-xl hover:bg-slate-900/80 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="p-2 bg-red-500/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium">Pembelian Stock</p>
                            <p class="text-sm text-slate-400">15 menit yang lalu</p>
                        </div>
                    </div>
                    <p class="text-red-400 font-semibold">-Rp 850.000</p>
                </div>

                <div class="flex items-center justify-between p-4 bg-slate-900/50 rounded-xl hover:bg-slate-900/80 transition-colors">
                    <div class="flex items-center gap-4">
                        <div class="p-2 bg-green-500/10 rounded-lg">
                            <svg xmlns="http://www.w3.org/2000/svg" class="size-5 text-green-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                            </svg>
                        </div>
                        <div>
                            <p class="text-white font-medium">Penjualan Obat</p>
                            <p class="text-sm text-slate-400">1 jam yang lalu</p>
                        </div>
                    </div>
                    <p class="text-green-400 font-semibold">+Rp 320.000</p>
                </div>
            </div>
        </div>

        <!-- Low Stock Alert -->
        <div class="bg-slate-800/50 backdrop-blur-sm rounded-2xl p-6 border border-slate-700/50">
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-white">Stock Menipis</h2>
                <span class="text-xs font-medium text-orange-400 bg-orange-400/10 px-3 py-1 rounded-full">5 Item</span>
            </div>
            
            <div class="space-y-4">
                <div class="p-4 bg-slate-900/50 rounded-xl border-l-4 border-orange-500">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-white font-medium">Paracetamol 500mg</p>
                        <span class="text-orange-400 text-sm font-semibold">12 pcs</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: 20%"></div>
                    </div>
                </div>

                <div class="p-4 bg-slate-900/50 rounded-xl border-l-4 border-red-500">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-white font-medium">Amoxicillin 500mg</p>
                        <span class="text-red-400 text-sm font-semibold">5 pcs</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-red-500 h-2 rounded-full" style="width: 8%"></div>
                    </div>
                </div>

                <div class="p-4 bg-slate-900/50 rounded-xl border-l-4 border-orange-500">
                    <div class="flex items-center justify-between mb-2">
                        <p class="text-white font-medium">Vitamin C 1000mg</p>
                        <span class="text-orange-400 text-sm font-semibold">18 pcs</span>
                    </div>
                    <div class="w-full bg-slate-700 rounded-full h-2">
                        <div class="bg-orange-500 h-2 rounded-full" style="width: 30%"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection