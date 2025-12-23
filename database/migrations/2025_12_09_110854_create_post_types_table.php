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
        Schema::create('post_types', function (Blueprint $table) {
            $table->id();
            
            // Slug untuk system/url (cth: 'news', 'promo')
            $table->string('slug')->unique(); 
            
            // Nama tipe yang bisa diterjemahkan (cth: {"id": "Berita", "en": "News"})
            $table->json('name'); 
            
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('post_types');
    }
};
