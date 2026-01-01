<?php

namespace App\Http\Requests\Admin\PaymentMethod;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentMethodRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'      => 'required|string|max:255',
            'image'     => 'required|image|mimes:png,jpg,jpeg,svg,webp|max:2048', // Wajib upload gambar
            'is_active' => 'boolean',
            'order'     => 'integer|min:0',
        ];
    }
}