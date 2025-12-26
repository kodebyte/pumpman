<?php

namespace App\Http\Requests\Web\Cart;

use Illuminate\Foundation\Http\FormRequest;

class CheckoutRequest extends FormRequest
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
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'email'      => 'required|email|max:255',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string',
            'province_id'   => 'required|exists:provinces,id',
            'province_name' => 'required|string', // Hidden input
            'city_id'       => 'required|exists:cities,id', // Ini yang dicari form
            'city_name'     => 'required|string',
            'postal_code'=> 'required|string',
        ];
    }
}
