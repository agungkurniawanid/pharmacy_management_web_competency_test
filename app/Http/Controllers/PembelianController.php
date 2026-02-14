<?php

namespace App\Http\Controllers;

use App\Models\Pembelian;
use App\Models\PembelianDetail;
use App\Models\Obat;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PembelianController extends Controller
{
    public function index(Request $request)
    {
        // Panggil relasi agar tidak memberatkan database (N+1 Query)
        $query = Pembelian::with(['supplier', 'pembelianDetails.obat']);

        // 1. Pencarian Real-time (Nota atau Nama Supplier)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nota', 'like', '%' . $search . '%')
                  ->orWhereHas('supplier', function($qSupplier) use ($search) {
                      $qSupplier->where('nama_supplier', 'like', '%' . $search . '%');
                  });
            });
        }

        // 2. Filter berdasarkan Supplier
        if ($request->filled('supplier')) {
            $query->where('kode_supplier', $request->supplier);
        }

        // 3. Sorting berdasarkan Tanggal Nota
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest('tanggal_nota');
                break;
            case 'diskon_high':
                $query->orderBy('diskon', 'desc');
                break;
            default: // newest
                $query->latest('tanggal_nota');
                break;
        }

        $pembelians = $query->paginate(10)->withQueryString();

        // Data untuk Dropdown (Supplier dan Obat)
        $suppliers = Supplier::orderBy('nama_supplier', 'asc')->get();
        $obats = Obat::orderBy('nama_obat', 'asc')->get();

        // Data Stats Card
        $totalNota = Pembelian::count();
        $notaBulanIni = Pembelian::whereMonth('tanggal_nota', Carbon::now()->month)
                                 ->whereYear('tanggal_nota', Carbon::now()->year)
                                 ->count();
        $avgDiskon = Pembelian::avg('diskon') ?? 0;
        $supplierTerlibat = Pembelian::distinct('kode_supplier')->count('kode_supplier');

        return view('pages.pembelian.index', compact(
            'pembelians', 'suppliers', 'obats', 'totalNota', 'notaBulanIni', 'avgDiskon', 'supplierTerlibat'
        ));
    }

    public function store(Request $request)
    {
        // 1. Validasi Data Induk & Array Detail
        $request->validate([
            'nota'                  => 'required|string|max:20|unique:pembelians,nota',
            'tanggal_nota'          => 'required|date',
            'kode_supplier'         => 'required|string|exists:suppliers,kode_supplier',
            'diskon'                => 'nullable|numeric|min:0|max:100',
            'details'               => 'required|array|min:1', // Wajib ada minimal 1 baris obat
            'details.*.kode_obat'   => 'required|string|exists:obats,kode_obat',
            'details.*.jumlah'      => 'required|integer|min:1',
        ], [
            'nota.unique' => 'Nomor Nota sudah terdaftar.',
            'details.required' => 'Anda harus menambahkan minimal 1 obat ke dalam nota.'
        ]);

        // 2. Eksekusi Menggunakan Database Transaction
        DB::transaction(function () use ($request) {
            // A. Simpan Data Master (Nota)
            $pembelian = Pembelian::create($request->only(['nota', 'tanggal_nota', 'kode_supplier', 'diskon']));

            // B. Simpan Array Detail & TAMBAH STOK OBAT
            foreach ($request->details as $detail) {
                PembelianDetail::create([
                    'nota'      => $pembelian->nota,
                    'kode_obat' => $detail['kode_obat'],
                    'jumlah'    => $detail['jumlah']
                ]);

                // Query otomatis menambah stok
                Obat::where('kode_obat', $detail['kode_obat'])->increment('stok', $detail['jumlah']);
            }
        });

        return redirect()->route('dashboard.pembelian.index')
                         ->with('success', 'Nota berhasil disimpan dan stok obat telah ditambahkan otomatis!');
    }

    public function update(Request $request, string $nota)
    {
        $request->validate([
            'tanggal_nota'          => 'required|date',
            'kode_supplier'         => 'required|string|exists:suppliers,kode_supplier',
            'diskon'                => 'nullable|numeric|min:0|max:100',
            'details'               => 'required|array|min:1',
            'details.*.kode_obat'   => 'required|string|exists:obats,kode_obat',
            'details.*.jumlah'      => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $nota) {
            $pembelian = Pembelian::with('pembelianDetails')->findOrFail($nota);

            // A. KEMBALIKAN (KURANGI) STOK LAMA DULU
            foreach ($pembelian->pembelianDetails as $oldDetail) {
                Obat::where('kode_obat', $oldDetail->kode_obat)->decrement('stok', $oldDetail->jumlah);
            }

            // B. Hapus riwayat detail lama
            $pembelian->pembelianDetails()->delete();

            // C. Update data Master Nota
            $pembelian->update($request->only(['tanggal_nota', 'kode_supplier', 'diskon']));

            // D. Simpan Detail Baru & TAMBAH STOK BARU
            foreach ($request->details as $detail) {
                PembelianDetail::create([
                    'nota'      => $pembelian->nota,
                    'kode_obat' => $detail['kode_obat'],
                    'jumlah'    => $detail['jumlah']
                ]);
                Obat::where('kode_obat', $detail['kode_obat'])->increment('stok', $detail['jumlah']);
            }
        });

        return redirect()->route('dashboard.pembelian.index')
                         ->with('success', 'Nota berhasil diperbarui dan stok obat otomatis disesuaikan ulang!');
    }

    public function destroy(string $nota)
    {
        DB::transaction(function () use ($nota) {
            $pembelian = Pembelian::with('pembelianDetails')->findOrFail($nota);
            
            // SEBELUM NOTA DIHAPUS, KURANGI DULU STOK OBAT YANG TELANJUR MASUK
            foreach ($pembelian->pembelianDetails as $detail) {
                Obat::where('kode_obat', $detail->kode_obat)->decrement('stok', $detail->jumlah);
            }

            // Hapus Nota (Cascade otomatis menghapus detail)
            $pembelian->delete(); 
        });

        return redirect()->route('dashboard.pembelian.index')
                         ->with('success', 'Nota dihapus dan stok obat terkait berhasil ditarik kembali.');
    }
}