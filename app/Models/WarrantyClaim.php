<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;

class WarrantyClaim extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'purchase_date' => 'date',
        'evidence_photos' => 'array', // Penting agar otomatis jadi array
    ];

    protected static function booted()
    {
        // Hapus cache klaim garansi
        static::saved(fn () => Cache::forget('pending_warranty_count'));
        static::deleted(fn () => Cache::forget('pending_warranty_count'));
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}