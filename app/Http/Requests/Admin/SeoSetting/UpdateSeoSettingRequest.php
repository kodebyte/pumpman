<?php

namespace App\Http\Requests\Admin\SeoSetting;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSeoSettingRequest extends FormRequest
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
        return [
            // Validasi untuk data JSON multi-bahasa
            'meta_title' => 'required|array',
            'meta_title.en' => 'required|string|max:255',
            'meta_title.id' => 'required|string|max:255',

            'meta_description' => 'nullable|array',
            'meta_description.en' => 'nullable|string|max:500',
            'meta_description.id' => 'nullable|string|max:500',

            'meta_keywords' => 'nullable|array',
            'meta_keywords.en' => 'nullable|string|max:255',
            'meta_keywords.id' => 'nullable|string|max:255',

            // Validasi file gambar OG
            'og_image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}
