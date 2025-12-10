<?php

namespace App\Http\Requests\Admin\Employee;

use Illuminate\Foundation\Http\FormRequest;

class UpdateEmployeeRequest extends FormRequest
{
    public function authorize(): bool 
    {
        return true; 
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            // Ignore validasi unique untuk ID user ini sendiri
            'email' => ['required', 'email', 'unique:employees,email,' . $this->route('employee')], 
            'password' => ['nullable', 'confirmed', 'min:8'],
            'employee_role_id' => ['required', 'exists:employee_roles,id'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}