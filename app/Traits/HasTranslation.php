<?php

namespace App\Traits;

trait HasTranslation
{
    public function getTranslation(string $field): string
    {
        $locale = app()->getLocale(); // 'en' atau 'id'
        $value = $this->$field;

        if (!is_array($value)) {
            return (string) $value;
        }

        // Cek bahasa aktif -> Inggris -> Indonesia -> Kosong
        return $value[$locale] ?? $value['en'] ?? $value['id'] ?? '';
    }
}