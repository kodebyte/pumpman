<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Builder;

class Client extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    // --- Accessor ---
    public function getLogoUrlAttribute()
    {
        return $this->logo ? asset('storage/' . $this->logo) : asset('assets/images/placeholder.png');
    }

    // --- Scopes ---
    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }

    public function scopeSortByOrder(Builder $query)
    {
        return $query->orderBy('order', 'asc');
    }
}