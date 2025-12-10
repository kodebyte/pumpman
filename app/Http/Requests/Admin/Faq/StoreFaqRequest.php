<?php

namespace App\Http\Requests\Admin\Faq;

use Illuminate\Foundation\Http\FormRequest;

class StoreFaqRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        return [
            'type' => ['required', 'in:category,question'],
            
            // Validasi Title (Array)
            'title' => ['array'],
            'title.en' => ['required', 'string', 'max:255'],
            'title.id' => ['nullable', 'string', 'max:255'],
            
            'parent_id' => ['required_if:type,question', 'nullable', 'exists:faqs,id'],
            
            // Validasi Answer (Array)
            'answer' => ['nullable', 'array'],
            'answer.en' => ['required_if:type,question', 'nullable', 'string'],
            'answer.id' => ['nullable', 'string'],
            
            'order' => ['nullable', 'integer'],
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        // Jika tipe category, pastikan parent_id NULL
        if ($this->type === 'category') {
            $this->merge(['parent_id' => null, 'answer' => null]);
        }

        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'order' => $this->order ?? 0,
        ]);
    }
}