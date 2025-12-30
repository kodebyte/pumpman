<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class WhatsappContact extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'phone',
        'message',
        'icon',
        'color',
        'order',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Scope untuk mengambil kontak yang aktif dan urut.
     */
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true)
                    ->orderBy('order', 'asc');
    }

    /**
     * Accessor untuk mendapatkan link WA lengkap.
     * Penggunaan: $contact->whatsapp_url
     */
    public function getWhatsappUrlAttribute()
    {
        // Bersihkan nomor hp (hapus spasi, dash, plus)
        $phone = preg_replace('/[^0-9]/', '', $this->phone);
        
        // Encode pesan
        $text = urlencode($this->message ?? 'Halo Pumpman, saya butuh bantuan.');

        return "https://wa.me/{$phone}?text={$text}";
    }
}