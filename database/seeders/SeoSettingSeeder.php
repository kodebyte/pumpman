<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SeoSetting;

class SeoSettingSeeder extends Seeder
{
    public function run()
    {
        $data = [
            // 1. HOME (Route: home)
            [
                'page'       => 'Halaman Utama',
                'page_route' => 'home',
                'meta_title' => [
                    'id' => 'Home - Official Pumpman Indonesia',
                    'en' => 'Home - Official Pumpman Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Solusi pompa air terpercaya untuk industri dan rumah tangga. Temukan berbagai jenis pompa berkualitas tinggi dari Pumpman Indonesia.',
                    'en' => 'Trusted water pump solutions for industrial and residential use. Discover high-quality pumps from Pumpman Indonesia.',
                ],
            ],

            // 2. FAQ (Route: faqs.index)
            [
                'page'       => 'FAQ / Bantuan',
                'page_route' => 'faqs.index',
                'meta_title' => [
                    'id' => 'Pertanyaan Umum (FAQ) - Pumpman Indonesia',
                    'en' => 'Frequently Asked Questions (FAQ) - Pumpman Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Temukan jawaban atas pertanyaan umum mengenai spesifikasi pompa, instalasi, garansi, dan layanan Pumpman.',
                    'en' => 'Find answers to common questions regarding pump specifications, installation, warranties, and Pumpman services.',
                ],
            ],

            // 3. STORE LOCATOR (Route: stores.index)
            [
                'page'       => 'Lokasi Toko',
                'page_route' => 'stores.index',
                'meta_title' => [
                    'id' => 'Lokasi Toko & Distributor - Pumpman Indonesia',
                    'en' => 'Store Locator & Distributors - Pumpman Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Cari dealer dan distributor resmi pompa Pumpman terdekat di kota Anda.',
                    'en' => 'Find the nearest official Pumpman dealers and distributors in your city.',
                ],
            ],

            // 4. ABOUT US (Route: pages.about)
            [
                'page'       => 'Tentang Kami',
                'page_route' => 'pages.about',
                'meta_title' => [
                    'id' => 'Tentang Kami - Sejarah Pumpman Indonesia',
                    'en' => 'About Us - Pumpman Indonesia History',
                ],
                'meta_description' => [
                    'id' => 'Mengenal lebih dekat visi dan misi Pumpman dalam menghadirkan solusi teknologi pemompaan air terbaik dan efisien.',
                    'en' => 'Get to know Pumpman\'s vision and mission in delivering the best and efficient water pumping technology solutions.',
                ],
            ],

            // 5. CONTACT US (Route: pages.contact)
            [
                'page'       => 'Hubungi Kami',
                'page_route' => 'pages.contact',
                'meta_title' => [
                    'id' => 'Hubungi Kami - Layanan Pelanggan Pumpman',
                    'en' => 'Contact Us - Pumpman Customer Service',
                ],
                'meta_description' => [
                    'id' => 'Butuh konsultasi spesifikasi pompa? Hubungi engineer dan layanan pelanggan Pumpman Indonesia melalui email atau WhatsApp.',
                    'en' => 'Need pump specification consultation? Contact Pumpman Indonesia engineers and customer service via email or WhatsApp.',
                ],
            ],

            // 6. WARRANTY CHECK (Route: warranty-claim.check)
            [
                'page'       => 'Cek Status Garansi',
                'page_route' => 'warranty-claim.check',
                'meta_title' => [
                    'id' => 'Cek Status Klaim Garansi - Pumpman Service',
                    'en' => 'Check Warranty Claim Status - Pumpman Service',
                ],
                'meta_description' => [
                    'id' => 'Pantau status perbaikan dan klaim garansi produk pompa Pumpman Anda di sini.',
                    'en' => 'Track your Pumpman pump repair and warranty claim status here.',
                ],
            ],

            // 7. WARRANTY CLAIM FORM (Route: warranty-claim)
            [
                'page'       => 'Form Klaim Garansi',
                'page_route' => 'warranty-claim',
                'meta_title' => [
                    'id' => 'Formulir Klaim Garansi - Pumpman Indonesia',
                    'en' => 'Warranty Claim Form - Pumpman Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Ajukan klaim garansi produk pompa Pumpman Anda secara online dengan mudah.',
                    'en' => 'Submit your Pumpman pump warranty claim online easily.',
                ],
            ],

            // 8. WARRANTY SUCCESS (Route: warranty-claim.success)
            [
                'page'       => 'Klaim Garansi Berhasil',
                'page_route' => 'warranty-claim.success',
                'meta_title' => [
                    'id' => 'Pengajuan Berhasil - Pumpman Service Center',
                    'en' => 'Submission Successful - Pumpman Service Center',
                ],
                'meta_description' => [
                    'id' => 'Terima kasih, pengajuan klaim garansi Anda telah kami terima.',
                    'en' => 'Thank you, we have received your warranty claim submission.',
                ],
            ],

            // 9. CART (Route: cart.index)
            [
                'page'       => 'Keranjang Belanja',
                'page_route' => 'cart.index',
                'meta_title' => [
                    'id' => 'Keranjang Belanja - Pumpman Store',
                    'en' => 'Shopping Cart - Pumpman Store',
                ],
                'meta_description' => [
                    'id' => 'Lihat daftar pompa dan sparepart di keranjang belanja Anda sebelum checkout.',
                    'en' => 'View pumps and spare parts in your shopping cart before checkout.',
                ],
            ],

            // 10. CHECKOUT (Route: cart.checkout)
            [
                'page'       => 'Halaman Checkout',
                'page_route' => 'cart.checkout',
                'meta_title' => [
                    'id' => 'Checkout Aman - Pumpman Indonesia',
                    'en' => 'Secure Checkout - Pumpman Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Selesaikan pembayaran pesanan pompa Anda dengan aman dan cepat.',
                    'en' => 'Complete your pump order payment securely and quickly.',
                ],
            ],

            // 11. CHECKOUT SUCCESS (Route: checkout.success)
            [
                'page'       => 'Order Berhasil Dibuat',
                'page_route' => 'checkout.success',
                'meta_title' => [
                    'id' => 'Pesanan Diterima - Segera Lakukan Pembayaran',
                    'en' => 'Order Received - Please Complete Payment',
                ],
                'meta_description' => [
                    'id' => 'Pesanan Anda berhasil dibuat. Silakan selesaikan pembayaran.',
                    'en' => 'Your order has been placed successfully. Please complete the payment.',
                ],
            ],

            // 12. PAYMENT SUCCESS FINAL (Route: payment.success)
            [
                'page'       => 'Pembayaran Berhasil',
                'page_route' => 'payment.success',
                'meta_title' => [
                    'id' => 'Pembayaran Berhasil - Terima Kasih',
                    'en' => 'Payment Successful - Thank You',
                ],
                'meta_description' => [
                    'id' => 'Pembayaran Anda telah dikonfirmasi. Kami akan segera memproses pengiriman unit Anda.',
                    'en' => 'Your payment has been confirmed. We will process your unit shipment immediately.',
                ],
            ],

            // 13. NEWS / POSTS (Route: posts.index)
            [
                'page'       => 'Berita & Artikel',
                'page_route' => 'posts.index',
                'meta_title' => [
                    'id' => 'Berita & Artikel Engineering - Pumpman Indonesia',
                    'en' => 'Engineering News & Articles - Pumpman Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Baca berita terbaru, tips instalasi pompa, studi kasus engineering, dan artikel menarik seputar manajemen air dari Pumpman Indonesia.',
                    'en' => 'Read the latest news, pump installation tips, engineering case studies, and interesting articles about water management from Pumpman Indonesia.',
                ],
            ],

            // 14. CAREERS (Route: careers.index)
            [
                'page'       => 'Karir',
                'page_route' => 'careers.index',
                'meta_title' => [
                    'id' => 'Karir - Pumpman Indonesia',
                    'en' => 'Careers - Pumpman Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Bergabunglah dengan tim Pumpman Indonesia. Temukan peluang karir di bidang teknik dan manajemen bersama kami.',
                    'en' => 'Join the Pumpman Indonesia team. Find career opportunities in engineering and management with us.',
                ],
            ],

            // 15. PRODUCT CATALOG (Route: products.index)
            [
                'page'       => 'Katalog Produk',
                'page_route' => 'products.index',
                'meta_title' => [
                    'id' => 'Katalog Pompa Industri - Pumpman Indonesia',
                    'en' => 'Industrial Pump Catalog - Pumpman Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Jelajahi koleksi lengkap pompa Pumpman mulai dari pompa sentrifugal, submersible, booster, hingga pompa limbah berkualitas tinggi.',
                    'en' => 'Explore the full collection of Pumpman pumps ranging from centrifugal, submersible, booster, to high-quality sewage pumps.',
                ],
            ],
        ];

        foreach ($data as $item) {
            SeoSetting::updateOrCreate(
                ['page_route' => $item['page_route']], 
                $item
            );
        }
    }
}