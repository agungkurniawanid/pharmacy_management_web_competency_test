<?php

namespace Database\Factories;

use App\Models\Supplier;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pembelian>
 */
class PembelianFactory extends Factory
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
            'nota' => 'PEM-' . str_pad($counter++, 16, '0', STR_PAD_LEFT),
            'tanggal_nota' => fake()->dateTimeBetween('-30 days', 'now'),
            'kode_supplier' => Supplier::inRandomOrder()->first()?->kode_supplier ?? 'SUP-0000000000000001',
            'diskon' => fake()->randomFloat(2, 0, 100),
        ];
    }
}
