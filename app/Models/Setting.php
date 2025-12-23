<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class Setting extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    /**
     * Hapus cache 'global_settings' setiap kali ada perubahan data.
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
    
    /**
     * Helper untuk mengambil value setting.
     * Otomatis melakukan casting tipe data (integer/boolean) & handling Image URL.
     */
    public static function getValue($key, $default = null)
    {
        // 1. Ambil semua data setting (objek lengkap) dan simpan di cache
        // Kita ganti 'pluck' dengan 'all()->keyBy' agar kolom 'type' ikut terambil
        $settings = Cache::remember('global_settings', 60 * 24, function () {
            return self::all()->keyBy('key');
        });

        // 2. Ambil object setting berdasarkan key
        $setting = $settings->get($key);

        // Jika setting tidak ditemukan, kembalikan nilai default
        if (!$setting) {
            return $default;
        }

        $value = $setting->value;

        // 3. Casting Tipe Data (PENTING untuk Pajak & Ongkir)
        // Jika di database type='integer', ubah string "50000" jadi angka 50000
        if ($setting->type === 'integer') {
            return intval($value);
        }
        
        if ($setting->type === 'boolean') {
            return filter_var($value, FILTER_VALIDATE_BOOLEAN);
        }

        // 4. Logic khusus URL Gambar (Fitur lama Anda tetap jalan)
        if ($value && (str_contains($key, 'image') || str_contains($key, 'logo') || str_contains($key, 'favicon'))) {
            return asset('storage/' . $value);
        }

        return $value;
    }
}