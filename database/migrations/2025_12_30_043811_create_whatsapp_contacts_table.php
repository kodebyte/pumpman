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
        Schema::create('whatsapp_contacts', function (Blueprint $table) {
            $table->id();
            $table->string('title');        // Contoh: Sales Support
            $table->string('subtitle')->nullable(); // Contoh: Order & Price Inquiry
            $table->string('phone');        // Contoh: 6281234567890 (Format 62...)
            $table->string('message')->nullable(); // Pesan default saat klik WA
            
            // Konfigurasi Tampilan
            $table->string('icon')->default('message-circle'); // Nama icon Lucide (ex: shopping-bag, wrench)
            $table->string('color')->default('green'); // Tema warna (ex: green, blue, orange) untuk class CSS
            
            // Sorting & Status
            $table->integer('order')->default(0);
            $table->boolean('is_active')->default(true);
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('whatsapp_contacts');
    }
};