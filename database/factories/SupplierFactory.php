<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Supplier>
 */
class SupplierFactory extends Factory
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
            'kode_supplier' => 'SUP-' . str_pad($counter++, 16, '0', STR_PAD_LEFT),
            'nama_supplier' => fake()->company(),
            'alamat' => fake()->address(),
            'kota' => fake()->city(),
            'telpon' => fake()->numerify('62#########'),
        ];
    }
}
