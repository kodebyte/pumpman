<?php

namespace App\Http\Requests\Admin\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'image'     => 'nullable|image|mimes:png,jpg,jpeg,svg,webp|max:2048', // Boleh kosong saat update
            'is_active' => 'boolean',
            'order'     => 'integer|min:0',
        ];
    }
}