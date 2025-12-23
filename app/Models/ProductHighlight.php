<?php

namespace App\Models;

use App\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class ProductHighlight extends Model
{
    use HasTranslation;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'features' => 'array',
        'tagline' => 'array',
        'title' => 'array',
        'description' => 'array',
        'button_text' => 'array',
        'is_active' => 'boolean',
    ];

    public function scopeIsActive(Builder $query)
    {
        return $query->where('is_active', true);
    }
}
