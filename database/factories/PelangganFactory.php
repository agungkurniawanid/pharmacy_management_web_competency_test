<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pelanggan>
 */
class PelangganFactory extends Factory
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
            'kode_pelanggan' => 'PEL-' . str_pad($counter++, 16, '0', STR_PAD_LEFT),
            'user_id'        => null, 
            'nama_pelanggan' => fake()->name(),
            'alamat'         => fake()->address(),
            'kota'           => fake()->city(),
            'telpon'         => fake()->numerify('628#########'),
        ];
    }
}
