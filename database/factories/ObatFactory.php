<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Obat>
 */
class ObatFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 1;
        $hargaBeli = fake()->numberBetween(5000, 50000);
        $hargaJual = $hargaBeli + fake()->numberBetween(5000, 20000);
        
        return [
            'kode_obat' => 'OBT-' . str_pad($counter++, 16, '0', STR_PAD_LEFT),
            'nama_obat' => fake()->word() . ' ' . fake()->randomElement(['500mg', '250mg', '1000mg', '5ml', '10ml']),
            'jenis' => fake()->randomElement(['Antibiotik', 'Vitamin', 'Analgesik', 'Antihistamin', 'Antasida', 'Obat Batuk', 'Imunostimulan']),
            'satuan' => fake()->randomElement(['Tablet', 'Kapsel', 'ml', 'Botol', 'Strip']),
            'harga_beli' => $hargaBeli,
            'harga_jual' => $hargaJual,
            'stok' => fake()->numberBetween(10, 100),
            'kode_supplier' => Supplier::inRandomOrder()->first()?->kode_supplier ?? 'SUP-0000000000000001',
            'tgl_kadaluarsa' => fake()->dateTimeBetween('+1 month', '+2 years')->format('Y-m-d'),
            'status' => fake()->randomElement(['Aktif', 'Nonaktif', 'Ditarik']),
        ];
    }
}
