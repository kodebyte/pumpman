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
    Schema::create('product_highlights', function (Blueprint $table) {
        $table->id();
        $table->string('image');
        $table->json('tagline');      // Translatable
        $table->json('title');        // Translatable
        $table->json('description');  // Translatable
        
        // Kolom sakti kita: berisi array of objects [{icon, title, desc}, ...]
        $table->json('features')->nullable(); 

        $table->json('button_text')->nullable();
        $table->string('button_url')->nullable();
        $table->boolean('is_active')->default(true);
        $table->timestamps();
    });
}

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_highlights');
    }
};
