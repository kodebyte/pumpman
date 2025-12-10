<?php

namespace App\Http\Requests\Admin\HeroBanner;

use Illuminate\Foundation\Http\FormRequest;

class StoreHeroBannerRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        return [
            'background_type' => ['required', 'in:image,video'],
            
            // Gambar Desktop & Mobile Wajib (Sebagai fallback video)
            'image_desktop' => ['required', 'image', 'max:2048'], 
            'image_mobile'  => ['required', 'image', 'max:2048'],

            // Video wajib jika tipe video dipilih
            'video' => [
                'nullable',
                'required_if:background_type,video',
                'mimetypes:video/mp4,video/webm',
                'max:20480', // Max 20MB
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