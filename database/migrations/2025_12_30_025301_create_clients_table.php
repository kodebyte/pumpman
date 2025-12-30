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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Nama Client / Partner
            $table->string('logo')->nullable(); // Path Logo
            $table->string('url')->nullable(); // Link ke website client (opsional)
            $table->boolean('is_active')->default(true);
            $table->integer('order')->default(0); // Untuk urutan tampilan
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
