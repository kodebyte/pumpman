<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Faq;

class FaqSeeder extends Seeder
{
    public function run(): void
    {
        // 1. KATEGORI: General Info
        $cat1 = Faq::create([
            'parent_id' => null,
            'title' => [
                'en' => 'General Info',
                'id' => 'Informasi Umum'
            ],
            'order' => 1,
            'is_active' => true
        ]);

        // Pertanyaan untuk General Info
        Faq::create([
            'parent_id' => $cat1->id,
            'title' => [
                'en' => 'Are Aiwa products original?',
                'id' => 'Apakah produk Aiwa yang dijual original?'
            ],
            'answer' => [
                'en' => 'Yes, PT. Aiwa Indonesia Official is the sole authorized distributor. All products are guaranteed 100% original, new, and come with an official warranty valid throughout Indonesia.',
                'id' => 'Ya, PT. Aiwa Indonesia Official adalah distributor resmi tunggal. Semua produk yang kami jual dijamin 100% original, baru, dan dilengkapi dengan garansi resmi yang berlaku di seluruh Indonesia.'
            ],
            'order' => 1
        ]);

        Faq::create([
            'parent_id' => $cat1->id,
            'title' => [
                'en' => 'Where can I buy Aiwa products?',
                'id' => 'Dimana saya bisa membeli produk Aiwa?'
            ],
            'answer' => [
                'en' => 'You can buy online via our Tokopedia and Shopee Mall. For offline experience, visit authorized dealers (Electronic City, Hartono, etc). Check locations in the Find Store menu.',
                'id' => 'Anda dapat membeli secara online melalui Tokopedia dan Shopee Mall kami. Untuk pengalaman langsung, silakan kunjungi jaringan dealer resmi (Electronic City, Hartono, dll). Cek lokasi terdekat di menu Find Store.'
            ],
            'order' => 2
        ]);

        // 2. KATEGORI: Warranty
        $cat2 = Faq::create([
            'parent_id' => null,
            'title' => ['en' => 'Warranty & Service', 'id' => 'Garansi & Servis'],
            'order' => 2,
            'is_active' => true
        ]);

        Faq::create([
            'parent_id' => $cat2->id,
            'title' => [
                'en' => 'How long is the warranty period?',
                'id' => 'Berapa lama masa garansi produk?'
            ],
            'answer' => [
                'en' => 'Standard warranty is 1 Year for Service & Spare parts. For LED TVs, panel warranty can be up to 3 years (depending on model). Please keep your warranty card and purchase receipt.',
                'id' => 'Garansi standar adalah 1 Tahun untuk Jasa & Sparepart. Khusus produk TV LED, garansi panel bisa mencapai 3 tahun (tergantung model). Pastikan Anda menyimpan kartu garansi dan nota pembelian.'
            ],
            'order' => 1
        ]);

        // 3. KATEGORI: Product Usage
        $cat3 = Faq::create([
            'parent_id' => null,
            'title' => ['en' => 'Product Usage', 'id' => 'Penggunaan Produk'],
            'order' => 3,
            'is_active' => true
        ]);

        Faq::create([
            'parent_id' => $cat3->id,
            'title' => [
                'en' => 'How to pair Bluetooth TWS?',
                'id' => 'Cara pairing Bluetooth TWS?'
            ],
            'answer' => [
                'en' => '1. Turn on both speakers.<br>2. Press and hold TWS button on one speaker for 3 seconds until it beeps.<br>3. Search for device name on your phone Bluetooth menu and connect.',
                'id' => '1. Hidupkan kedua speaker.<br>2. Tekan dan tahan tombol TWS pada salah satu speaker selama 3 detik hingga terdengar bunyi "beep".<br>3. Cari nama perangkat di menu Bluetooth HP Anda dan sambungkan.'
            ],
            'order' => 1
        ]);

        // 4. KATEGORI: Partnership
        $cat4 = Faq::create([
            'parent_id' => null,
            'title' => ['en' => 'Partnership', 'id' => 'Kemitraan'],
            'order' => 4,
            'is_active' => true
        ]);
        
        Faq::create([
            'parent_id' => $cat4->id,
            'title' => [
                'en' => 'Requirements to become an official Dealer?',
                'id' => 'Syarat menjadi Dealer resmi?'
            ],
            'answer' => [
                'en' => 'You must have an active physical or online store, Tax ID, and Business License. Please send your company profile via Contact Us page with subject "Sales & Partnership".',
                'id' => 'Anda harus memiliki toko fisik atau online yang aktif, NPWP, dan NIB. Silakan kirim profil perusahaan Anda melalui halaman Contact Us dengan subjek "Sales & Partnership".'
            ],
            'order' => 1
        ]);
    }
}