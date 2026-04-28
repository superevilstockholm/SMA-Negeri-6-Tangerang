<?php

namespace App\Http\Requests\MasterData\SchoolHistory;

use Illuminate\Foundation\Http\FormRequest;

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
            'title' => ['sometimes', 'nullable', 'string', 'max:255'],
            'decsription' => ['sometimes', 'nullable', 'string'],
            'startYear' => ['sometimes', 'nullable', 'integer'],
            'endYear' => ['sometimes', 'nullable', 'integer', 'gte:start_year'],
            'startOrder' => ['sometimes', 'nullable', 'integer'],
            'endOrder' => ['sometimes', 'nullable', 'integer', 'gte:start_order'],
            'startDate' => ['sometimes', 'nullable', 'date'],
            'endDate' => ['sometimes', 'nullable', 'date', 'after_or_equal:startDate'],
        ];
    }
}
