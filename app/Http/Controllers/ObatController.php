<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    public function show(string $kode_obat)
    {
        $obat = Obat::with('supplier')->findOrFail($kode_obat);
        return view('obat.show', compact('obat'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $kode_obat)
    {
        $obat = Obat::findOrFail($kode_obat);
        $suppliers = Supplier::all();
        return view('obat.edit', compact('obat', 'suppliers'));
    }

    // public function index(Request $request)
    // {
    //     $query = Obat::with('supplier');

    //     // 1. Search
    //     if ($request->filled('search')) {
    //         $search = $request->search;
    //         $query->where(function($q) use ($search) {
    //             $q->where('nama_obat', 'like', '%' . $search . '%')
    //               ->orWhere('kode_obat', 'like', '%' . $search . '%')
    //               ->orWhere('jenis', 'like', '%' . $search . '%');
    //         });
    //     }

    //     // 2. Filters
    //     if ($request->filled('jenis')) {
    //         $query->where('jenis', $request->jenis);
    //     }
    //     if ($request->filled('supplier')) {
    //         $query->where('kode_supplier', $request->supplier);
    //     }
    //     if ($request->filled('status')) {
    //         $query->where('status', $request->status);
    //     }

    //     // Filter Stok Menipis
    //     if ($request->has('status_stok') && $request->status_stok == 'menipis') {
    //         $query->where('stok', '<=', 10);
    //     }

    //     // FILTER BARU: Obat Hampir Kedaluwarsa (Dalam 90 Hari ke depan)
    //     if ($request->has('filter_exp') && $request->filter_exp == 'hampir_habis') {
    //         $query->whereBetween('tgl_kadaluarsa', [Carbon::now(), Carbon::now()->addDays(90)]);
    //     }

    //     // 3. Sorting
    //     switch ($request->get('sort', 'newest')) {
    //         case 'oldest':
    //             $query->oldest('created_at');
    //             break;
    //         case 'name_asc':
    //             $query->orderBy('nama_obat', 'asc');
    //             break;
    //         case 'name_desc':
    //             $query->orderBy('nama_obat', 'desc');
    //             break;
    //         case 'stock_low':
    //             $query->orderBy('stok', 'asc');
    //             break;
    //         case 'stock_high':
    //             $query->orderBy('stok', 'desc');
    //             break;
    //         case 'exp_near': // SORTING BARU: Urutkan dari yang paling cepat expired
    //             $query->whereNotNull('tgl_kadaluarsa')->orderBy('tgl_kadaluarsa', 'asc');
    //             break;
    //         default: 
    //             $query->latest('created_at');
    //             break;
    //     }

    //     $obats = $query->paginate(10)->withQueryString();
        
    //     $lowStockCount = Obat::where('stok', '<=', 10)->count();
    //     $totalStockValue = Obat::where('status', 'Aktif')->sum(DB::raw('stok * harga_jual'));
    //     $jenisCount = Obat::distinct('jenis')->count('jenis');
        
    //     // Count obat yang hampir kedaluwarsa (<= 90 hari)
    //     $expiringCount = Obat::whereBetween('tgl_kadaluarsa', [Carbon::now(), Carbon::now()->addDays(90)])->count();

    //     $suppliers = Supplier::orderBy('nama_supplier', 'asc')->get();
    //     $jenisObats = Obat::distinct('jenis')->orderBy('jenis', 'asc')->pluck('jenis');

    //     return view('pages.obat.index', compact(
    //         'obats', 'lowStockCount', 'totalStockValue', 'jenisCount', 'suppliers', 'jenisObats', 'expiringCount'
    //     ));
    // }

    public function index(Request $request)
    {
        $namaRole = session('user_role.nama_role', '');
        $isPelanggan = str_contains(strtolower($namaRole), 'pelanggan');

        $query = Obat::with('supplier');

        // Untuk pelanggan, hanya tampilkan obat aktif
        if ($isPelanggan) {
            $query->where('status', 'Aktif');
        }

        // 1. Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_obat', 'like', "%{$search}%")
                  ->orWhere('nama_obat', 'like', "%{$search}%")
                  ->orWhere('jenis', 'like', "%{$search}%");
            });
        }

        // 2. Filter Jenis
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        // 3. Filter Status (khusus non-pelanggan)
        if (!$isPelanggan && $request->filled('status')) {
            $query->where('status', $request->status);
        }

        // 4. Filter Stok Menipis
        if ($request->filled('status_stok') && $request->status_stok == 'menipis') {
            $query->where('stok', '<=', 10);
        }

        // 5. Filter Expired
        if ($request->filled('filter_exp') && $request->filter_exp == 'hampir_habis') {
            $query->whereNotNull('tgl_kadaluarsa')
                  ->whereRaw('DATEDIFF(tgl_kadaluarsa, NOW()) <= 90')
                  ->whereRaw('DATEDIFF(tgl_kadaluarsa, NOW()) >= 0');
        }

        // 6. Sorting
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'name_asc':
                $query->orderBy('nama_obat', 'asc');
                break;
            case 'stock_low':
                $query->orderBy('stok', 'asc');
                break;
            case 'exp_near':
                if (!$isPelanggan) {
                    $query->whereNotNull('tgl_kadaluarsa')->orderBy('tgl_kadaluarsa', 'asc');
                }
                break;
            default: // newest
                $query->latest('created_at');
                break;
        }

        $obats = $query->paginate(10)->withQueryString();

        // Stats (khusus non-pelanggan)
        $lowStockCount = 0;
        $expiringCount = 0;
        $totalStockValue = 0;

        if (!$isPelanggan) {
            $lowStockCount = Obat::where('stok', '<=', 10)->count();
            $expiringCount = Obat::whereNotNull('tgl_kadaluarsa')
                                  ->whereRaw('DATEDIFF(tgl_kadaluarsa, NOW()) <= 90')
                                  ->whereRaw('DATEDIFF(tgl_kadaluarsa, NOW()) >= 0')
                                  ->count();
            $totalStockValue = Obat::where('status', 'Aktif')
                                   ->selectRaw('SUM(harga_beli * stok) as total')
                                   ->value('total') ?? 0;
        }

        $jenisObats = Obat::select('jenis')->distinct()->orderBy('jenis')->pluck('jenis');
        $suppliers = Supplier::all();

        return view('pages.obat.index', compact(
            'obats', 'jenisObats', 'suppliers', 
            'lowStockCount', 'expiringCount', 'totalStockValue'
        ))->with('title', 'Dashboard | Data Obat');
    }

    public function store(Request $request)
    {
        $request->merge([
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
        ]);

        $validated = $request->validate([
            'nama_obat'      => 'required|string|max:50',
            'jenis'          => 'required|string|max:50',
            'satuan'         => 'required|string|max:50',
            'harga_beli'     => 'required|integer|min:0', 
            'harga_jual'     => 'required|integer|min:0', 
            'stok'           => 'required|integer|min:0',
            'kode_supplier'  => 'required|string|exists:suppliers,kode_supplier',
            'tgl_kadaluarsa' => 'nullable|date',
            'status'         => 'required|in:Aktif,Nonaktif,Ditarik',
        ], [
            'kode_supplier.exists' => 'Supplier yang dipilih tidak valid.'
        ]);

        $lastObat = Obat::latest('created_at')->first();
        if ($lastObat) {
            $lastNumber = (int) substr($lastObat->kode_obat, 4); 
            $nextNumber = $lastNumber + 1;
        } else {
            $nextNumber = 1;
        }
        
        $validated['kode_obat'] = 'OBT-' . str_pad($nextNumber, 16, '0', STR_PAD_LEFT);

        Obat::create($validated);

        return redirect()->route('dashboard.obat.index')
                         ->with('success', 'Data obat ' . $request->nama_obat . ' berhasil ditambahkan!');
    }

    public function update(Request $request, string $kode_obat)
    {
        $obat = Obat::findOrFail($kode_obat);

        $request->merge([
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
        ]);

        $validated = $request->validate([
            'nama_obat'      => 'required|string|max:50',
            'jenis'          => 'required|string|max:50',
            'satuan'         => 'required|string|max:50',
            'harga_beli'     => 'required|integer|min:0',
            'harga_jual'     => 'required|integer|min:0',
            'stok'           => 'required|integer|min:0',
            'kode_supplier'  => 'required|string|exists:suppliers,kode_supplier',
            'tgl_kadaluarsa' => 'nullable|date',
            'status'         => 'required|in:Aktif,Nonaktif,Ditarik',
        ]);

        $obat->update($validated);

        return redirect()->route('dashboard.obat.index')
                         ->with('success', 'Data obat ' . $request->nama_obat . ' berhasil diperbarui!');
    }

    public function destroy(string $kode_obat)
    {
        $obat = Obat::findOrFail($kode_obat);
        $obat->delete();

        return redirect()->route('dashboard.obat.index')->with('success', 'Data obat berhasil dihapus!');
    }

}
