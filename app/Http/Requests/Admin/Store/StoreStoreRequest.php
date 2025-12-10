<?php

namespace App\Http\Requests\Admin\Store;

use Illuminate\Foundation\Http\FormRequest;

class StoreStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Ubah jadi true agar tidak 403 Forbidden
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:255'],
            'type' => ['required', 'in:retail,distributor,service_center'],
            'phone' => ['nullable', 'string', 'max:20'],
            
            // Location
            'address' => ['required', 'string'],
            'city' => ['required', 'string', 'max:100'],
            'province' => ['nullable', 'string', 'max:100'],
            'postal_code' => ['nullable', 'string', 'max:10'],
            
            // Maps
            'latitude' => ['nullable', 'string', 'max:50'],
            'longitude' => ['nullable', 'string', 'max:50'],
            'gmaps_link' => ['nullable', 'url', 'max:500'],
            
            // Control
            'is_active' => ['boolean'],
            'order' => ['nullable', 'integer'],
        ];
    }

    /**
     * Prepare the data for validation.
     * Berguna untuk handling checkbox/select boolean
     */
    protected function prepareForValidation()
    {
        $this->merge([
            'is_active' => $this->boolean('is_active'),
            'order' => $this->input('order', 0), // Default 0 jika kosong
        ]);
    }
}