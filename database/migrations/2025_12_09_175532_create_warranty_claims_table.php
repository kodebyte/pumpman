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
        Schema::create('warranty_claims', function (Blueprint $table) {
            $table->id();
            $table->string('claim_code')->unique(); // WC-2023001
            
            // Relasi
            $table->foreignId('user_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('product_id')->constrained()->onDelete('cascade');

            // Info Barang
            $table->string('serial_number')->nullable();
            $table->date('purchase_date');
            $table->string('purchase_location')->nullable();
            
            // Info Kerusakan & Bukti
            $table->string('problem_type')->nullable(); // Mati Total, Bocor, dll
            $table->text('description');
            $table->json('evidence_photos')->nullable(); // Array path foto
            
            // Info Kontak & Pengiriman
            $table->string('customer_email');
            $table->string('customer_name');
            $table->string('customer_phone');
            $table->text('shipping_address');
            
            // Admin Status
            $table->enum('status', ['pending', 'approved', 'unit_received', 'repairing', 'rejected', 'completed'])->default('pending');
            $table->text('admin_notes')->nullable();
            $table->string('admin_tracking_number')->nullable(); // Resi kirim balik
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('warranty_claims');
    }
};
