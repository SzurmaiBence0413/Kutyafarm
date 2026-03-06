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
                User::ROLE_OWNER,
                User::ROLE_ADOPTER,
            ]),
        ];
    }

    public function messages(): array
    {
        return [
            'name.string' => 'A név csak szöveges formátumú lehet.',
            'name.max' => 'A név nem lehet hosszabb 255 karakternél.',

            'email.email' => 'Kérlek, érvényes e-mail címet adj meg.',
            'email.unique' => 'Ez az e-mail cím már használatban van.',

            'password.string' => 'A jelszó formátuma érvénytelen.',
            'password.min' => 'A jelszónak legalább 8 karakterből kell állnia.',

            'role.integer' => 'A szerepkör csak szám lehet.',
            'role.in' => 'A szerepkör csak 1 (admin), 2 (tulaj) vagy 3 (örökbefogadó) lehet.',
        ];
    }
}
