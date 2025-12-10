<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    /**
     * Disable mass assignment restriction.
     * Keamanan ditangani oleh Controller/Service.
     */
    protected $guarded = ['id'];

    /**
     * Helper Statis untuk mengambil value berdasarkan key.
     * Sangat berguna di Blade View (Frontend).
     * * Contoh Penggunaan:
     * {{ \App\Models\Setting::getValue('site_name') }}
     * {{ \App\Models\Setting::getValue('site_logo') }} (Otomatis return URL gambar)
     */
    public static function getValue($key, $default = null)
    {
        // Gunakan Cache agar tidak query DB setiap kali dipanggil (Performance Optimization)
        // Cache akan disimpan selama 24 jam (60*24 menit)
        $settings = Cache::remember('global_settings', 60 * 24, function () {
            return self::pluck('value', 'key')->toArray();
        });

        $value = $settings[$key] ?? $default;

        // Jika key mengandung kata 'image' atau 'logo' atau 'favicon', 
        // dan value-nya ada, otomatis kembalikan Full URL Storage
        if ($value && (str_contains($key, 'image') || str_contains($key, 'logo') || str_contains($key, 'favicon'))) {
            return asset('storage/' . $value);
        }

        return $value;
    }

    /**
     * Helper Statis untuk menghapus Cache saat ada update.
     * Panggil ini di SettingService setelah update.
     */
    protected static function booted()
    {
        static::saved(function ($setting) {
            Cache::forget('global_settings');
        });

        static::deleted(function ($setting) {
            Cache::forget('global_settings');
        });
    }
}