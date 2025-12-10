<?php

namespace App\Http\Requests\Admin\Career;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCareerRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            // Multi-bahasa
            'title' => ['array'],
            'title.en' => ['required', 'string', 'max:255'],
            'title.id' => ['nullable', 'string', 'max:255'],

            'description' => ['array'],
            'description.en' => ['nullable', 'string'],
            'description.id' => ['nullable', 'string'],

            // Detail
            'location' => ['required', 'string', 'max:100'],
            'type' => ['required', 'string', 'max:50'], // Full-time, Contract
            'salary_range' => ['nullable', 'string', 'max:100'],
            
            // Control
            'closing_date' => ['nullable', 'date'],
            'is_active' => ['boolean'],
            'order' => ['nullable', 'integer'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
        ]);
    }
}