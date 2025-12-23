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
        Schema::create('provinces', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary(); // Kita tidak pakai auto-increment, karena ID akan mengikuti RajaOngkir
            $table->string('name');
            $table->timestamps();
        });

        // 2. Tabel Kota/Kabupaten
        Schema::create('cities', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger('province_id');
            // $table->string('type'); // Kabupaten / Kota
            $table->string('name');
            $table->string('postal_code')->nullable();
            $table->timestamps();

            $table->foreign('province_id')->references('id')->on('provinces')->onDelete('cascade');
        });

        // 3. Tabel Kecamatan (Disiapkan untuk masa depan/Akun Pro)
        Schema::create('districts', function (Blueprint $table) {
            $table->unsignedInteger('id')->primary();
            $table->unsignedInteger('city_id');
            $table->string('name');
            $table->timestamps();

            $table->foreign('city_id')->references('id')->on('cities')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('districts');
        Schema::dropIfExists('cities');
        Schema::dropIfExists('provinces');
    }
};
