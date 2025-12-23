<?php

namespace Database\Seeders;

use App\Models\ProductHighlight;
use Illuminate\Database\Seeder;

class ProductHighlightSeeder extends Seeder
{
    public function run(): void
    {
        ProductHighlight::create([
            'image' => 'assets/web/images/ik.jpg', // Path gambar dari home.blade.php
            'tagline' => [
                'en' => 'Legendary Japanese Engineer', //
                'id' => 'Teknologi Jepang Legendaris',
            ],
            'title' => [
                'en' => 'Instant Cooling. <br> Lifetime Savings.', //
                'id' => 'Dingin Seketika. <br> Hemat Selamanya.',
            ],
            'description' => [
                'en' => 'Experience premium comfort and healthier air for your family, every day.', //
                'id' => 'Rasakan kenyamanan premium dan udara lebih sehat untuk keluarga Anda, setiap hari.',
            ],
            'button_text' => [
                'en' => 'Explore Aiwa Series', //
                'id' => 'Jelajahi Seri Aiwa',
            ],
            'button_url' => '/products',
            'features' => [
                [
                    'icon' => 'wind',
                    'title' => [
                        'en' => 'Turbo Cool Technology', //
                        'id' => 'Teknologi Turbo Cool',
                    ],
                    'desc' => [
                        'en' => 'Cools the room 30% faster in just minutes after activation.', //
                        'id' => 'Mendinginkan ruangan 30% lebih cepat hanya dalam hitungan menit.',
                    ],
                ],
                [
                    'icon' => 'zap',
                    'title' => [
                        'en' => 'Eco-Friendly & Low Watt', //
                        'id' => 'Ramah Lingkungan & Low Watt',
                    ],
                    'desc' => [
                        'en' => 'Maximum energy efficiency that keeps electricity bills low.', //
                        'id' => 'Efisiensi energi maksimal yang menjaga tagihan listrik tetap rendah.',
                    ],
                ],
                [
                    'icon' => 'shield-check',
                    'title' => [
                        'en' => 'Gold Fin Protection', //
                        'id' => 'Perlindungan Gold Fin',
                    ],
                    'desc' => [
                        'en' => 'Anti-corrosion coating on the condenser ensures durability.', //
                        'id' => 'Lapisan anti-korosi pada kondensor memastikan daya tahan lama.',
                    ],
                ],
                [
                    'icon' => 'volume-x',
                    'title' => [
                        'en' => 'Ultra Silent Mode', //
                        'id' => 'Mode Ultra Sunyi',
                    ],
                    'desc' => [
                        'en' => 'Whisper-quiet operation that won\'t disturb your relaxation.', //
                        'id' => 'Operasi sangat tenang yang tidak akan mengganggu istirahat Anda.',
                    ],
                ],
            ],
            'is_active' => true,
        ]);
    }
}