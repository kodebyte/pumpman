<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslation; // Import Trait Multi-bahasa
use Illuminate\Database\Eloquent\Builder;

class Category extends Model
{
    use HasFactory, SoftDeletes, HasTranslation;

    /**
     * Menggunakan Guarded agar lebih fleksibel.
     * Keamanan input ditangani oleh Form Request.
     */
    protected $guarded = ['id'];

    /**
     * Casting tipe data.
     * 'name' => 'array' SANGAT PENTING agar Trait HasTranslation bisa membaca JSON.
     */
    protected $casts = [
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'name' => 'array', // Wajib array karena tipe data di DB adalah JSON
    ];

    // ======================================================================
    // RELATIONSHIPS
    // ======================================================================

    /**
     * Relasi ke Produk (One to Many).
     */
    public function products()
    {
        return $this->hasMany(Product::class);
    }
    
    // ======================================================================
    // ACCESSORS (Opsional)
    // ======================================================================
    
    /**
     * Helper untuk mendapatkan URL gambar lengkap.
     * Penggunaan: $category->image_url
     */
    public function getImageUrlAttribute()
    {
        return $this->image ? asset('storage/' . $this->image) : null;
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function scopeFeatured(Builder $query)
    {
        return $query->where('is_featured', '1');
    }

    public function scopeSortByOrder(Builder $query)
    {
        return $query->orderBy('order', 'asc');
    }
}