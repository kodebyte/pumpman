<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslation;

class Post extends Model
{
    use HasFactory, SoftDeletes, HasTranslation;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'title' => 'array',
        'content' => 'array',
        'is_active' => 'boolean',
        'published_at' => 'datetime',

        'meta_title' => 'array',
        'meta_description' => 'array',
    ];

    // Relasi ke Author (Admin)
    public function author()
    {
        return $this->belongsTo(Employee::class, 'author_id');
    }
}