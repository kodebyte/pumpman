<?php

namespace App\Http\Requests\Web\Contact;

use App\Rules\Recaptcha;
use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'topic' => 'required|string',
            'message' => 'required|string|min:10',
            'g-recaptcha-response' => ['required', new Recaptcha],
        ];
    }

    public function attributes()
    {
        return [
            'required' => 'Kolom :attribute wajib diisi.',
            'email' => 'Format email tidak valid.',
            'min' => 'Pesan terlalu pendek.',
            'g-recaptcha-response.required' => 'Mohon centang kotak "Saya bukan robot".',
        ];
    }
}
