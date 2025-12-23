<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslation;

class HeroBanner extends Model
{
    use HasFactory, SoftDeletes, HasTranslation;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'start_date' => 'datetime',
        'end_date' => 'datetime',
        'tagline' => 'array',
        'title' => 'array',
        'subtitle' => 'array',
        'cta_text' => 'array',
    ];

    public function scopeActiveAndScheduled($query)
    {
        $now = now();
        
        return $query->where('is_active', true)
                     ->where(function ($q) use ($now) {
                         $q->whereNull('start_date')
                           ->orWhere('start_date', '<=', $now);
                     })
                     ->where(function ($q) use ($now) {
                         $q->whereNull('end_date')
                           ->orWhere('end_date', '>=', $now);
                     });
    }
}