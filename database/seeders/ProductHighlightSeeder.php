<?php

namespace Database\Seeders;

use App\Models\ProductHighlight;
use Illuminate\Database\Seeder;

class ProductHighlightSeeder extends Seeder
{
    public function run(): void
    {
        ProductHighlight::create([
            // Pastikan Anda mengganti path gambar ini dengan gambar pompa yang sesuai di folder public
            'image' => 'assets/web/images/pump-highlight.jpg', 
            'tagline' => [
                'en' => 'Industrial Grade Reliability', //
                'id' => 'Keandalan Kelas Industri',
            ],
            'title' => [
                'en' => 'Powerful Flow. <br> Maximum Durability.', //
                'id' => 'Aliran Kuat. <br> Daya Tahan Maksimal.',
            ],
            'description' => [
                'en' => 'Ensure stable water pressure for industrial and residential needs with our high-efficiency heavy duty pumps.', //
                'id' => 'Pastikan tekanan air stabil untuk kebutuhan industri dan rumah tangga dengan pompa heavy duty efisiensi tinggi kami.',
            ],
            'button_text' => [
                'en' => 'Explore Pumpman Series', //
                'id' => 'Jelajahi Seri Pumpman',
            ],
            'button_url' => '/products',
            'features' => [
                [
                    'icon' => 'activity', // Icon Lucide untuk performa/tekanan
                    'title' => [
                        'en' => 'High Pressure Output', //
                        'id' => 'Output Tekanan Tinggi',
                    ],
                    'desc' => [
                        'en' => 'Consistent strong water flow suitable for high-rise buildings and industrial use.', //
                        'id' => 'Aliran air kuat yang konsisten, cocok untuk gedung bertingkat dan penggunaan industri.',
                    ],
                ],
                [
                    'icon' => 'zap', // Icon Lucide untuk listrik
                    'title' => [
                        'en' => 'Energy Saving Motor', //
                        'id' => 'Motor Hemat Energi',
                    ],
                    'desc' => [
                        'en' => 'Advanced coil technology that delivers high power with lower electricity consumption.', //
                        'id' => 'Teknologi kumparan canggih yang menghasilkan tenaga besar dengan konsumsi listrik lebih rendah.',
                    ],
                ],
                [
                    'icon' => 'shield-check', // Icon Lucide untuk ketahanan
                    'title' => [
                        'en' => 'Anti-Rust Components', //
                        'id' => 'Komponen Anti Karat',
                    ],
                    'desc' => [
                        'en' => 'Stainless steel impeller and casing designed to resist corrosion and wear.', //
                        'id' => 'Impeller dan casing stainless steel yang dirancang untuk tahan korosi dan keausan.',
                    ],
                ],
                [
                    'icon' => 'volume-1', // Icon Lucide untuk suara pelan (volume-1 atau volume-x)
                    'title' => [
                        'en' => 'Low Noise Operation', //
                        'id' => 'Operasi Suara Halus',
                    ],
                    'desc' => [
                        'en' => 'Precision engineering ensures smooth operation with minimal noise and vibration.', //
                        'id' => 'Teknik presisi memastikan operasi yang halus dengan kebisingan dan getaran minimal.',
                    ],
                ],
            ],
            'is_active' => true,
        ]);
    }
}