<?php

namespace App\Http\Requests\Admin\WhatsappContact;

use Illuminate\Foundation\Http\FormRequest;

class StoreWhatsappContactRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|string|max:255',
            'subtitle' => 'nullable|string|max:255',
            'phone' => 'required|string|max:20', // Bisa tambah regex jika perlu format spesifik
            'message' => 'nullable|string|max:500',
            'icon' => 'required|string|max:50',
            'color' => 'required|string|in:green,blue,orange,red,purple,gray',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'boolean',
        ];
    }
}