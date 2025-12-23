<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Province extends Model
{
    public $incrementing = false; // Karena ID kita set manual
    
    protected $guarded = [
        'id'
    ];

    public function cities()
    {
        return $this->hasMany(City::class);
    }
}