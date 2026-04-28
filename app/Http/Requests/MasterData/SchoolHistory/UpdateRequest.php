<?php

namespace App\Http\Requests\MasterData\SchoolHistory;

use Illuminate\Foundation\Http\FormRequest;

// Models
use App\Models\MasterData\SchoolHistory;

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
        $maxOrder = SchoolHistory::count();

        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
            'start_year' => ['required', 'integer'],
            'end_year' => ['sometimes', 'nullable', 'integer', 'gte:start_year'],
            'order' => ['required', 'integer', 'min:1', 'max:' . $maxOrder],
        ];
    }
}
