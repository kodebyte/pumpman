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
                    'id' => 'Home - Official Aiwa Indonesia',
                    'en' => 'Home - Official Aiwa Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Pusat belanja elektronik Aiwa resmi. Temukan audio, TV, dan perlengkapan elektronik berkualitas.',
                    'en' => 'Official Aiwa Indonesia electronics store. Discover quality audio, TV, and electronic appliances.',
                ],
            ],

            // 2. FAQ (Route: faqs.index)
            [
                'page'       => 'FAQ / Bantuan',
                'page_route' => 'faqs.index',
                'meta_title' => [
                    'id' => 'Pertanyaan Umum (FAQ) - Aiwa Indonesia',
                    'en' => 'Frequently Asked Questions (FAQ) - Aiwa Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Temukan jawaban atas pertanyaan umum mengenai produk, garansi, dan layanan Aiwa.',
                    'en' => 'Find answers to common questions regarding Aiwa products, warranties, and services.',
                ],
            ],

            // 3. STORE LOCATOR (Route: stores.index)
            [
                'page'       => 'Lokasi Toko',
                'page_route' => 'stores.index',
                'meta_title' => [
                    'id' => 'Lokasi Toko & Distributor - Aiwa Indonesia',
                    'en' => 'Store Locator & Distributors - Aiwa Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Cari toko dan distributor resmi Aiwa terdekat di kota Anda.',
                    'en' => 'Find the nearest official Aiwa stores and distributors in your city.',
                ],
            ],

            // 4. ABOUT US (Route: pages.about)
            [
                'page'       => 'Tentang Kami',
                'page_route' => 'pages.about',
                'meta_title' => [
                    'id' => 'Tentang Kami - Sejarah Aiwa Indonesia',
                    'en' => 'About Us - Aiwa Indonesia History',
                ],
                'meta_description' => [
                    'id' => 'Mengenal lebih dekat sejarah, visi, dan misi Aiwa dalam menghadirkan teknologi audio terbaik.',
                    'en' => 'Get to know the history, vision, and mission of Aiwa in delivering the best audio technology.',
                ],
            ],

            // 5. CONTACT US (Route: pages.contact)
            [
                'page'       => 'Hubungi Kami',
                'page_route' => 'pages.contact',
                'meta_title' => [
                    'id' => 'Hubungi Kami - Layanan Pelanggan Aiwa',
                    'en' => 'Contact Us - Aiwa Customer Service',
                ],
                'meta_description' => [
                    'id' => 'Butuh bantuan? Hubungi layanan pelanggan Aiwa Indonesia melalui email atau WhatsApp.',
                    'en' => 'Need help? Contact Aiwa Indonesia customer service via email or WhatsApp.',
                ],
            ],

            // 6. WARRANTY CHECK (Route: warranty-claim.check)
            [
                'page'       => 'Cek Status Garansi',
                'page_route' => 'warranty-claim.check',
                'meta_title' => [
                    'id' => 'Cek Status Klaim Garansi - Aiwa Service',
                    'en' => 'Check Warranty Claim Status - Aiwa Service',
                ],
                'meta_description' => [
                    'id' => 'Pantau status perbaikan dan klaim garansi produk Aiwa Anda di sini.',
                    'en' => 'Track your Aiwa product repair and warranty claim status here.',
                ],
            ],

            // 7. WARRANTY CLAIM FORM (Route: warranty-claim)
            [
                'page'       => 'Form Klaim Garansi',
                'page_route' => 'warranty-claim', // route name asli (bukan URL)
                'meta_title' => [
                    'id' => 'Formulir Klaim Garansi - Aiwa Indonesia',
                    'en' => 'Warranty Claim Form - Aiwa Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Ajukan klaim garansi produk Aiwa Anda secara online dengan mudah.',
                    'en' => 'Submit your Aiwa product warranty claim online easily.',
                ],
            ],

            // 8. WARRANTY SUCCESS (Route: warranty-claim.success)
            [
                'page'       => 'Klaim Garansi Berhasil',
                'page_route' => 'warranty-claim.success',
                'meta_title' => [
                    'id' => 'Pengajuan Berhasil - Aiwa Service Center',
                    'en' => 'Submission Successful - Aiwa Service Center',
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
                    'id' => 'Keranjang Belanja - Aiwa Store',
                    'en' => 'Shopping Cart - Aiwa Store',
                ],
                'meta_description' => [
                    'id' => 'Lihat daftar produk di keranjang belanja Anda sebelum checkout.',
                    'en' => 'View items in your shopping cart before checkout.',
                ],
            ],

            // 10. CHECKOUT (Route: cart.checkout)
            [
                'page'       => 'Halaman Checkout',
                'page_route' => 'cart.checkout',
                'meta_title' => [
                    'id' => 'Checkout Aman - Aiwa Indonesia',
                    'en' => 'Secure Checkout - Aiwa Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Selesaikan pembayaran pesanan Anda dengan aman dan cepat.',
                    'en' => 'Complete your order payment securely and quickly.',
                ],
            ],

            // 11. CHECKOUT SUCCESS (Route: checkout.success)
            // Halaman "Terima Kasih" setelah order dibuat (tapi belum bayar/midtrans)
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
            // Halaman setelah sukses bayar
            [
                'page'       => 'Pembayaran Berhasil',
                'page_route' => 'payment.success',
                'meta_title' => [
                    'id' => 'Pembayaran Berhasil - Terima Kasih',
                    'en' => 'Payment Successful - Thank You',
                ],
                'meta_description' => [
                    'id' => 'Pembayaran Anda telah dikonfirmasi. Kami akan segera memproses pesanan Anda.',
                    'en' => 'Your payment has been confirmed. We will process your order immediately.',
                ],
            ],

            [
                'page'       => 'Berita & Artikel',
                'page_route' => 'posts.index',
                'meta_title' => [
                    'id' => 'Berita & Artikel - Aiwa Indonesia',
                    'en' => 'News & Article - Aiwa Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Baca berita terbaru, tips teknologi, dan artikel menarik seputar produk elektronik dan gaya hidup dari Aiwa Indonesia.',
                    'en' => 'Read the latest news, tech tips, and interesting articles about electronic products and lifestyle from Aiwa Indonesia.',
                ],
            ],

            // 14. CAREERS (Route: careers)
            [
                'page'       => 'Karir',
                'page_route' => 'careers.index',
                'meta_title' => [
                    'id' => 'Karir - Aiwa Indonesia',
                    'en' => 'Careers - Aiwa Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Bergabunglah dengan tim Aiwa Indonesia. Temukan peluang karir menarik dan kembangkan potensi Anda bersama kami.',
                    'en' => 'Join the Aiwa Indonesia team. Find exciting career opportunities and develop your potential with us.',
                ],
            ],

            // 15. PRODUCT CATALOG (Route: products)
            [
                'page'       => 'Katalog Produk',
                'page_route' => 'products.index',
                'meta_title' => [
                    'id' => 'Katalog Produk Aiwa - Aiwa Indonesia',
                    'en' => 'Aiwa Product Catalog - Aiwa Indonesia',
                ],
                'meta_description' => [
                    'id' => 'Jelajahi koleksi lengkap produk elektronik Aiwa mulai dari audio, TV, hingga peralatan rumah tangga berkualitas tinggi.',
                    'en' => 'Explore the full collection of Aiwa electronic products ranging from high-quality audio, TV, to home appliances.',
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