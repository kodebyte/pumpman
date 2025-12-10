<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // 1. Generate Nama Produk yang terlihat Real
        $brand = fake()->randomElement(['AIWA', 'PUMPMAN']);
        
        $electronicTypes = ['Bluetooth Speaker', 'TWS Earbuds', 'LED TV', 'Home Theater', 'Radio Portable'];
        $pumpTypes = ['Submersible Pump', 'Centrifugal Pump', 'Jet Pump', 'Booster Pump', 'Deep Well Pump'];
        
        $type = $brand === 'AIWA' 
            ? fake()->randomElement($electronicTypes) 
            : fake()->randomElement($pumpTypes);
            
        $modelNumber = strtoupper(fake()->bothify('??-###')); // Contoh: XZ-902
        
        $name = "$brand $type Series $modelNumber";
        $slug = Str::slug($name);

        return [
            // Relasi: Buat kategori baru secara otomatis jika dipanggil
            'category_id' => Category::factory(), 

            'name' => $name,
            'slug' => $slug,
            
            'description' => fake()->paragraph(3),
            
            // Harga: Antara 50rb sampai 10 Juta (Kelipatan 5000 biar rapi)
            'price' => fake()->numberBetween(10, 2000) * 5000, 
            
            // Stok
            // 'stock' => fake()->numberBetween(0, 100),
            
            // Berat (gram): 500g s/d 20kg
            'weight' => fake()->numberBetween(500, 20000),
            
            // Status: 80% kemungkinan Aktif
            'is_active' => fake()->boolean(80),
            
            // Gambar (Null dulu, atau gunakan placeholder jika mau)
            // 'image' => null, 
        ];
    }
}