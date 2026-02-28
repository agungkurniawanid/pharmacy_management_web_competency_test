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
        // Deteksi Role Pelanggan
        $namaRole = session('user_role.nama_role', '');
        $isPelanggan = str_contains(strtolower($namaRole), 'pelanggan');

        // Panggil relasi agar tidak memberatkan database (N+1 Query)
        $query = Penjualan::with(['pelanggan', 'penjualanDetails.obat']);

        // ===== FILTER KHUSUS PELANGGAN =====
        // Jika user adalah pelanggan, hanya tampilkan transaksi miliknya sendiri
        if ($isPelanggan) {
            $kodePelanggan = session('user.kode_pelanggan');
            if (!$kodePelanggan) {
                return redirect()->route('dashboard.index')
                    ->with('error', 'Kode pelanggan tidak ditemukan di session!');
            }
            $query->where('kode_pelanggan', $kodePelanggan);
        }

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

        // 2. Filter berdasarkan Pelanggan (HANYA UNTUK NON-PELANGGAN)
        if (!$isPelanggan && $request->filled('pelanggan')) {
            $query->where('kode_pelanggan', $request->pelanggan);
        }

        // 3. Sorting berdasarkan Tanggal Nota
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest('tanggal_nota');
                break;
            case 'total_high':
                $query->orderBy('grand_total', 'desc');
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
        $obats = Obat::where('status', 'Aktif')->orderBy('nama_obat', 'asc')->get();

        // ===== DATA STATS CARD (DISESUAIKAN DENGAN ROLE) =====
        if ($isPelanggan) {
            $kodePelanggan = session('user.kode_pelanggan');
            
            // Stats khusus pelanggan (hanya transaksi mereka)
            $totalNota = Penjualan::where('kode_pelanggan', $kodePelanggan)->count();
            
            $notaBulanIni = Penjualan::where('kode_pelanggan', $kodePelanggan)
                ->whereMonth('tanggal_nota', Carbon::now()->month)
                ->whereYear('tanggal_nota', Carbon::now()->year)
                ->count();
            
            $totalBelanja = Penjualan::where('kode_pelanggan', $kodePelanggan)
                ->sum('grand_total');
            
            $avgDiskon = Penjualan::where('kode_pelanggan', $kodePelanggan)
                ->avg('diskon') ?? 0;
            
            $pelangganTerlibat = 0; // Tidak relevan untuk pelanggan
        } else {
            // Stats untuk Admin/Staff (semua transaksi)
            $totalNota = Penjualan::count();
            
            $notaBulanIni = Penjualan::whereMonth('tanggal_nota', Carbon::now()->month)
                ->whereYear('tanggal_nota', Carbon::now()->year)
                ->count();
            
            $totalBelanja = Penjualan::sum('grand_total');
            
            $avgDiskon = Penjualan::avg('diskon') ?? 0;
            
            $pelangganTerlibat = Penjualan::distinct('kode_pelanggan')
                ->count('kode_pelanggan');
        }

        return view('pages.penjualan.index', compact(
            'penjualans', 'pelanggans', 'obats', 
            'totalNota', 'notaBulanIni', 'totalBelanja', 'avgDiskon', 'pelangganTerlibat'
        ));
    }

    public function store(Request $request)
    {
        // Deteksi Role Pelanggan
        $namaRole = session('user_role.nama_role', '');
        $isPelanggan = str_contains(strtolower($namaRole), 'pelanggan');

        // 1. Validasi Data
        $rules = [
            'tanggal_nota'         => 'required|date',
            'kode_pelanggan'       => 'required|string|exists:pelanggans,kode_pelanggan',
            'details'              => 'required|array|min:1',
            'details.*.kode_obat'  => 'required|string|exists:obats,kode_obat',
            'details.*.jumlah'     => 'required|integer|min:1',
        ];

        // Jika pelanggan, diskon HARUS 0 atau diabaikan
        // Jika bukan pelanggan, diskon bisa diinput
        if (!$isPelanggan) {
            $rules['diskon'] = 'nullable|numeric|min:0|max:100';
        }

        $validated = $request->validate($rules);

        // ===== VALIDASI KEAMANAN UNTUK PELANGGAN =====
        if ($isPelanggan) {
            $kodePelangganSession = session('user.kode_pelanggan');
            
            // Pastikan pelanggan hanya bisa checkout untuk dirinya sendiri
            if ($request->kode_pelanggan !== $kodePelangganSession) {
                return redirect()->back()
                    ->with('error', 'Anda tidak berhak membuat transaksi untuk pelanggan lain!');
            }
            
            // Paksa diskon = 0 untuk pelanggan
            $validated['diskon'] = 0;
        }

        DB::transaction(function () use ($request, $validated, $isPelanggan) {
            // A. Generate Nomor Nota Otomatis
            $lastPenjualan = Penjualan::orderBy('nota', 'desc')->first();
            $nextNumber = $lastPenjualan ? ((int) substr($lastPenjualan->nota, 4)) + 1 : 1;
            $generatedNota = 'PEN-' . str_pad($nextNumber, 16, '0', STR_PAD_LEFT);

            // B. Hitung Kalkulasi Harga DULU sebelum insert ke Database
            $totalHarga = 0;
            $detailsData = []; // Tampungan sementara untuk array detail

            foreach ($request->details as $detail) {
                // Ambil data obat dari database untuk mendapatkan harga ASLI saat ini
                $obat = Obat::where('kode_obat', $detail['kode_obat'])->first();
                
                // ===== VALIDASI STOK =====
                if ($obat->stok < $detail['jumlah']) {
                    throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi! Tersedia: {$obat->stok}, Diminta: {$detail['jumlah']}");
                }
                
                // ===== VALIDASI STATUS OBAT (Khusus untuk Pelanggan) =====
                if ($isPelanggan && $obat->status !== 'Aktif') {
                    throw new \Exception("Obat {$obat->nama_obat} tidak tersedia untuk dibeli!");
                }
                
                // Gunakan harga_jual dari request jika ada (untuk konsistensi keranjang pelanggan)
                // Jika tidak ada, gunakan harga dari database
                $hargaJual = isset($detail['harga_jual']) ? $detail['harga_jual'] : $obat->harga_jual;
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
            $diskonPersen = $validated['diskon'] ?? 0;
            
            // Rumus: Total Kotor - (Total Kotor * (Diskon / 100))
            $potonganNominal = $totalHarga * ($diskonPersen / 100);
            $grandTotal = $totalHarga - $potonganNominal;

            // D. Simpan Data Master (Nota) beserta Totalnya
            $penjualan = Penjualan::create([
                'nota'           => $generatedNota,
                'tanggal_nota'   => $request->tanggal_nota,
                'kode_pelanggan' => $validated['kode_pelanggan'],
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

        $successMessage = $isPelanggan 
            ? 'Pesanan berhasil dibuat! Terima kasih atas pembelian Anda.' 
            : 'Nota berhasil disimpan, harga telah dikalkulasi, dan stok obat otomatis dikurangi!';

        return redirect()->route('dashboard.obat.index')
            ->with('success', $successMessage);
    }

    public function update(Request $request, string $nota)
    {
        // Deteksi Role Pelanggan
        $namaRole = session('user_role.nama_role', '');
        $isPelanggan = str_contains(strtolower($namaRole), 'pelanggan');

        // ===== PELANGGAN TIDAK BOLEH EDIT TRANSAKSI =====
        if ($isPelanggan) {
            return redirect()->route('dashboard.penjualan.index')
                ->with('error', 'Anda tidak memiliki akses untuk mengedit transaksi!');
        }

        $request->validate([
            'tanggal_nota'          => 'required|date',
            'kode_pelanggan'        => 'required|string|exists:pelanggans,kode_pelanggan',
            'diskon'                => 'nullable|numeric|min:0|max:100',
            'details'               => 'required|array|min:1',
            'details.*.kode_obat'   => 'required|string|exists:obats,kode_obat',
            'details.*.jumlah'      => 'required|integer|min:1',
        ]);

        DB::transaction(function () use ($request, $nota) {
            $penjualan = Penjualan::with('penjualanDetails')->where('nota', $nota)->firstOrFail();

            // A. KEMBALIKAN (TAMBAH) STOK LAMA DULU
            foreach ($penjualan->penjualanDetails as $oldDetail) {
                Obat::where('kode_obat', $oldDetail->kode_obat)
                    ->increment('stok', $oldDetail->jumlah);
            }

            // B. Hapus riwayat detail lama
            $penjualan->penjualanDetails()->delete();

            // C. Hitung Kalkulasi Baru
            $totalHarga = 0;
            $detailsData = [];

            foreach ($request->details as $detail) {
                $obat = Obat::where('kode_obat', $detail['kode_obat'])->first();
                
                // Validasi stok
                if ($obat->stok < $detail['jumlah']) {
                    throw new \Exception("Stok obat {$obat->nama_obat} tidak mencukupi! Tersedia: {$obat->stok}, Diminta: {$detail['jumlah']}");
                }
                
                $hargaJual = $obat->harga_jual;
                $subtotal = $hargaJual * $detail['jumlah'];
                $totalHarga += $subtotal;

                $detailsData[] = [
                    'kode_obat'  => $detail['kode_obat'],
                    'jumlah'     => $detail['jumlah'],
                    'harga_jual' => $hargaJual,
                    'subtotal'   => $subtotal
                ];
            }

            // Hitung Diskon dan Grand Total
            $diskonPersen = $request->diskon ?? 0;
            $potonganNominal = $totalHarga * ($diskonPersen / 100);
            $grandTotal = $totalHarga - $potonganNominal;

            // D. Update data Master Nota
            $penjualan->update([
                'tanggal_nota'   => $request->tanggal_nota,
                'kode_pelanggan' => $request->kode_pelanggan,
                'diskon'         => $diskonPersen,
                'total_harga'    => $totalHarga,
                'grand_total'    => $grandTotal
            ]);

            // E. Simpan Detail Baru & KURANGI STOK BARU
            foreach ($detailsData as $item) {
                PenjualanDetail::create([
                    'nota'       => $penjualan->nota,
                    'kode_obat'  => $item['kode_obat'],
                    'jumlah'     => $item['jumlah'],
                    'harga_jual' => $item['harga_jual'],
                    'subtotal'   => $item['subtotal']
                ]);
                
                Obat::where('kode_obat', $item['kode_obat'])
                    ->decrement('stok', $item['jumlah']);
            }
        });

        return redirect()->route('dashboard.penjualan.index')
            ->with('success', 'Nota berhasil diperbarui dan stok obat otomatis disesuaikan ulang!');
    }

    public function destroy(string $nota)
    {
        // Deteksi Role Pelanggan
        $namaRole = session('user_role.nama_role', '');
        $isPelanggan = str_contains(strtolower($namaRole), 'pelanggan');

        // ===== PELANGGAN TIDAK BOLEH HAPUS TRANSAKSI =====
        if ($isPelanggan) {
            return redirect()->route('dashboard.penjualan.index')
                ->with('error', 'Anda tidak memiliki akses untuk menghapus transaksi!');
        }

        DB::transaction(function () use ($nota) {
            $penjualan = Penjualan::with('penjualanDetails')->where('nota', $nota)->firstOrFail();
            
            // SEBELUM NOTA DIHAPUS, TAMBAH DULU STOK OBAT YANG TADINYA BERKURANG
            foreach ($penjualan->penjualanDetails as $detail) {
                Obat::where('kode_obat', $detail->kode_obat)
                    ->increment('stok', $detail->jumlah);
            }

            // Hapus Nota (Cascade otomatis menghapus detail)
            $penjualan->delete(); 
        });

        return redirect()->route('dashboard.penjualan.index')
            ->with('success', 'Nota dihapus dan stok obat terkait berhasil ditambahkan kembali.');
    }

    public function report(Request $request)
    {
        // Deteksi Role Pelanggan
        $namaRole = session('user_role.nama_role', '');
        $isPelanggan = str_contains(strtolower($namaRole), 'pelanggan');

        // ===== PELANGGAN TIDAK BOLEH AKSES LAPORAN =====
        if ($isPelanggan) {
            return redirect()->route('dashboard.penjualan.index')
                ->with('error', 'Anda tidak memiliki akses ke halaman laporan!');
        }

        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));
        $queryEndDate = Carbon::parse($endDate)->endOfDay();

        $query = Penjualan::with('pelanggan')
            ->whereBetween('tanggal_nota', [$startDate, $queryEndDate]);

        if ($request->filled('pelanggan')) {
            $query->where('kode_pelanggan', $request->pelanggan);
        }

        // ====== FITUR EXPORT EXCEL (CSV) ======
        if ($request->has('export') && $request->export === 'excel') {
            $dataExport = $query->latest('tanggal_nota')->get();
            $fileName = 'Laporan_Penjualan_' . $startDate . '_sd_' . $endDate . '.csv';

            $headers = array(
                "Content-type"        => "text/csv",
                "Content-Disposition" => "attachment; filename=$fileName",
                "Pragma"              => "no-cache",
                "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
                "Expires"             => "0"
            );

            $columns = array('Tanggal Transaksi', 'No. Nota', 'Kode Pelanggan', 'Nama Pelanggan', 'Harga Kotor', 'Diskon (%)', 'Total Bersih');

            $callback = function() use($dataExport, $columns) {
                $file = fopen('php://output', 'w');
                fputcsv($file, $columns); // Tulis Header Kolom

                foreach ($dataExport as $row) {
                    fputcsv($file, array(
                        Carbon::parse($row->tanggal_nota)->format('Y-m-d H:i:s'),
                        $row->nota,
                        $row->kode_pelanggan,
                        $row->pelanggan->nama_pelanggan ?? 'Umum/Dihapus',
                        $row->total_harga,
                        $row->diskon ?? 0,
                        $row->grand_total
                    ));
                }
                fclose($file);
            };

            return response()->stream($callback, 200, $headers);
        }
        // ====== END FITUR EXPORT ======

        $laporanPenjualan = $query->latest('tanggal_nota')->paginate(15)->withQueryString();

        // Hitung Kalkulasi Ringkasan (Aggregate)
        $summaryQuery = Penjualan::whereBetween('tanggal_nota', [$startDate, $queryEndDate]);
        if ($request->filled('pelanggan')) {
            $summaryQuery->where('kode_pelanggan', $request->pelanggan);
        }

        $totalTransaksi = $summaryQuery->count();
        $totalPendapatanKotor = $summaryQuery->sum('total_harga');
        $totalPendapatanBersih = $summaryQuery->sum('grand_total');
        $totalDiskonDiberikan = $totalPendapatanKotor - $totalPendapatanBersih; 

        $pelanggans = Pelanggan::orderBy('nama_pelanggan', 'asc')->get();

        return view('pages.penjualan.report', compact(
            'laporanPenjualan', 'startDate', 'endDate', 'totalTransaksi', 
            'totalPendapatanKotor', 'totalPendapatanBersih', 'totalDiskonDiberikan', 'pelanggans'
        ));
    }
}