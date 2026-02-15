<?php

namespace Database\Factories;

use App\Models\Obat;
use App\Models\Penjualan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PenjualanDetail>
 */
class PenjualanDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nota' => Penjualan::inRandomOrder()->first()?->nota ?? 'NOT-0000000000000001',
            'kode_obat' => Obat::inRandomOrder()->first()?->kode_obat ?? 'OBT-0000000000000001',
            'jumlah' => fake()->numberBetween(1, 50),
                        'harga_jual' => fake()->numberBetween(10000, 100000),
            'subtotal' => fake()->numberBetween(10000, 100000),
        ];
    }
}
