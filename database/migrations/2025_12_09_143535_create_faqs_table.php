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
        Schema::create('faqs', function (Blueprint $table) {
            $table->id();
            
            // Self Reference (Parent ID)
            // Jika null = Kategori. Jika ada isi = Pertanyaan.
            $table->foreignId('parent_id')
                ->nullable()
                ->constrained('faqs')
                ->onDelete('cascade'); // Hapus kategori = hapus semua isinya

            $table->json('title'); // Dulu 'question' atau 'category name', sekarang jadi general 'title'
            $table->json('answer')->nullable(); // Nullable karena Kategori tidak punya jawaban
            
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true); // Ganti is_published jadi is_active biar konsisten
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('faqs');
    }
};