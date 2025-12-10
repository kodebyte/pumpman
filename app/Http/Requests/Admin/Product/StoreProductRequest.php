<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool { 
        return true; 
    }

    public function rules(): array
    {
        return [
            // General
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],
            
            'description' => ['array'],
            'description.en' => ['nullable', 'string'],
            'description.id' => ['nullable', 'string'],

            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],

            // Pricing
            'price' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'integer', 'min:0'],
            'discount_type' => ['nullable', 'in:fixed,percent'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'discount_start_date' => ['nullable', 'date'],
            'discount_end_date' => ['nullable', 'date', 'after_or_equal:discount_start_date'],

            // Media
            'images' => ['nullable', 'array'],
            'images.*' => ['image', 'max:2048'], // Max 2MB per foto

            // Variants
            'has_variants' => ['nullable'], // Checkbox
            'variants' => ['nullable', 'array'],
            'variants.*.name' => ['required_if:has_variants,1', 'nullable', 'string'],
            'variants.*.price' => ['nullable', 'numeric'],
            'variants.*.stock' => ['nullable', 'integer'],
            'variants.*.sku' => ['nullable', 'string'],

            // Links & Files
            'marketplaces' => ['nullable', 'array'],
            'downloads' => ['nullable', 'array'],
            'downloads.*' => ['mimes:pdf', 'max:5120'], // Max 5MB PDF
        ];
    }
}