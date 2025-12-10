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
}