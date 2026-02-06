<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

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
    return [
        'name'     => 'sometimes|nullable|string|max:255',
        'email'    => 'sometimes|nullable|email|unique:users,email,' . $this->route('user'),
        'password' => 'sometimes|nullable|min:8',
        'role'     => 'sometimes|nullable|string',
    ];
}

public function messages(): array
{
    return [
        // Név
        'name.string'   => 'A név csak szöveges formátumú lehet!',
        'name.max'      => 'A név nem lehet hosszabb 255 karakternél!',

        // E-mail
        'email.email'   => 'Kérlek, érvényes e-mail címet adj meg!',
        'email.unique'  => 'Ez az e-mail cím már használatban van!',

        // Jelszó
        'password.min'  => 'A jelszónak legalább 8 karakterből kell állnia!',

        // Szerepkör (Role)
        'role.string'   => 'A szerepkör formátuma érvénytelen!',
    ];
}
}
