<?php

namespace App\Http\Requests\Admin\Product;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $product = $this->route('product');

        // Cek: Jika object model, ambil ->id. Jika string, pakai langsung string-nya.
        $productId = is_object($product) ? $product->id : $product;
        
        return [
            // --- 1. General Info ---
            'name' => ['required', 'string', 'max:255'],
            'category_id' => ['required', 'exists:categories,id'],

            'sku' => ['nullable', 'string', 'max:100', 'unique:products,sku,' . $productId],

            // 3. Stock
            'stock' => ['nullable', 'integer', 'min:0'],
            
            // Boolean Checks (Checkbox/Select)
            'is_active' => ['boolean'],
            'is_featured' => ['boolean'],
            'order' => ['nullable', 'integer'],

            'short_description' => ['array'],
            'short_description.en' => ['nullable', 'string'],
            'short_description.id' => ['nullable', 'string'],

            // Description (Multi-language Array)
            'description' => ['nullable', 'array'],
            'description.en' => ['nullable', 'string'],
            'description.id' => ['nullable', 'string'],

            // --- 2. Pricing & Specs ---
            'price' => ['required', 'numeric', 'min:0'],
            'weight' => ['required', 'integer', 'min:0'],
            
            // Discount Logic
            'discount_type' => ['nullable', 'in:fixed,percent'],
            'discount_value' => ['nullable', 'numeric', 'min:0'],
            'discount_start_date' => ['nullable', 'date'],
            // End date harus setelah start date
            'discount_end_date' => ['nullable', 'date', 'after_or_equal:discount_start_date'],

            // --- 3. MEDIA (GAMBAR) ---
            // 'nullable': User tidak wajib upload gambar baru saat edit
            // 'array': Input name="images[]"
            'images' => ['nullable', 'array'], 
            'images.*' => ['image', 'mimes:jpeg,png,jpg,webp', 'max:2048'], // Max 2MB per file

            // Hapus Gambar Lama
            'delete_images' => ['nullable', 'array'],
            'delete_images.*' => ['integer', 'exists:product_images,id'],

            // --- 4. Variants ---
            'has_variants' => ['nullable'],
            'variants' => ['nullable', 'array'],
            
            // PENTING: Validasi ID agar bisa ditangkap
            'variants.*.id' => ['nullable', 'integer', 'exists:product_variants,id'],
            
            'variants.*.name' => ['required_if:has_variants,1', 'nullable', 'string'],
            'variants.*.price' => ['nullable', 'numeric'],
            'variants.*.stock' => ['nullable', 'integer'],
            'variants.*.sku' => ['nullable', 'string'],

            // --- 5. Links & Files ---
            'marketplaces' => ['nullable', 'array'],
            // Validasi link marketplace (harus URL valid)
            'marketplaces.*.id' => ['required_with:marketplaces', 'integer'],
            'marketplaces.*.link' => ['nullable', 'url', 'max:255'],

            'downloads' => ['nullable', 'array'],
            'downloads.*' => ['mimes:pdf', 'max:5120'], // Max 5MB PDF

            'delete_downloads' => ['nullable', 'array'],
            'delete_downloads.*' => ['integer', 'exists:product_downloads,id'],
        ];
    }

    /**
     * Persiapan data sebelum validasi (Opsional)
     * Berguna jika ada checkbox yang tidak mengirim value saat unchecked.
     */
    protected function prepareForValidation()
    {
        $this->merge([
            // Pastikan is_active & is_featured selalu boolean (0/1)
            'is_active' => $this->boolean('is_active'),
            'is_featured' => $this->boolean('is_featured'),
            'has_variants' => $this->has('has_variants'), // Ubah keberadaan key menjadi boolean true
        ]);
    }
}