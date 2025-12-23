<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use App\Models\Category;
use App\Models\Product;
use App\Models\Career;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';
    protected $description = 'Otomatis generate XML sitemap untuk SEO';

    public function handle()
    {
        $sitemap = Sitemap::create();

        // 1. Halaman Statis
        $sitemap->add(Url::create('/')->setPriority(1.0)->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY));
        $sitemap->add(Url::create('/careers')->setPriority(0.8));

        // 2. Dinamis: Kategori
        Category::where('is_active', true)->get()->each(function (Category $category) use ($sitemap) {
            $sitemap->add(Url::create("/categories/{$category->slug}")->setPriority(0.9));
        });

        // 3. Dinamis: Produk
        Product::where('is_active', true)->get()->each(function (Product $product) use ($sitemap) {
            $sitemap->add(Url::create("/products/{$product->slug}")->setPriority(0.8));
        });

        // 4. Dinamis: Karir
        Career::where('is_active', true)->get()->each(function (Career $career) use ($sitemap) {
            $sitemap->add(Url::create("/careers")->setPriority(0.7)); 
            // Karena kita pakai sistem collapse, linknya tetap ke /careers
        });

        $sitemap->writeToFile(public_path('sitemap.xml'));

        $this->info('Sitemap berhasil dibuat di folder public!');
    }
}