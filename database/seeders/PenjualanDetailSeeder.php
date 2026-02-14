<?php

namespace Database\Seeders;

use App\Models\PenjualanDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PenjualanDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        PenjualanDetail::factory(1500)->create();
    }
}
