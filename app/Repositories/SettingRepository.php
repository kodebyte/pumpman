<?php

namespace App\Repositories;

use App\Contracts\SettingRepositoryInterface;
use App\Models\Setting;

class SettingRepository implements SettingRepositoryInterface
{
    // Mengambil semua setting dalam format [ 'key' => 'value' ]
    // Agar mudah dipanggil di view: $settings['site_name']
    public function getAllPlucked()
    {
        return Setting::pluck('value', 'key')->toArray();
    }

    public function updateByKey(string $key, $value)
    {
        return Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}