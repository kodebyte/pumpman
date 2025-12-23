<?php

namespace App\Traits;

use Illuminate\Support\Facades\App;

trait HasTranslation
{
    /**
     * Ambil terjemahan berdasarkan locale aplikasi saat ini.
     * Penggunaan: $model->getTranslation('title')
     */
    public function getTranslation($field, $locale = null)
    {
        // 1. Tentukan bahasa (dari parameter atau settingan aplikasi saat ini)
        $locale = $locale ?? App::getLocale(); // 'en' atau 'id'

        // 2. Ambil data mentah dari atribut model
        $translations = $this->$field;

        // 3. Jika null, kembalikan string kosong
        if (!$translations) {
            return '';
        }

        // 4. Jika formatnya sudah array (karena casts di model), langsung pakai
        // Jika masih string JSON, decode dulu
        if (is_string($translations)) {
            $translations = json_decode($translations, true);
        }

        // 5. Ambil teks sesuai bahasa, fallback ke 'en' jika 'id' kosong (atau sebaliknya)
        return $translations[$locale] ?? $translations['en'] ?? $translations['id'] ?? '';
    }
}