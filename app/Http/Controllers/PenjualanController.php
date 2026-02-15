<?php

namespace App\Http\Controllers;

use App\Models\Penjualan;
use App\Models\PenjualanDetail;
use App\Models\Obat;
use App\Models\Pelanggan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Carbon;

class PenjualanController extends Controller
{
    public function index(Request $request)
    {
        // Panggil relasi agar tidak memberatkan database (N+1 Query)
        $query = Penjualan::with(['pelanggan', 'penjualanDetails.obat']);

        // 1. Pencarian Real-time (Nota atau Nama Pelanggan)
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('nota', 'like', '%' . $search . '%')
                  ->orWhereHas('pelanggan', function($qPelanggan) use ($search) {
                      $qPelanggan->where('nama_pelanggan', 'like', '%' . $search . '%');
                  });
            });
        }

        // 2. Filter berdasarkan Pelanggan
        if ($request->filled('pelanggan')) {
            $query->where('kode_pelanggan', $request->pelanggan);
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

        $penjualans = $query->paginate(10)->withQueryString();

        // Data untuk Dropdown (Pelanggan dan Obat)
        $pelanggans = Pelanggan::orderBy('nama_pelanggan', 'asc')->get();
        $obats = Obat::orderBy('nama_obat', 'asc')->get();

        // Data Stats Card
        $totalNota = Penjualan::count();
        $notaBulanIni = Penjualan::whereMonth('tanggal_nota', Carbon::now()->month)
                                 ->whereYear('tanggal_nota', Carbon::now()->year)
                                 ->count();
        $avgDiskon = Penjualan::avg('diskon') ?? 0;
        $pelangganTerlibat = Penjualan::distinct('kode_pelanggan')->count('kode_pelanggan');

        return view('pages.penjualan.index', compact(
            'penjualans', 'pelanggans', 'obats', 'totalNota', 'notaBulanIni', 'avgDiskon', 'pelangganTerlibat'
        ));
    }

    public function store(Request $request)
{
    // 1. Validasi Data
    $request->validate([
        'tanggal_nota'         => 'required|date',
        'kode_pelanggan'       => 'required|string|exists:pelanggans,kode_pelanggan',
        'diskon'               => 'nullable|numeric|min:0|max:100', // Diskon dalam Persen (%)
        'details'              => 'required|array|min:1',
        'details.*.kode_obat'  => 'required|string|exists:obats,kode_obat',
        'details.*.jumlah'     => 'required|integer|min:1',
    ]);

    DB::transaction(function () use ($request) {
        // A. Generate Nomor Nota Otomatis (Kode Anda sebelumnya...)
        $lastPenjualan = Penjualan::orderBy('nota', 'desc')->first();
        $nextNumber = $lastPenjualan ? ((int) substr($lastPenjualan->nota, 4)) + 1 : 1;
        $generatedNota = 'PEN-' . str_pad($nextNumber, 16, '0', STR_PAD_LEFT);

        // B. Hitung Kalkulasi Harga DULU sebelum insert ke Database
        $totalHarga = 0;
        $detailsData = []; // Tampungan sementara untuk array detail

        foreach ($request->details as $detail) {
            // Ambil data obat dari database untuk mendapatkan harga ASLI saat ini
            $obat = Obat::where('kode_obat', $detail['kode_obat'])->first();
            
            $hargaJual = $obat->harga_jual; // Pastikan nama kolomnya sesuai di DB Anda
            $subtotal = $hargaJual * $detail['jumlah'];
            
            $totalHarga += $subtotal; // Tambahkan ke total keseluruhan kotor

            // Simpan ke array sementara
            $detailsData[] = [
                'kode_obat'  => $detail['kode_obat'],
                'jumlah'     => $detail['jumlah'],
                'harga_jual' => $hargaJual,
                'subtotal'   => $subtotal
            ];
        }

        // C. Hitung Diskon dan Grand Total
        $diskonPersen = $request->diskon ?? 0;
        // Rumus: Total Kotor - (Total Kotor * (Diskon / 100))
        $potonganNominal = $totalHarga * ($diskonPersen / 100);
        $grandTotal = $totalHarga - $potonganNominal;

        // D. Simpan Data Master (Nota) beserta Totalnya
        $penjualan = Penjualan::create([
            'nota'           => $generatedNota,
            'tanggal_nota'   => $request->tanggal_nota,
            'kode_pelanggan' => $request->kode_pelanggan,
            'diskon'         => $diskonPersen,
            'total_harga'    => $totalHarga,
            'grand_total'    => $grandTotal // Inilah yang ditagihkan ke pelanggan
        ]);

        // E. Simpan Detail dan Kurangi Stok
        foreach ($detailsData as $item) {
            PenjualanDetail::create([
                'nota'       => $penjualan->nota,
                'kode_obat'  => $item['kode_obat'],
                'jumlah'     => $item['jumlah'],
                'harga_jual' => $item['harga_jual'], // Harga historis tersimpan aman
                'subtotal'   => $item['subtotal']
            ]);

            // Query otomatis mengurangi stok
            Obat::where('kode_obat', $item['kode_obat'])->decrement('stok', $item['jumlah']);
        }
    });

    return redirect()->route('dashboard.penjualan.index')
        ->with('success', 'Nota berhasil disimpan, harga telah dikalkulasi, dan stok obat otomatis dikurangi!');
}

    public function update(Request $request, string $nota)
    {
        $request->validate([
            'tanggal_nota'          => 'required|date',
            'kode_pelanggan'        => 'required|string|exists:pelanggans,kode_pelanggan',
            'diskon'                => 'nullable|numeric|min:0|max:100',
            'details'               => 'required|array|min:1',
            'details.*.kode_obat'   => 'required|string|exists:obats,kode_obat',
            'details.*.jumlah'      => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $nota) {
            $penjualan = Penjualan::with('penjualanDetails')->findOrFail($nota);

            // A. KEMBALIKAN (TAMBAH) STOK LAMA DULU
            foreach ($penjualan->penjualanDetails as $oldDetail) {
                Obat::where('kode_obat', $oldDetail->kode_obat)->increment('stok', $oldDetail->jumlah);
            }

            // B. Hapus riwayat detail lama
            $penjualan->penjualanDetails()->delete();

            // C. Update data Master Nota
            $penjualan->update($request->only(['tanggal_nota', 'kode_pelanggan', 'diskon']));

            // D. Simpan Detail Baru & KURANGI STOK BARU
            foreach ($request->details as $detail) {
                PenjualanDetail::create([
                    'nota'      => $penjualan->nota,
                    'kode_obat' => $detail['kode_obat'],
                    'jumlah'    => $detail['jumlah']
                ]);
                Obat::where('kode_obat', $detail['kode_obat'])->decrement('stok', $detail['jumlah']);
            }
        });

        return redirect()->route('dashboard.penjualan.index')
                         ->with('success', 'Nota berhasil diperbarui dan stok obat otomatis disesuaikan ulang!');
    }

    public function destroy(string $nota)
    {
        DB::transaction(function () use ($nota) {
            $penjualan = Penjualan::with('penjualanDetails')->findOrFail($nota);
            
            // SEBELUM NOTA DIHAPUS, TAMBAH DULU STOK OBAT YANG TADINYA BERKURANG
            foreach ($penjualan->penjualanDetails as $detail) {
                Obat::where('kode_obat', $detail->kode_obat)->increment('stok', $detail->jumlah);
            }

            // Hapus Nota (Cascade otomatis menghapus detail)
            $penjualan->delete(); 
        });

        return redirect()->route('dashboard.penjualan.index')
                         ->with('success', 'Nota dihapus dan stok obat terkait berhasil ditambahkan kembali.');
    }
}
