<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Store;

class StoreSeeder extends Seeder
{
    public function run(): void
    {
        Store::create([
            'name' => 'Aiwa Official Store (Grand Indonesia)',
            'type' => 'flagship',
            'phone' => '(021) 2358-0001',
            'address' => 'Grand Indonesia, West Mall Level 3. Jl. M.H. Thamrin No.1',
            'city' => 'Jakarta Pusat',
            'province' => 'DKI Jakarta',
            'latitude' => '-6.1956', // Koordinat GI
            'longitude' => '106.8213',
            'gmaps_link' => 'https://goo.gl/maps/xyz',
            'is_active' => true,
        ]);

        Store::create([
            'name' => 'Electronic City SCBD',
            'type' => 'retail',
            'phone' => '(021) 515-1234',
            'address' => 'SCBD Lot 22, Jl. Jend. Sudirman Kav 52-53',
            'city' => 'Jakarta Selatan',
            'province' => 'DKI Jakarta',
            'latitude' => '-6.2253', // Koordinat SCBD
            'longitude' => '106.8086',
            'gmaps_link' => 'https://goo.gl/maps/abc',
            'is_active' => true,
        ]);
    }
}