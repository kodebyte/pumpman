<?php

namespace App\Http\Requests\Web\Newsletter;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewsletterRequest extends FormRequest
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
            'email' => 'required|email|unique:newsletter_subscribers,email',
        ];
    }

    public function messages(): array
    {
        return [
            'email.unique' => 'You are already subscribed to our newsletter.',
            'email.email' => 'Please enter a valid email address.',
        ];
    }

    protected function getRedirectUrl()
    {
        // Ambil URL sebelumnya dari parent, lalu tempelkan fragment #newsletter
        $url = parent::getRedirectUrl();

        // Cek agar tidak double fragment jika user submit berkali-kali
        return strtok($url, '#') . '#newsletter';
    }
}
