<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslation; // Pastikan Trait ini ada di App/Traits

class Faq extends Model
{
    use HasFactory, SoftDeletes, HasTranslation;

    /**
     * Kolom yang boleh diisi (Mass Assignment).
     */
    protected $guarded = [
        'id'
    ];

    /**
     * Konversi tipe data otomatis.
     */
    protected $casts = [
        'title' => 'array',  // <--- PENTING
        'answer' => 'array',
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /*
    |--------------------------------------------------------------------------
    | Relationships (Self-Referencing)
    |--------------------------------------------------------------------------
    */

    /**
     * Relasi ke Parent (Kategori).
     * Contoh: Pertanyaan "Cara Retur" milik Kategori "Pengiriman".
     */
    public function parent()
    {
        return $this->belongsTo(Faq::class, 'parent_id');
    }

    /**
     * Relasi ke Children (Pertanyaan).
     * Contoh: Kategori "Pengiriman" punya banyak pertanyaan.
     */
    public function children()
    {
        return $this->hasMany(Faq::class, 'parent_id')->orderBy('order', 'asc');
    }

    /*
    |--------------------------------------------------------------------------
    | Scopes (Query Helpers)
    |--------------------------------------------------------------------------
    */

    /**
     * Scope untuk mengambil hanya Kategori (Root).
     * Cara pakai: Faq::categories()->get();
     */
    public function scopeCategories($query)
    {
        return $query->whereNull('parent_id');
    }

    /**
     * Scope untuk mengambil hanya Pertanyaan (Items).
     * Cara pakai: Faq::questions()->get();
     */
    public function scopeQuestions($query)
    {
        return $query->whereNotNull('parent_id');
    }

    /**
     * Scope untuk mengambil yang aktif saja (untuk Frontend).
     * Cara pakai: Faq::active()->get();
     */
    public function scopeActive($query)
    {
        return $query->where('is_active', true);
    }
}