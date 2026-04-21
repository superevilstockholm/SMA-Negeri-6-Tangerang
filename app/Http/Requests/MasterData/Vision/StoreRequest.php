<?php

namespace App\Http\Requests\MasterData\Vision;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

// Models
use App\Models\MasterData\Vision;

class StoreRequest extends FormRequest
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
        $maxOrder = Vision::count() + 1;

        return [
            'content' => ['required', 'string', Rule::unique(Vision::class, 'content')],
            'order' => ['required', 'integer', 'min:1', 'max:' . $maxOrder],
        ];
    }
}
