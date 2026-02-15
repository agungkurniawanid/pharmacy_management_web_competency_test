<?php

use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ObatController;
use App\Http\Controllers\PelangganController;
use App\Http\Controllers\PembelianController;
use App\Http\Controllers\PenjualanController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SupplierController;
use Illuminate\Auth\Middleware\Authenticate;
use Illuminate\Auth\Middleware\RedirectIfAuthenticated;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    if (Auth::check()) {
        return redirect()->route('dashboard.index');
    }
    return redirect()->route('login');
});

Route::middleware([RedirectIfAuthenticated::class])->group(function () {
    Route::get('/login', [RoleController::class, 'loginView'])->name('login');
    Route::post('/login', [RoleController::class, 'loginFunction'])->name('login.post');
});

Route::post("/logout", [RoleController::class, 'logout'])
    ->name('logout')
    ->middleware([Authenticate::class]);


Route::prefix('dashboard')
    ->name('dashboard.')
    ->middleware([Authenticate::class])
    ->group(function () {

        Route::get('/', [DashboardController::class, 'index'])
            ->name('index');


        Route::prefix('obat')
            ->name('obat.')
            ->group(function () {
                Route::get('/', [ObatController::class, 'index'])
                    ->name('index');
                Route::delete('/{kode_obat}', [ObatController::class, 'destroy'])
                    ->name('destroy');
                Route::post('/', [ObatController::class, 'store'])
                    ->name('store');
                Route::put('/{kode_obat}', [ObatController::class, 'update'])
                    ->name('update');
            });

        Route::prefix('pembelian')
            ->name('pembelian.')
            ->group(function () {
                Route::get('/', [PembelianController::class, 'index'])->name('index');
                Route::post('/', [PembelianController::class, 'store'])->name('store');
                Route::put('/{nota}', [PembelianController::class, 'update'])->name('update');
                Route::delete('/{nota}', [PembelianController::class, 'destroy'])->name('destroy');
            });

        Route::prefix('penjualan')
            ->name('penjualan.')
            ->group(function () {
                Route::get('/', [PenjualanController::class, 'index'])->name('index');
                Route::post('/', [PenjualanController::class, 'store'])->name('store');
                Route::put('/{nota}', [PenjualanController::class, 'update'])->name('update');
                Route::delete('/{nota}', [PenjualanController::class, 'destroy'])->name('destroy');
            });

        Route::prefix('pelanggan')
            ->name('pelanggan.')
            ->group(function () {
                Route::get('/', [PelangganController::class, 'index'])
                    ->name('index');
                Route::post('/', [PelangganController::class, 'store'])->name('store');
                Route::put('/{pelanggan}', [PelangganController::class, 'update'])->name('update');
                Route::delete('/{pelanggan}', [PelangganController::class, 'destroy'])->name('destroy');
            });

        Route::prefix('supplier')
            ->name('supplier.')
            ->group(function () {
                Route::get('/', [SupplierController::class, 'index'])
                    ->name('index');
                Route::post('/', [SupplierController::class, 'store'])
                    ->name('store');
                Route::put('/{kode_supplier}', [SupplierController::class, 'update'])
                    ->name('update');
                Route::delete('/{kode_supplier}', [SupplierController::class, 'destroy'])
                    ->name('destroy');
            });

        Route::prefix('access')
            ->name('access.')
            ->group(function () {
                Route::get('/', [RoleController::class, 'index'])
                    ->name('index');
            });
    });
