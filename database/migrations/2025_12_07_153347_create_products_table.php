<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // 1. Tabel Produk Utama (Induk)
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            
            // Relasi Kategori
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            
            // Informasi Dasar
            $table->string('name');
            $table->string('slug')->unique();
            $table->json('description')->nullable();
            $table->text('short_description')->nullable(); // Deskripsi Singkat (Card)
            
            // Harga & Fisik
            $table->decimal('price', 15, 2)->default(0);   // Harga Dasar
            $table->integer('weight')->default(1000);      // Berat (Gram)
            
            // Logika Diskon (Promo)
            $table->string('discount_type')->nullable();   // 'fixed' atau 'percent'
            $table->decimal('discount_value', 15, 2)->default(0);
            $table->date('discount_start_date')->nullable();
            $table->date('discount_end_date')->nullable();

            // Status & Kontrol
            $table->boolean('is_active')->default(true);   // Tayang/Draft
            $table->boolean('is_featured')->default(false); // Produk Unggulan
            $table->integer('order')->default(0);          // <-- PRIORITAS URUTAN (Request Anda)
            $table->boolean('has_variants')->default(false); // Cek apakah punya varian
            
            $table->softDeletes();
            $table->timestamps();
        });

        // 2. Tabel Varian Produk (SKU)
        // Menyimpan detail seperti Warna, Ukuran, Voltase
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            // Detail Varian
            $table->string('name')->nullable(); // Contoh: "Merah", "XL", "3 Phase"
            $table->string('sku')->unique()->nullable(); // Kode Unik Barang
            
            // Override Harga & Stok
            $table->decimal('price', 15, 2)->nullable(); // Jika null, ikut harga induk
            $table->integer('stock')->default(0);
            
            // Override Fisik & Status
            $table->integer('weight')->nullable(); 
            $table->boolean('is_active')->default(true);

            $table->softDeletes();
            $table->timestamps();
        });

        // 3. Tabel Galeri Foto
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            
            $table->string('image_path');
            $table->boolean('is_primary')->default(false); // Foto Sampul
            $table->integer('order')->default(0);          // Urutan Foto di Galeri
            
            $table->timestamps();
        });

        Schema::create('product_marketplaces', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->foreignId('marketplace_id')->constrained('marketplaces')->onDelete('cascade');
            $table->string('link'); // URL spesifik produk tersebut

            $table->timestamps();
        });

        Schema::create('product_downloads', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
            $table->string('title'); // Label: "User Manual ID", "Datasheet"
            $table->string('file_path'); // Path PDF
            $table->string('type')->default('manual'); // manual, brochure, driver

            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('product_images');
        Schema::dropIfExists('product_marketplaces');
        Schema::dropIfExists('product_downloads');
        Schema::dropIfExists('product_variants');
        Schema::dropIfExists('products');
    }
};