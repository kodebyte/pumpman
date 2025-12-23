<?php

namespace App\Http\Requests\Admin\PostType;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePostTypeRequest extends FormRequest
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
            'slug' => ['required', 'string', 'max:255', 'alpha_dash', 'unique:post_types,slug,' . $this->route('post_type')],
            'name' => ['array', 'required'],
            'name.en' => ['required', 'string', 'max:255'],
            'name.id' => ['required', 'string', 'max:255'],
            'is_active' => ['boolean'],
        ];
    }
}
