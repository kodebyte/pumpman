<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Http;
use App\Models\Province;
use App\Models\City;

class RegionalSeeder extends Seeder
{
    public function run()
    {
        // Pastikan Anda sudah menaruh RAJAONGKIR_API_KEY di .env
        $apiKey = env('RAJAONGKIR_API_KEY'); 

        if (!$apiKey) {
            $this->command->error('Harap isi RAJAONGKIR_API_KEY di file .env terlebih dahulu!');
            return;
        }

        // 1. Seed Provinsi
        $this->command->info('Mengambil data Provinsi...');
        $responseProv = Http::withHeaders(['key' => $apiKey])->get('https://api.rajaongkir.com/starter/province');
        
        if ($responseProv->successful()) {
            $provinces = $responseProv['rajaongkir']['results'];
            foreach ($provinces as $prov) {
                Province::create([
                    'id' => $prov['province_id'],
                    'name' => $prov['province'],
                ]);
            }
        } else {
            $this->command->error('Gagal mengambil data Provinsi.');
        }

        // 2. Seed Kota
        $this->command->info('Mengambil data Kota...');
        $responseCity = Http::withHeaders(['key' => $apiKey])->get('https://api.rajaongkir.com/starter/city');
        
        if ($responseCity->successful()) {
            $cities = $responseCity['rajaongkir']['results'];
            foreach ($cities as $city) {
                City::create([
                    'id' => $city['city_id'],
                    'province_id' => $city['province_id'],
                    'type' => $city['type'], // Kabupaten/Kota
                    'name' => $city['city_name'],
                    'postal_code' => $city['postal_code'],
                ]);
            }
        } else {
            $this->command->error('Gagal mengambil data Kota.');
        }
        
        $this->command->info('Selesai! Data wilayah berhasil diisi.');
    }
}