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
        Schema::create('couriers', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // Contoh: JNE, J&T, SiCepat
            $table->string('code')->unique(); // jne, jnt, sicepat (untuk identifikasi sistem)
            $table->string('tracking_url_format')->nullable(); // https://track.jne.co.id/{resi}
            $table->string('logo')->nullable(); // Path gambar logo
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('couriers');
    }
};
