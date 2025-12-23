<?php

namespace App\Http\Requests\Admin\Courier;

use Illuminate\Foundation\Http\FormRequest;

class StoreCourierRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Pastikan admin boleh akses
    }

    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            
            // Unique Code: Pastikan tidak ada duplikat
            'code' => ['required', 'string', 'max:50', 'unique:couriers,code'],
            
            // GANTI RULE 'url' MENJADI REGEX INI:
            // Memastikan diawali http/https, tapi boleh mengandung { } untuk placeholder
            'tracking_url_format' => ['nullable', 'string', 'regex:/^https?:\/\/.+/i'], 
            
            'logo' => ['nullable', 'image', 'max:1024'], // Max 1MB
            'is_active' => ['boolean'],
        ];
    }

    public function messages(): array
    {
        return [
            'tracking_url_format.regex' => 'Format URL harus diawali dengan http:// atau https://',
        ];
    }
}