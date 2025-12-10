<?php

namespace App\Http\Requests\Admin\NewsletterSubscriber;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateNewsletterSubscriberRequest extends FormRequest
{
    public function authorize(): bool 
    { 
        return true; 
    }

    public function rules(): array
    {
        // Ambil parameter dari route (pastikan nama parameter di route sesuai, misal: 'newsletter_subscriber')
        $id = $this->route('newsletter_subscriber'); 
        
        return [
            'email' => ['required', 'email', Rule::unique('newsletter_subscribers')->ignore($id)],
            'is_active' => ['boolean'],
        ];
    }

    protected function prepareForValidation()
    {
        $this->merge(['is_active' => $this->boolean('is_active')]);
    }
}