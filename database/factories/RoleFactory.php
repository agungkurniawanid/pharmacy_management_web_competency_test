<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Role>
 */
class RoleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $roles = [
            ['Admin', 'Administrator utama sistem'],
            ['Admin Gudang', 'Mengelola stok obat'],
            ['Admin Kasir', 'Mengelola transaksi penjualan'],
            ['Admin Sistem', 'Mengatur konfigurasi sistem'],
            ['Apoteker', 'Apoteker utama'],
            ['Apoteker Senior', 'Apoteker berpengalaman'],
            ['Apoteker Junior', 'Apoteker pendamping'],
            ['Owner', 'Pemilik apotek'],
            ['Owner Cabang', 'Pemilik cabang apotek'],
            ['Owner Operasional', 'Mengawasi operasional apotek'],
        ];

        static $index = 0;

        $role = $roles[$index % count($roles)];
        $index++;

        return [
            'nama_role' => $role[0],
            'keterangan' => $role[1],
        ];
    }
}
