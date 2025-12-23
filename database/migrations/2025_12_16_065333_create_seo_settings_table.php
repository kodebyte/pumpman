<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('seo_settings', function (Blueprint $table) {
            $table->id();
            $table->string('page');       // Label Admin (e.g. "Halaman Utama")
            $table->string('page_route')->unique(); // System Key (e.g. "home")
            
            // UBAH JADI JSON
            $table->json('meta_title');
            $table->json('meta_description')->nullable();
            $table->json('meta_keywords')->nullable();
            
            // Gambar biasanya sama untuk semua bahasa, jadi biarkan string
            $table->string('og_image')->nullable(); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('seo_settings');
    }
};
