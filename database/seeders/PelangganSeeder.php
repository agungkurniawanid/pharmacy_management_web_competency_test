<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\User;
use Database\Factories\PelangganFactory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PelangganSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // TARGET: Kita ingin membuat total 500 pelanggan.
        $targetTotal = 50;

        // 1. Ambil semua User yang Role-nya Pelanggan 
        // (Misal: id role pelanggan di tabel roles Anda adalah 8. Ubah angka 8 sesuai database Anda!)
        $usersPelanggan = User::where('role_id', 8)->get();

        // 2. Buatkan profil Pelanggan untuk masing-masing User tersebut 
        // agar namanya sinkron/sama persis.
        foreach ($usersPelanggan as $user) {
            Pelanggan::factory()->create([
                'user_id'        => $user->id,
                'nama_pelanggan' => $user->name, // MENGUBAH NAMA FAKE MENJADI NAMA USER!
            ]);
        }

        // 3. Hitung sisa kuota untuk mencapai 500
        $sisa = $targetTotal - $usersPelanggan->count();

        // 4. Generate sisanya sebagai Pelanggan Offline (Tanpa Akun Login / user_id = null)
        if ($sisa > 0) {
            Pelanggan::factory()->count($sisa)->create([
                'user_id' => null,
            ]);
        }
    }
}
