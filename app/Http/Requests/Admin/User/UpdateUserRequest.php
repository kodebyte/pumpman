<?php

namespace App\Http\Requests\Admin\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        $id = $this->route('user'); 

        return [
            'name' => ['required', 'string', 'max:255'],
            
            'email' => [
                'required', 
                'email', 
                Rule::unique('users', 'email')->ignore($id),
            ],

            'phone' => ['nullable', 'string', 'max:20'],
            'company_name' => ['nullable', 'string', 'max:255'],
            'password' => ['nullable', 'confirmed', 'min:8'],
            'is_active' => ['required', 'boolean'],
        ];
    }
}