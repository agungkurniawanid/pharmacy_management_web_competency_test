<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Carbon;

class PelangganController extends Controller
{
    public function index(Request $request)
    {
        $query = Pelanggan::with('user');

        // 1. Fitur Pencarian Real-time
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('kode_pelanggan', 'like', "%{$search}%")
                  ->orWhere('nama_pelanggan', 'like', "%{$search}%")
                  ->orWhere('telpon', 'like', "%{$search}%");
            });
        }

        // 2. Filter Kota
        if ($request->filled('kota')) {
            $query->where('kota', $request->kota);
        }

        // 3. Sorting Dinamis
        switch ($request->get('sort', 'newest')) {
            case 'oldest':
                $query->oldest('created_at');
                break;
            case 'name_asc':
                $query->orderBy('nama_pelanggan', 'asc');
                break;
            case 'name_desc':
                $query->orderBy('nama_pelanggan', 'desc');
                break;
            default: // newest
                $query->latest('created_at');
                break;
        }

        $pelanggans = $query->paginate(10)->withQueryString();

        // Ambil daftar kota unik untuk dropdown filter
        $kotasList = Pelanggan::select('kota')->whereNotNull('kota')->distinct()->orderBy('kota')->pluck('kota');

        // Data untuk Stats Cards
        $totalPelanggan = Pelanggan::count();
        $pelangganBaruBulanIni = Pelanggan::whereMonth('created_at', Carbon::now()->month)
                                          ->whereYear('created_at', Carbon::now()->year)
                                          ->count();
        $totalKota = $kotasList->count();
        
        // (Contoh) Pelanggan yang aktif transaksi = Punya nota penjualan
        $aktifTransaksi = DB::table('penjualans')->distinct('kode_pelanggan')->count('kode_pelanggan');

        return view('pages.pelanggan.index', compact(
            'pelanggans', 'kotasList', 'totalPelanggan', 'pelangganBaruBulanIni', 'totalKota', 'aktifTransaksi'
        ));
    }

    public function store(Request $request)
    {
        // Aturan validasi dasar (Tabel Pelanggan)
        $rules = [
            'nama_pelanggan' => 'required|string|max:50',
            'alamat'         => 'nullable|string',
            'kota'           => 'nullable|string|max:50',
            'telpon'         => 'nullable|string|max:13',
        ];

        // Jika toggle "Buatkan Akun Login" dicentang
        if ($request->has('create_account') && $request->create_account == '1') {
            $rules['email']    = 'required|email|unique:users,email';
            $rules['password'] = 'required|min:6';
        }

        $request->validate($rules);

        DB::transaction(function () use ($request) {
            $userId = null;

            // 1. Jika perlu buat akun login, insert ke tabel Users dulu
            if ($request->has('create_account') && $request->create_account == '1') {
                $user = User::create([
                    'name'     => $request->nama_pelanggan,
                    'email'    => $request->email,
                    'password' => Hash::make($request->password),
                    'role_id'  => 8, // PERHATIAN: Ganti angka 8 dengan ID riil Role "Pelanggan" di DB Anda
                ]);
                $userId = $user->id;
            }

            // 2. Generate Kode Pelanggan (CUST-0001)
            $lastCust = Pelanggan::orderBy('kode_pelanggan', 'desc')->first();
            $nextNum = $lastCust ? ((int) substr($lastCust->kode_pelanggan, 4)) + 1 : 1;
            $kodeCust = 'PEL-' . str_pad($nextNum, 3, '0', STR_PAD_LEFT);

            // 3. Simpan Profil
            Pelanggan::create([
                'kode_pelanggan' => $kodeCust,
                'user_id'        => $userId,
                'nama_pelanggan' => $request->nama_pelanggan,
                'alamat'         => $request->alamat,
                'kota'           => $request->kota,
                'telpon'         => $request->telpon,
            ]);
        });

        return redirect()->route('dashboard.pelanggan.index')
            ->with('success', 'Pelanggan baru berhasil ditambahkan!');
    }

    public function update(Request $request, string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        $request->validate([
            'nama_pelanggan' => 'required|string|max:50',
            'alamat'         => 'nullable|string',
            'kota'           => 'nullable|string|max:50',
            'telpon'         => 'nullable|string|max:13',
        ]);

        DB::transaction(function () use ($request, $pelanggan) {
            // Update tabel Pelanggan
            $pelanggan->update($request->only(['nama_pelanggan', 'alamat', 'kota', 'telpon']));

            // Jika pelanggan punya akun login, sinkronkan nama di tabel users juga
            if ($pelanggan->user_id) {
                User::where('id', $pelanggan->user_id)->update([
                    'name' => $request->nama_pelanggan
                ]);
            }
        });

        return redirect()->route('dashboard.pelanggan.index')
            ->with('success', 'Data pelanggan berhasil diperbarui!');
    }

    public function destroy(string $id)
    {
        $pelanggan = Pelanggan::findOrFail($id);

        DB::transaction(function () use ($pelanggan) {
            $userId = $pelanggan->user_id;

            // Hapus profil pelanggan
            $pelanggan->delete();

            // Opsional: Hapus akun login-nya sekalian jika ada
            if ($userId) {
                User::where('id', $userId)->delete();
            }
        });

        return redirect()->route('dashboard.pelanggan.index')
            ->with('success', 'Data pelanggan berhasil dihapus!');
    }
}