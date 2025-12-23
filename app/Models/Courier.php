<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Courier extends Model
{
    use HasFactory;

    /**
     * Atribut yang dapat diisi secara massal.
     */
    protected $fillable = [
        'name',
        'code',
        'tracking_url_format',
        'logo',
        'is_active',
    ];

    /**
     * Casting tipe data native.
     */
    protected $casts = [
        'is_active' => 'boolean',
    ];

    /**
     * Relasi: Satu kurir memiliki banyak pesanan.
     */
    public function orders(): HasMany
    {
        return $this->hasMany(Order::class);
    }

    /**
     * Helper untuk menghasilkan link tracking dinamis.
     * Mengganti placeholder {resi} dengan nomor resi asli.
     *
     * @param string $resi
     * @return string
     */
    public function getTrackingLink(string $resi): string
    {
        // Jika format URL kosong, fallback ke pencarian Google
        if (empty($this->tracking_url_format)) {
            // Gunakan urlencode untuk menangani spasi pada nama kurir
            return 'https://www.google.com/search?q=cek+resi+' . urlencode($this->name) . '+' . $resi;
        }

        // Replace placeholder {resi} dengan nomor resi aktual
        return str_replace('{resi}', $resi, $this->tracking_url_format);
    }
}