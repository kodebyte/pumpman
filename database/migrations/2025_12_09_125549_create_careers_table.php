<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('careers', function (Blueprint $table) {
            $table->id();
            
            // Info Dasar (Multi-bahasa)
            $table->json('title');       // {"en": "Sales Manager", "id": "Manajer Penjualan"}
            $table->string('slug')->unique();
            $table->json('description'); // WYSIWYG Content
            
            // Detail
            $table->string('location');  // e.g. "Jakarta Utara", "Remote"
            $table->string('type');      // e.g. "Full-time", "Internship"
            $table->string('salary_range')->nullable(); // Opsional: "5jt - 8jt"
            
            // Kontrol
            $table->boolean('is_active')->default(true);
            $table->date('closing_date')->nullable(); // Batas akhir lamaran
            $table->integer('order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('careers');
    }
};