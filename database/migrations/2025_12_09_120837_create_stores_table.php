<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('stores', function (Blueprint $table) {
            $table->id();
            
            // Identitas Toko
            $table->string('name');
            $table->string('type')->default('retail'); // retail, distributor, service_center
            $table->string('phone')->nullable();
            
            // Lokasi
            $table->text('address');
            $table->string('city');
            $table->string('province')->nullable();
            $table->string('postal_code')->nullable();
            
            // Peta (Opsional tapi penting)
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->text('gmaps_link')->nullable(); // Link "Get Directions"
            
            // Kontrol
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('stores');
    }
};