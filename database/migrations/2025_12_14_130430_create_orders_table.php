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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();

            // 1. Relasi User & Identitas Order
            // Jika user dihapus, set null agar history order tetap ada
            $table->foreignId('user_id')->nullable()->constrained('users')->nullOnDelete();
            $table->foreignId('courier_id')->nullable()->constrained('couriers')->nullOnDelete();

            $table->string('order_number')->unique(); // Contoh: ORD-170923-001
            
            // 2. Status Transaksi
            $table->enum('status', ['pending', 'processing', 'completed', 'cancelled'])->default('pending');
            $table->string('tracking_number')->nullable();
            $table->enum('payment_status', ['unpaid', 'paid', 'failed', 'expired'])->default('unpaid');
            $table->string('payment_type')->nullable();
            $table->json('payment_info')->nullable();
            $table->string('snap_token')->nullable(); // Token pembayaran Midtrans

            // 3. Informasi Customer (Snapshot saat checkout)
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('phone');

            // 4. Detail Alamat & Wilayah (Penting untuk Ongkir & History)
            $table->text('address'); // Jalan, No Rumah, RT/RW

            // Relasi ke Provinsi (ID + Nama Snapshot)
            // Menggunakan unsignedInteger karena ID RajaOngkir bukan BigInt auto-increment
            $table->unsignedInteger('province_id')->nullable();
            $table->string('province_name'); // Kita simpan namanya text agar jika API down/berubah, invoice tetap aman

            // Relasi ke Kota (ID + Nama Snapshot)
            $table->unsignedInteger('city_id')->nullable();
            $table->string('city_name');

            // Relasi ke Kecamatan (Opsional / Future Proof)
            $table->unsignedInteger('district_id')->nullable();
            $table->string('district_name')->nullable();

            $table->string('postal_code');

            // 5. Informasi Keuangan (Gunakan Decimal untuk presisi mata uang)
            // Format: (Total Digit, Digit di belakang koma). 
            // 15 digit total, 2 desimal cukup untuk Triliunan Rupiah.
            $table->decimal('total_price', 15, 2)->default(0);
            $table->decimal('shipping_price', 15, 2)->default(0);
            $table->decimal('tax_price', 15, 2)->default(0);

            // 6. Timestamps & Soft Deletes
            $table->timestamps();
            $table->softDeletes(); // Agar order yang dihapus admin tidak hilang permanen (untuk audit)

            // --- DEFINISI FOREIGN KEY ---
            // nullOnDelete: Jika data master provinsi/kota dihapus/reset, 
            // data order tidak ikut terhapus, hanya ID-nya jadi null (Nama snapshot tetap ada).
            $table->foreign('province_id')->references('id')->on('provinces')->nullOnDelete();
            $table->foreign('city_id')->references('id')->on('cities')->nullOnDelete();
            $table->foreign('district_id')->references('id')->on('districts')->nullOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};