<?php

namespace App\Http\Requests\Admin\Courier;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCourierRequest extends FormRequest
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
            'name' => ['required', 'string', 'max:255'],
            
            // Ignore ID saat ini agar tidak dianggap duplikat diri sendiri
            'code' => ['required', 'string', 'max:50', 'unique:couriers,code,' . $this->route('courier')->id],
            
            // Gunakan regex yang sama
            'tracking_url_format' => ['nullable', 'string', 'regex:/^https?:\/\/.+/i'],
            
            'logo' => ['nullable', 'image', 'max:1024'],
            'is_active' => ['boolean'],
        ];
    }
}
