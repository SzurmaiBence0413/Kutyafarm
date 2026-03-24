<?php

namespace App\Http\Requests;

use App\Models\User;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateUserRequest extends FormRequest
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
        $id = (int) $this->route('id');

        return [
            'name' => 'sometimes|nullable|string|max:255',
            'email' => [
                'sometimes',
                'nullable',
                'email',
                Rule::unique('users', 'email')->ignore($id),
            ],
            'password' => 'sometimes|nullable|string|min:8',
            'role' => 'sometimes|nullable|integer|in:' . implode(',', [
                User::ROLE_ADMIN,
                User::ROLE_ADOPTER,
            ]),
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'Name must be a string.',
            'name.max' => 'Name may not be greater than 255 characters.',

            'email.email' => 'Please provide a valid email address.',
            'email.unique' => 'This email address is already in use.',

            'password.string' => 'Password must be a string.',
            'password.min' => 'Password must be at least 8 characters.',

            'role.integer' => 'Role must be a number.',
            'role.in' => 'Role must be either 1 (admin) or 2 (adopter).',
        ];
    }
}
