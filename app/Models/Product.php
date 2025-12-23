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

    public $translatable = ['name', 'description', 'short_description'];

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
        'short_description' => 'array', // JSON Multi-bahasa
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
        $primaryImage = $this->images->where('is_primary', true)->first();
    
        if ($primaryImage) {
            // PENTING: asset() membuat URL menjadi absolut (http://...)
            return asset('storage/' . $primaryImage->image_path);
        }

        // Fallback ke gambar pertama jika tidak ada primary
        $firstImage = $this->images->first();
        
        if ($firstImage) {
            return asset('storage/' . $firstImage->image_path);
        }

        return null; 
    }

    /**
     * Hitung Harga Akhir (Setelah dikurangi diskon yang valid).
     * Usage: $product->final_price
     */
    public function getHasDiscountAttribute(): bool
    {
        if (!$this->discount_type || $this->discount_value <= 0) {
            return false;
        }

        $now = Carbon::now();
        
        // Jika tanggal tidak di-set, anggap diskon berlaku selamanya (opsional, tergantung rule bisnis)
        // Disini kita asumsikan tanggal harus valid
        return $this->discount_start_date <= $now && $this->discount_end_date >= $now;
    }

    /**
     * Hitung Harga Akhir (Setelah Diskon)
     */
    public function getMinPriceAttribute()
    {
        // 1. Jika tidak punya varian, kembalikan harga final. 
        // FIX: Tambahkan '?? $this->price' agar jika tidak ada diskon (final_price null), tetap kembali ke harga asli.
        if (!$this->has_variants || $this->variants->isEmpty()) {
            return $this->final_price ?? $this->price; 
        }

        // 2. Jika punya varian, cari harga terendah
        $minVariantPrice = $this->variants
            ->where('is_active', true)
            ->map(function ($variant) {
                // Jika harga varian kosong, gunakan harga induk
                return $variant->price ?? $this->price;
            })
            ->min();

        // Bandingkan mana lebih murah: varian terendah atau harga induk
        // FIX: Tambahkan fallback juga di sini
        return $minVariantPrice ?: ($this->final_price ?? $this->price);
    }

    public function getPriceLabelHtmlAttribute()
    {
        // Helper untuk menampilkan HTML harga yang rapi di Blade
        $price = $this->min_price;
        $formatted = 'Rp ' . number_format($price, 0, ',', '.');

        // Jika punya varian, tambahkan teks "Mulai dari"
        if ($this->has_variants) {
            return '<span class="text-[10px] text-gray-500 font-normal mr-1">Mulai</span> ' . $formatted;
        }

        return $formatted;
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