<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes; // Opsional

class ProductDownload extends Model
{
    use HasFactory;
    
    // Gunakan ini jika tabel product_downloads memiliki kolom deleted_at
    // use SoftDeletes;

    protected $guarded = [
        'id'
    ];

    // --- RELATIONS ---

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // --- ACCESSORS ---

    /**
     * Helper untuk mendapatkan Full URL Download.
     * Penggunaan: $file->download_url
     */
    public function getDownloadUrlAttribute()
    {
        return asset('storage/' . $this->file_path);
    }
}