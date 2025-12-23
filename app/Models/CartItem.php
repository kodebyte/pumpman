<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $guarded = [
        'id'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Relasi ke Varian
    public function variant()
    {
        return $this->belongsTo(ProductVariant::class);
    }
    
    // Hitung subtotal item ini (Harga x Qty)
    public function getSubtotalAttribute()
    {
        $price = $this->variant ? $this->variant->price : ($this->product->final_price ?? $this->product->price);
        return $price * $this->qty;
    }
}
