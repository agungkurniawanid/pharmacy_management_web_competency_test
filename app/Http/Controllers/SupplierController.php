<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class SupplierController extends Controller
{
    public function index(Request $request)
    {
        // 1. Pencarian Real-time (Nama atau Kota)
        $query = Supplier::query();

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nama_supplier', 'like', '%' . $search . '%')
                  ->orWhere('kota', 'like', '%' . $search . '%')
                  ->orWhere('telpon', 'like', '%' . $search . '%');
            });
        }

        // 2. Filter berdasarkan Status Aktif
        if ($request->filled('status')) {
            $query->where('aktif', $request->status === 'aktif' ? 1 : 0);
        }

        // 3. Sorting
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'nama_asc':
                $query->orderBy('nama_supplier', 'asc');
                break;
            case 'nama_desc':
                $query->orderBy('nama_supplier', 'desc');
                break;
            default: // newest
                $query->latest('created_at');
                break;
        }

        $suppliers = $query->paginate(10)->withQueryString();

        // Data Stats Card
        $totalSupplier = Supplier::count();
        $supplierAktif = Supplier::where('aktif', true)->count();
        $supplierNonaktif = Supplier::where('aktif', false)->count();
        $kotaCakupan = Supplier::distinct('kota')->count('kota');
        $supplierBaru = Supplier::whereMonth('created_at', now()->month)
                                ->whereYear('created_at', now()->year)
                                ->count();

        return view('pages.supplier.index', compact(
            'suppliers', 'totalSupplier', 'supplierAktif', 'supplierNonaktif', 'kotaCakupan', 'supplierBaru'
        ));
    }

    public function store(Request $request)
    {
        $request->validate([
            'kode_supplier'  => 'required|string|max:20|unique:suppliers,kode_supplier',
            'nama_supplier'  => 'required|string|max:100',
            'alamat'         => 'nullable|string',
            'kota'           => 'nullable|string|max:50',
            'telpon'         => 'nullable|string|max:13',
            'aktif'          => 'boolean',
            'catatan'        => 'nullable|string',
        ]);

        Supplier::create($request->only([
            'kode_supplier', 'nama_supplier', 'alamat', 'kota', 'telpon', 'aktif', 'catatan'
        ]));

        return redirect()->route('dashboard.supplier.index')
                         ->with('success', 'Supplier berhasil ditambahkan!');
    }

    public function update(Request $request, string $kode_supplier)
    {
        $supplier = Supplier::findOrFail($kode_supplier);

        $request->validate([
            'nama_supplier'  => 'required|string|max:100',
            'alamat'         => 'nullable|string',
            'kota'           => 'nullable|string|max:50',
            'telpon'         => 'nullable|string|max:13',
            'aktif'          => 'boolean',
            'catatan'        => 'nullable|string',
        ]);

        $supplier->update($request->only([
            'nama_supplier', 'alamat', 'kota', 'telpon', 'aktif', 'catatan'
        ]));

        return redirect()->route('dashboard.supplier.index')
                         ->with('success', 'Supplier berhasil diperbarui!');
    }

    public function destroy(string $kode_supplier)
    {
        $supplier = Supplier::findOrFail($kode_supplier);

        // Check if supplier has related data
        if ($supplier->obats()->exists()) {
            return redirect()->route('dashboard.supplier.index')
                             ->with('error', 'Tidak bisa menghapus supplier! Masih ada obat yang terkait.');
        }

        if ($supplier->pembelians()->exists()) {
            return redirect()->route('dashboard.supplier.index')
                             ->with('error', 'Tidak bisa menghapus supplier! Masih ada pembelian yang terkait.');
        }

        $supplier->delete();

        return redirect()->route('dashboard.supplier.index')
                         ->with('success', 'Supplier berhasil dihapus!');
    }
}
