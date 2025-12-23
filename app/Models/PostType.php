<?php

namespace App\Models;

use App\Traits\HasTranslation;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class PostType extends Model
{
    use SoftDeletes, HasTranslation; // Gunakan trait custom Anda
    
    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'name' => 'array'
    ];

    public function posts()
    {
        return $this->hasMany(Post::class);
    }

    public function scopeActive(Builder $query)
    {
        return $query->where('is_active', true);
    }
}
