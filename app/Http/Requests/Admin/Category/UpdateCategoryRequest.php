<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        // Ambil ID dari objek model yang dikirim oleh route
        $categoryId = $this->route('category')->id; 

        return [
            'name' => ['array'],
            
            // Gunakan sintaks '->en' untuk validasi kolom JSON
            'name.en' => [
                'required', 
                'string', 
                'max:255', 
                'unique:categories,name->en,' . $categoryId // Abaikan ID saat ini
            ],
            
            'name.id' => [
                'nullable', 
                'string', 
                'max:255', 
                'unique:categories,name->id,' . $categoryId // Abaikan ID saat ini
            ],
            
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_featured' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],
            'order' => ['required', 'integer', 'min:0'],
        ];
    }
}