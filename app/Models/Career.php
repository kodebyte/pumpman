<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\HasTranslation;
use Carbon\Carbon;

class Career extends Model
{
    use HasFactory, SoftDeletes, HasTranslation;

    protected $guarded = [
        'id'
    ];

    protected $casts = [
        'title' => 'array',
        'description' => 'array',
        'is_active' => 'boolean',
        'closing_date' => 'date',
    ];

    // Accessor: Cek apakah lowongan masih buka?
    public function getIsOpenAttribute()
    {
        if (!$this->is_active) return false;
        if ($this->closing_date && Carbon::now()->gt($this->closing_date)) return false;
        
        return true;
    }
}