<?php

namespace Database\Factories;

use App\Models\Obat;
use App\Models\Pembelian;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\PembelianDetail>
 */
class PembelianDetailFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nota' => Pembelian::inRandomOrder()->first()?->nota ?? 'PEM-0000000000000001',
            'kode_obat' => Obat::inRandomOrder()->first()?->kode_obat ?? 'OBT-0000000000000001',
            'jumlah' => fake()->numberBetween(1, 50),
        ];
    }
}
