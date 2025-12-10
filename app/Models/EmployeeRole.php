<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmployeeRole extends Model
{
    use SoftDeletes;
    
    protected $guarded = [
        'id'
    ];

    public function employees()
    {
        return $this->hasMany(Employee::class);
    }
}
