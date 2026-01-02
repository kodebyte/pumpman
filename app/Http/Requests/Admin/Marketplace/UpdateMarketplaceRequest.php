<?php

namespace App\Http\Requests\Admin\Marketplace;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMarketplaceRequest extends FormRequest
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
        $id = $this->route('marketplace');
        
        return [
            'name' => ['required', 'string', 'max:255'],
            'url' => ['nullable', 'string', 'max:255'],
            'icon' => ['nullable', 'image', 'max:1024'],
            'is_active' => ['required', 'boolean'],
            'order' => ['nullable', 'integer', 'min:0'],
        ];
    }
}
