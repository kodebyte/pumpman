<?php

namespace Database\Factories;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WarrantyClaim>
 */
class WarrantyClaimFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Random Status
        $status = fake()->randomElement(['pending', 'approved', 'unit_received', 'repairing', 'rejected', 'completed']);
        
        // Logika Admin Note & Tracking Number berdasarkan status
        $adminNotes = null;
        $trackingNumber = null;

        if ($status === 'rejected') {
            $adminNotes = 'Mohon maaf, kerusakan disebabkan oleh kesalahan penggunaan (Human Error) sehingga garansi hangus.';
        } elseif ($status === 'completed') {
            $adminNotes = 'Unit sudah diperbaiki dan dikirim kembali.';
            $trackingNumber = 'JNE-' . strtoupper(Str::random(10));
        } elseif ($status === 'repairing') {
            $adminNotes = 'Menunggu sparepart dari pusat.';
        } elseif ($status === 'approved') {
            $adminNotes = 'Silakan kirim unit ke alamat kantor kami.';
        }

        // Ambil User & Product secara acak (Pastikan seeder Product/User sudah jalan duluan)
        $product = Product::inRandomOrder()->first();
        $user = User::inRandomOrder()->first();

        return [
            'claim_code' => 'WC-' . date('Y') . '-' . fake()->unique()->numerify('####'), // Contoh: WC-2025-0042
            
            'user_id' => $user ? $user->id : null,
            'product_id' => $product ? $product->id : Product::factory(), // Fallback create product jika kosong
            
            'serial_number' => strtoupper(Str::random(12)),
            'purchase_date' => fake()->dateTimeBetween('-2 years', '-1 month'),
            'purchase_location' => fake()->randomElement(['Tokopedia Official Store', 'Shopee Mall', 'Toko Elektronik Glodok', 'Lazada', 'Website Resmi']),
            
            'problem_type' => fake()->randomElement(['Mati Total', 'Suara Berisik', 'Bocor/Rembes', 'Fisik Pecah', 'Kabel Putus', 'Lainnya']),
            'description' => fake()->paragraph(2),
            
            // Dummy array foto (pastikan Anda punya gambar placeholder atau biarkan null dulu)
            'evidence_photos' => null, 
            
            'customer_name' => fake()->name(),
            'customer_phone' => fake()->phoneNumber(),
            'shipping_address' => fake()->address(),
            
            'status' => $status,
            'admin_notes' => $adminNotes,
            'admin_tracking_number' => $trackingNumber,
            
            'created_at' => fake()->dateTimeBetween('-6 months', 'now'),
        ];
    }
}