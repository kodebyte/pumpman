<?php

namespace App\Services;

use App\Contracts\SettingRepositoryInterface;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\UploadedFile;

class SettingService
{
    public function __construct(
        protected SettingRepositoryInterface $settingRepo
    ) {}

    public function update(array $data)
    {
        return DB::transaction(function () use ($data) {
            foreach ($data as $key => $value) {
                // 1. Handle Image Upload
                if ($value instanceof UploadedFile) {
                    // Hapus gambar lama jika perlu (disini kita skip logic hapus lama biar simple, atau bisa ambil data lama dulu)
                    $path = $value->store('settings', 'public');
                    $this->settingRepo->updateByKey($key, $path);
                } 
                // 2. Handle Text (Abaikan null value jika itu file input yang kosong)
                elseif (is_string($value) || is_numeric($value) || is_null($value)) {
                    $this->settingRepo->updateByKey($key, $value);
                }
            }
        });
    }
}