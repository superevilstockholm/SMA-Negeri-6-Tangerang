<?php

namespace App\Http\Requests\MasterData\Teacher;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

// Models
use App\Enums\GenderEnum;

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
            'name' => ['required', 'string', 'max:255'],
            'nip' => ['required', 'string', 'size:18', 'unique:teachers,nip'],
            'dob' => ['required', 'date'],
            'gender' => ['required', Rule::enum(GenderEnum::class)],
            'photo_file' => ['sometimes', 'nullable', 'image', 'mimes:png,jpg,jpeg,webp', 'max:2048'],
            'remove_photo' => ['sometimes', 'nullable', 'boolean'],
        ];
    }
}
