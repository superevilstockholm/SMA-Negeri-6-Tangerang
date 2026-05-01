<?php

namespace App\Http\Requests\Gallery\Video;

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
            'video_file' => ['sometimes', 'nullable', 'file', 'mimetypes:video/mp4', 'max:102400'],
            'group_id' => ['sometimes', 'nullable', 'integer', 'exists:gallery_groups,id'],
        ];
    }
}
