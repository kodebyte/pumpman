<?php

namespace App\Http\Requests\Web\Warranty;

use Illuminate\Foundation\Http\FormRequest;

class StoreWarrantyClaimRequest extends FormRequest
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
            // Info Pelanggan
            'name' => ['required', 'string', 'max:255'],
            'phone' => ['required', 'string', 'max:20'],
            'email' => ['required', 'email', 'max:255'],
            'address' => ['required', 'string'],

            // Info Produk
            'product_id' => ['required', 'exists:products,id'],
            'serial_number' => ['required', 'string', 'max:255'],
            'purchase_date' => ['required', 'date', 'before_or_equal:today'], // Validasi tambahan agar tgl tidak di masa depan
            'issue' => ['required', 'string'],

            // File Upload
            'invoice' => ['required', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
            'warranty_card' => ['nullable', 'file', 'mimes:jpg,jpeg,png,pdf', 'max:2048'],
        ];
    }

    /**
     * Custom attributes for validator errors.
     */
    public function attributes(): array
    {
        return [
            'product_id' => 'Model Produk',
            'serial_number' => 'Nomor Seri',
            'issue' => 'Detail Kerusakan',
            'invoice' => 'Nota Pembelian',
        ];
    }
}
