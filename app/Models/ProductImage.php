<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Opsional, jika di migration ada softDeletes()

class ProductImage extends Model
{
    use HasFactory;

    // Gunakan ini jika tabel images memiliki kolom deleted_at
    // use SoftDeletes; 

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'is_primary' => 'boolean',
        'order' => 'integer',
    ];

    // --- RELATIONS ---

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // --- ACCESSORS ---

    /**
     * Helper untuk mendapatkan Full URL gambar.
     * Penggunaan: $image->image_url
     */
    public function getImageUrlAttribute()
    {
        return asset('storage/' . $this->image_path);
    }
}