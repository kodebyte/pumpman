<?php

namespace App\Http\Requests\Admin\Warranty;

use Illuminate\Foundation\Http\FormRequest;

class UpdateWarrantyRequest extends FormRequest
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
            'status' => 'required|string',
            'admin_notes' => 'nullable|string',
            'admin_tracking_number' => 'nullable|string',
        ];
    }
}
