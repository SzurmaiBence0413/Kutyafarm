<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:3',
            'role' => 'prohibited',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'A név megadása kötelező.',
            'name.string' => 'A név csak szöveg lehet.',
            'name.max' => 'A név maximum 255 karakter lehet.',

            'email.required' => 'Az email cím megadása kötelező.',
            'email.email' => 'Az email cím formátuma nem megfelelő.',
            'email.unique' => 'Ez az email cím már használatban van.',

            'password.required' => 'A jelszó megadása kötelező.',
            'password.string' => 'A jelszó formátuma érvénytelen.',
            'password.min' => 'A jelszónak legalább 3 karakterből kell állnia.',

            'role.prohibited' => 'A szerepkört nem lehet megadni regisztrációkor.',
        ];
    }
}
