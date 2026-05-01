<?php

namespace App\Http\Requests\Gallery\Video;

use Illuminate\Foundation\Http\FormRequest;

// Models
use App\Models\Gallery\Group;

class IndexRequest extends FormRequest
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
            'limit' => ['sometimes', 'nullable', 'integer', 'min:1', 'max:100'],
            'group_id' => [
                'sometimes',
                'nullable',
                'integer',
                'min:0',
                function ($attribute, $value, $fail) {
                    if ($value != 0 && !Group::where('id', $value)->exists()) {
                        $fail('The selected group is invalid.');
                    }
                },
            ], // If 0, take all videos without groups.
            'start_date' => ['sometimes', 'nullable', 'date'],
            'end_date' => ['sometimes', 'nullable', 'date', 'after_or_equal:start_date'],
        ];
    }
}
