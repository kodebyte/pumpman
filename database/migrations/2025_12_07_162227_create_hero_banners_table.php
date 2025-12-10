<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('hero_banners', function (Blueprint $table) {
            $table->id();
            
            // 1. Visual Configuration
            // Menentukan apakah banner ini berupa gambar statis atau video loop
            $table->enum('background_type', ['image', 'video'])->default('image');
            
            // 2. Media Paths
            $table->string('image_desktop'); // Wajib: Sebagai gambar utama atau poster video
            $table->string('image_mobile');  // Wajib: Versi HP agar responsif
            $table->string('video_path')->nullable(); // Wajib diisi JIKA background_type = 'video'
            
            // 3. Text Content (Multi-Language Support via JSON)
            // Contoh isi: {"en": "Big Sale", "id": "Promo Besar"}
            $table->json('tagline')->nullable();  // Eyebrow text kecil di atas judul
            $table->json('title')->nullable();    // Judul Utama
            $table->json('subtitle')->nullable(); // Deskripsi
            $table->json('cta_text')->nullable(); // Teks pada tombol
            
            // 4. Action & Control
            $table->string('target_url'); // Link tujuan saat diklik
            $table->integer('order')->default(0); // Urutan tampil
            $table->boolean('is_active')->default(true); // Switch On/Off manual
            
            // 5. Scheduling (Marketing Automation)
            // Jika null, berarti tayang selamanya / mulai sekarang
            $table->dateTime('start_date')->nullable();
            $table->dateTime('end_date')->nullable();

            // 6. Standard Columns
            $table->softDeletes(); // Agar data aman (Recycle Bin)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('hero_banners');
    }
};