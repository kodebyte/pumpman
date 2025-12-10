<?php

namespace App\Http\Requests\Admin\Category;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $id = $this->route('category'); // Ambil ID dari route

        return [
            'name' => ['array'],
            'name.en' => ['required', 'string', 'max:255', 'unique:categories,name,' . $id], // Inggris Wajib
            'name.id' => ['nullable', 'string', 'max:255', 'unique:categories,name,' . $id], // Indo Opsional
            
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:2048'],
            'is_featured' => ['required', 'boolean'],
            'is_active' => ['required', 'boolean'],

            'order' => 'required|integer|min:0',
        ];
    }
}
