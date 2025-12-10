<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MediaUpload extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    // Helper untuk mendapatkan URL lengkap
    public function getUrlAttribute()
    {
        return asset('storage/' . $this->path);
    }
}