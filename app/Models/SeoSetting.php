<?php

namespace App\Models;

use App\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SeoSetting extends Model
{
    use HasTranslation; 
    
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'meta_title'       => 'array',
        'meta_description' => 'array',
        'meta_keywords'    => 'array',
    ];

    // Hapus cache spesifik saat Admin mengupdate data
    protected static function booted()
    {
        static::saved(function ($model) {
            Cache::forget("seo_{$model->page}");
        });
    }

    /**
     * Helper untuk mengambil data SEO berdasarkan halaman.
     */
    public static function getByRoute($route)
    {
        return Cache::rememberForever("seo_{$route}", function () use ($route) {
            return self::where('page_route', $route)->first();
        });
    }
}