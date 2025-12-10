<?php

namespace App\Contracts;

interface SettingRepositoryInterface
{
    /**
     * Mengambil semua setting dalam format key-value array sederhana.
     * Output contoh: ['site_name' => 'Aiwa', 'contact_email' => 'admin@aiwa.co.id']
     * * @return array
     */
    public function getAllPlucked();

    /**
     * Update atau Create setting berdasarkan key unik.
     * * @param string $key Nama setting (misal: 'site_logo')
     * @param mixed $value Nilai setting (string path gambar atau text)
     * @return \App\Models\Setting
     */
    public function updateByKey(string $key, $value);
}