<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PostTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $types = [
            [
                'slug' => 'news',
                'name' => json_encode(['id' => 'Berita', 'en' => 'News']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'article',
                'name' => json_encode(['id' => 'Artikel', 'en' => 'Article']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'slug' => 'promo',
                'name' => json_encode(['id' => 'Promo', 'en' => 'Promo']),
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ];

        \DB::table('post_types')->insert($types);
    }
}
