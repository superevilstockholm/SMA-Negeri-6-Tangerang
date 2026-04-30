<?php

namespace App\Http\Requests\Gallery\Image;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'image_file' => ['sometimes', 'nullable', 'file', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'group_id' => ['sometimes', 'nullable', 'integer', 'exists:gallery_groups,id'],
        ];
    }
}
