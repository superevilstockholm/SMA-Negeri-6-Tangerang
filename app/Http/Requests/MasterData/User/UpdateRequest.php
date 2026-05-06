<?php

namespace App\Http\Requests\MasterData\User;

use Illuminate\Validation\Rule;
use Illuminate\Foundation\Http\FormRequest;

// Enums
use App\Enums\RoleEnum;

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
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $this->user->id],
            'password' => ['sometimes', 'nullable', 'string', 'min:8'],
            'role' => ['required', 'string', Rule::enum(RoleEnum::class)],
            'teacher_id' => [
                'nullable',
                Rule::requiredIf(fn () => $this->role === RoleEnum::TEACHER->value),
                Rule::prohibitedIf(fn () => $this->role !== RoleEnum::TEACHER->value),
                Rule::exists('teachers', 'id')->where(function ($query) {
                    $query->whereNull('user_id')
                        ->orWhere('user_id', $this->user->id);
                }),
            ]
        ];
    }
}
