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
        Schema::create('marketplaces', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Tokopedia, Shopee
            $table->string('slug')->unique();
            $table->string('icon')->nullable(); // Logo (disimpan di storage)
            $table->string('url')->nullable(); // URL Marketplace
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('marketplaces');
    }
};
