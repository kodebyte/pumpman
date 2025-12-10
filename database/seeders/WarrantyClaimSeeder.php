<?php

namespace Database\Seeders;

use App\Models\WarrantyClaim;
use Illuminate\Database\Seeder;

class WarrantyClaimSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Buat 20 data dummy
        WarrantyClaim::factory()->count(20)->create();
    }
}