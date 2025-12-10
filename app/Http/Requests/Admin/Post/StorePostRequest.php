<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
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
            // Multi-bahasa Title
            'title' => ['array'],
            'title.en' => ['required', 'string', 'max:255'],
            'title.id' => ['nullable', 'string', 'max:255'],

            // Multi-bahasa Content (CKEditor Output HTML)
            'content' => ['array'],
            'content.en' => ['nullable', 'string'],
            'content.id' => ['nullable', 'string'],

            'meta_title' => ['array'],
            'meta_title.en' => ['nullable', 'string', 'max:60'], // Google rekomen max 60 chars
            'meta_title.id' => ['nullable', 'string', 'max:60'],

            'meta_description' => ['array'],
            'meta_description.en' => ['nullable', 'string', 'max:160'], // Google rekomen max 160 chars
            'meta_description.id' => ['nullable', 'string', 'max:160'],

            'thumbnail' => ['required', 'image', 'max:2048'],
            'type' => ['required', 'in:news,article,promo'],
            'is_active' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
