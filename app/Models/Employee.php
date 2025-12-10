<?php

namespace App\Models;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class Employee extends Authenticatable
{
    use Notifiable, SoftDeletes;

    protected $guard = 'employee';

    protected $guarded = [
        'id'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'password' => 'hashed',
        'is_active' => 'boolean',
    ];

    public function role()
    {
        return $this->belongsTo(EmployeeRole::class, 'employee_role_id');
    }

    // Helper: Cek role berdasarkan 'code'
    public function hasRole(string $roleCode): bool
    {
        return $this->role?->code === $roleCode;
    }
}
