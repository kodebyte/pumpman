<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id();
            
            // Relasi ke tabel post_types
            // Pastikan tabel post_types sudah migrate duluan
            $table->foreignId('post_type_id')->constrained('post_types')->cascadeOnDelete();
            
            $table->foreignId('author_id')->nullable()->constrained('employees')->nullOnDelete();
            
            // Konten Multi-bahasa (JSON)
            $table->json('title');   // {"en": "...", "id": "..."}
            $table->string('slug')->unique(); 
            $table->json('content'); // WYSIWYG Content
            
            // SEO per Post (Optional Override)
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            
            // Meta Data
            $table->string('thumbnail')->nullable();
            
            // HAPUS kolom 'type' lama, ganti dengan relation di atas
            // $table->string('type')->default('news'); 
            
            $table->boolean('is_active')->default(true); // Draft / Published
            $table->timestamp('published_at')->nullable(); // Jadwal tayang

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};