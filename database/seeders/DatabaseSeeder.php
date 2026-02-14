<?php

namespace Database\Seeders;

use App\Models\Pelanggan;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            UserSeeder::class,
            PelangganSeeder::class,
            PenjualanSeeder::class,
            SupplierSeeder::class,
            ObatSeeder::class,
            PembelianSeeder::class,
            PembelianDetailSeeder::class,
            PenjualanDetailSeeder::class,
        ]);

    }
}
