<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Foundation\Http\FormRequest;

class StoreEmployeeRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:employees,email'],
            'password' => ['required', 'confirmed', 'min:8'],
            'employee_role_id' => ['required', 'exists:employee_roles,id'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}