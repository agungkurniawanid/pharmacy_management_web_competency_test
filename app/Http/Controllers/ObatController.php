<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ObatController extends Controller
{
    
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = Obat::with('supplier');

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_obat', 'like', '%' . $search . '%')
                  ->orWhere('kode_obat', 'like', '%' . $search . '%')
                  ->orWhere('jenis', 'like', '%' . $search . '%');
            });
        }

        
        if ($request->filled('jenis')) {
            $query->where('jenis', $request->jenis);
        }

        
        if ($request->filled('supplier')) {
            $query->where('kode_supplier', $request->supplier);
        }

        if ($request->has('status_stok') && $request->status_stok == 'menipis') {
            $query->where('stok', '<=', 10);
        }

        
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'name_asc':
                $query->orderBy('nama_obat', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama_obat', 'desc');
                break;
            case 'stock_low':
                $query->orderBy('stok', 'asc');
                break;
            case 'stock_high':
                $query->orderBy('stok', 'desc');
                break;
            default: 
                $query->latest('created_at');
                break;
        }

        
        $obats = $query->paginate(10)->withQueryString();
        $lowStockCount = Obat::where('stok', '<=', 10)->count();
        $totalStockValue = Obat::sum(DB::raw('stok * harga_jual'));
        $jenisCount = Obat::distinct('jenis')->count('jenis');
        $suppliers = Supplier::orderBy('nama_supplier', 'asc')->get();
        $jenisObats = Obat::distinct('jenis')->orderBy('jenis', 'asc')->pluck('jenis');

        return view('pages.obat.index', compact(
            'obats', 'lowStockCount', 'totalStockValue', 'jenisCount', 'suppliers', 'jenisObats'
        ));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $suppliers = Supplier::all();
        return view('obat.create', compact('suppliers'));
    }

    /**
     * Store a newly created resource in storage.
     */
   public function store(Request $request)
    {
        
        
        $request->merge([
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
        ]);

        $validated = $request->validate([
            'nama_obat'     => 'required|string|max:50',
            'jenis'         => 'required|string|max:50',
            'satuan'        => 'required|string|max:50',
            'harga_beli'    => 'required|integer|min:0', 
            'harga_jual'    => 'required|integer|min:0', 
            'stok'          => 'required|integer|min:0',
            'kode_supplier' => 'required|string|exists:suppliers,kode_supplier',
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

    /**
     * Display the specified resource.
     */
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

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $kode_obat)
    {
        $obat = Obat::findOrFail($kode_obat);

        
        $request->merge([
            'harga_beli' => str_replace('.', '', $request->harga_beli),
            'harga_jual' => str_replace('.', '', $request->harga_jual),
        ]);

        
        $validated = $request->validate([
            'nama_obat'     => 'required|string|max:50',
            'jenis'         => 'required|string|max:50',
            'satuan'        => 'required|string|max:50',
            'harga_beli'    => 'required|integer|min:0',
            'harga_jual'    => 'required|integer|min:0',
            'stok'          => 'required|integer|min:0',
            'kode_supplier' => 'required|string|exists:suppliers,kode_supplier',
        ], [
            'kode_supplier.exists' => 'Supplier yang dipilih tidak valid.'
        ]);

        
        $obat->update($validated);

        return redirect()->route('dashboard.obat.index')
                         ->with('success', 'Data obat ' . $request->nama_obat . ' berhasil diperbarui!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $kode_obat)
    {
        $obat = Obat::findOrFail($kode_obat);
        $obat->delete();

        return redirect()->route('dashboard.obat.index')->with('success', 'Data obat berhasil dihapus!');
    }

}
