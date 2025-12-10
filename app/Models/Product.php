<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslation;
use Carbon\Carbon;

class Product extends Model
{
    use HasFactory, SoftDeletes, HasTranslation;

    /**
     * Menggunakan Guarded ['id'] agar lebih fleksibel terhadap perubahan kolom,
     * keamanan ditangani oleh Form Request Validation.
     */
    protected $guarded = ['id'];

    /**
     * Casting tipe data otomatis.
     * Penting: 'description' harus 'array' agar Trait HasTranslation bekerja pada kolom JSON.
     */
    protected $casts = [
        'price' => 'decimal:2',
        'weight' => 'integer',
        'discount_value' => 'decimal:2',
        'discount_start_date' => 'date',
        'discount_end_date' => 'date',
        'is_active' => 'boolean',
        'is_featured' => 'boolean',
        'has_variants' => 'boolean',
        'order' => 'integer',
        'description' => 'array', // JSON Multi-bahasa
    ];

    // ======================================================================
    // RELATIONSHIPS
    // ======================================================================

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class)->orderBy('order');
    }

    public function downloads()
    {
        return $this->hasMany(ProductDownload::class);
    }

    public function marketplaces()
    {
        return $this->belongsToMany(Marketplace::class, 'product_marketplaces')
                    ->withPivot('link') // Ambil kolom link dari tabel pivot
                    ->withTimestamps();
    }

    // ======================================================================
    // ACCESSORS & HELPERS
    // ======================================================================

    /**
     * Ambil URL Thumbnail Utama.
     * Prioritas: Gambar dengan is_primary=true -> Gambar urutan pertama -> Null
     */
    public function getThumbnailAttribute()
    {
        $primary = $this->images->where('is_primary', true)->first();
        
        if ($primary) {
            return $primary->image_path;
        }

        // Fallback ke gambar pertama jika tidak ada primary
        $firstImage = $this->images->first();
        return $firstImage ? $firstImage->image_path : null;
    }

    /**
     * Hitung Harga Akhir (Setelah dikurangi diskon yang valid).
     * Usage: $product->final_price
     */
    public function getFinalPriceAttribute()
    {
        $price = $this->price;
        
        // 1. Cek validitas diskon dasar
        if (!$this->discount_type || $this->discount_value <= 0) {
            return $price;
        }

        // 2. Cek Jadwal Promo (Jika diset)
        $now = Carbon::now();
        
        // Jika belum mulai
        if ($this->discount_start_date && $now->lt($this->discount_start_date)) {
            return $price;
        }
        
        // Jika sudah berakhir
        if ($this->discount_end_date && $now->gt($this->discount_end_date)) {
            return $price;
        }

        // 3. Hitung Nominal Diskon
        if ($this->discount_type === 'percent') {
            // Rumus Persen
            $discountAmount = $price * ($this->discount_value / 100);
            return max(0, $price - $discountAmount);
        } elseif ($this->discount_type === 'fixed') {
            // Rumus Potongan Harga Langsung
            return max(0, $price - $this->discount_value);
        }

        return $price;
    }

    /**
     * Cek apakah produk ini sedang diskon aktif.
     * Usage: $product->has_discount (Boolean)
     */
    public function getHasDiscountAttribute()
    {
        return $this->price > $this->final_price;
    }

    /**
     * Ambil Label Diskon untuk tampilan Frontend.
     * Contoh: "-50%" atau "-Rp 50.000"
     */
    public function getDiscountLabelAttribute()
    {
        if (!$this->has_discount) {
            return null;
        }

        if ($this->discount_type == 'percent') {
            return '-' . round($this->discount_value) . '%';
        }
        
        return '-Rp ' . number_format($this->discount_value, 0, ',', '.');
    }
}