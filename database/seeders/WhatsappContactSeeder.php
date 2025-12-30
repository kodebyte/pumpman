<?php

namespace Database\Seeders;

use App\Models\WhatsappContact;
use Illuminate\Database\Seeder;

class WhatsappContactSeeder extends Seeder
{
    public function run(): void
    {
        $contacts = [
            [
                'title' => 'Sales Support',
                'subtitle' => 'Order & Price Inquiry',
                'phone' => '6281234567890',
                'message' => 'Halo Sales Pumpman, saya ingin menanyakan harga produk...',
                'icon' => 'shopping-bag',
                'color' => 'green',
                'order' => 1,
            ],
            [
                'title' => 'Technical Engineer',
                'subtitle' => 'Spec Calculation',
                'phone' => '6281234567891',
                'message' => 'Halo Engineer Pumpman, saya butuh bantuan perhitungan spesifikasi pompa...',
                'icon' => 'wrench',
                'color' => 'blue',
                'order' => 2,
            ],
            [
                'title' => 'After Sales',
                'subtitle' => 'Warranty & Spareparts',
                'phone' => '6281234567892',
                'message' => 'Halo Admin, saya ingin klaim garansi / cari sparepart...',
                'icon' => 'shield-check',
                'color' => 'orange',
                'order' => 3,
            ],
        ];

        foreach ($contacts as $contact) {
            WhatsappContact::create($contact);
        }
    }
}