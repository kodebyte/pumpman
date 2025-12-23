<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Setting;

class SettingSeeder extends Seeder
{
    public function run(): void
    {
        $settings = [
            // General
            [
                'key' => 'site_name', 
                'value' => 'Aiwa Indonesia', 
                'type' => 'text'
            ],
            [
                'key' => 'site_description', 
                'value' => 'Official Distributor of Aiwa Electronics', 
                'type' => 'textarea'
            ],
            [
                'key' => 'site_logo', 
                'value' => null, 
                'type' => 'image'
            ],
            [
                'key' => 'site_favicon', 
                'value' => null, 
                'type' => 'image'
            ],
            
            // Contact
            [
                'key' => 'contact_company_name', 
                'value' => 'PT. Aiwa Indonesia', 
                'type' => 'text'
            ],
            [
                'key' => 'contact_email', 
                'value' => 'support@aiwa.co.id', 
                'type' => 'text'
            ],
            [
                'key' => 'contact_phone', 
                'value' => '6281234567890', 
                'type' => 'text'
            ],
            [
                'key' => 'contact_address', 
                'value' => 'Jl. Industri Raya No. 1, Jakarta', 
                'type' => 'textarea'
            ],
            [
                'key' => 'contact_business_hours', 
                'value' => 'Senin - Jumat: 09:00 - 17:00 WIB' . PHP_EOL . 'Sabtu - Minggu: Libur', 
                'type' => 'textarea'
            ],
            [
                'key' => 'contact_maps_embed', 
                'value' => '',
                'type' => 'text'
            ], 
            [
                'key' => 'contact_maps_link', 
                'value' => '',
                'type' => 'text'
            ],
            
            // Social Media
            [
                'key' => 'social_facebook', 
                'value' => 'https://facebook.com/aiwa', 
                'type' => 'text'
            ],
            [
                'key' => 'social_instagram', 
                'value' => 'https://instagram.com/aiwa_id', 
                'type' => 'text'
            ],
            [
                'key' => 'social_linkedin', 
                'value' => '', 
                'type' => 'text'
            ],

            [
                'key'   => 'flat_shipping_fee',
                'value' => '50000',
                'type'  => 'text', // Penanda agar nanti di-cast jadi angka
            ],
            [
                'key'   => 'tax_rate',
                'value' => '11', // Simpan angka 11 (artinya 11%)
                'type'  => 'text',
            ],

            // analytics
            [
                'key'   => 'facebook_pixel_id',
                'value' => null, // Biarkan null dulu atau isi ID dummy: '1234567890'
                'type'  => 'text', 
            ],
        ];

        foreach ($settings as $setting) {
            Setting::updateOrCreate(['key' => $setting['key']], $setting);
        }
    }
}