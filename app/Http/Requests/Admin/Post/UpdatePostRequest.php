<?php

namespace App\Http\Requests\Admin\Post;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostRequest extends FormRequest
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

            'thumbnail' => ['nullable', 'image', 'max:2048'],
            'post_type_id' => ['required', 'exists:post_types,id'],
            'is_active' => ['boolean'],
            'published_at' => ['nullable', 'date'],
        ];
    }
}
