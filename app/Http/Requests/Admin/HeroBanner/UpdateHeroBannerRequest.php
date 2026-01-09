<?php

namespace App\Http\Requests\Admin\HeroBanner;

use Illuminate\Foundation\Http\FormRequest;

class UpdateHeroBannerRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        return [
            'background_type' => ['required', 'in:image,video'],
            
            // Saat update, gambar boleh kosong (pakai yg lama)
            'image_desktop' => ['nullable', 'image', 'max:2048'], 
            'image_mobile'  => ['nullable'],

            'video' => [
                'nullable',
                'mimetypes:video/mp4,video/webm',
                'max:20480',
            ],

            'tagline' => ['nullable', 'array'],
            'title' => ['nullable', 'array'],
            'subtitle' => ['nullable', 'array'],
            'cta_text' => ['nullable', 'array'],
          
            'target_url' => ['required', 'string', 'max:255'],
            'order' => ['integer', 'min:0'],
            'is_active' => ['required', 'boolean'],
            'start_date' => ['nullable', 'date'],
            'end_date' => ['nullable', 'date', 'after:start_date'],
        ];
    }
}