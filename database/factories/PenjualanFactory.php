<?php

namespace Database\Factories;

use App\Models\Pelanggan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Penjualan>
 */
class PenjualanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        static $counter = 1;
        return [
            'nota' => 'NOT-' . str_pad($counter++, 16, '0', STR_PAD_LEFT),
            'tanggal_nota' => fake()->dateTimeBetween('-30 days', 'now'),
            'kode_pelanggan' => Pelanggan::inRandomOrder()->first()?->kode_pelanggan ?? 'PEL-0000000000000001',
            'diskon' => fake()->randomFloat(2, 0, 100),
            'total_harga' => fake()->numberBetween(100000, 1000000),
            'grand_total' => fake()->numberBetween(100000, 1000000),
        ];
    }
}
