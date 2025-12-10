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
            $table->foreignId('author_id')->nullable()->constrained('employees')->nullOnDelete();
            
            // Konten Multi-bahasa (JSON)
            $table->json('title');   // {"en": "...", "id": "..."}
            $table->string('slug')->unique(); // Slug biasanya diambil dari Title EN
            $table->json('content'); // WYSIWYG Content
            $table->json('meta_title')->nullable();
            $table->json('meta_description')->nullable();
            
            // Meta Data
            $table->string('thumbnail')->nullable();
            $table->string('type')->default('news'); // news, article, promo
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