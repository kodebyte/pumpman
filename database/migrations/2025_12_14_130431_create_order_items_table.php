<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
            
            // Relasi Produk (Nullable jaga-jaga jika produk dihapus di masa depan)
            $table->foreignId('product_id')->nullable()->constrained('products')->onDelete('set null');
            $table->foreignId('variant_id')->nullable()->constrained('product_variants')->onDelete('set null');
            
            // Snapshot Data (Penting!)
            $table->string('product_name'); 
            $table->string('variant_name')->nullable();
            
            $table->integer('qty');
            $table->decimal('price', 15, 2); // Harga satuan saat beli
            $table->decimal('subtotal', 15, 2); // qty * price
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down()
    {
        Schema::dropIfExists('order_items');
    }
};