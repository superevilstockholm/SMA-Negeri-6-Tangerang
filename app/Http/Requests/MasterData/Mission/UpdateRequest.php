<?php

namespace App\Http\Requests\MasterData\Mission;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

// Models
use App\Models\MasterData\Mission;

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
        $maxOrder = Mission::count();

        return [
            'content' => ['required', 'string', Rule::unique(Mission::class, 'content')->ignore($this->mission->id)],
            'order' => ['required', 'integer', 'min:1', 'max:' . $maxOrder],
        ];
    }
}
