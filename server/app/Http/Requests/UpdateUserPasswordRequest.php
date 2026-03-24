<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Password;

class UpdateUserPasswordRequest extends FormRequest
{
    public function authorize(): bool
    {
        // Mivel a bejelentkezett user a saját jelszavát módosítja, ez true
        return true; 
    }

 public function rules(): array
{
    return [
        // Csak akkor ellenőrizzük, ha a mező szerepel a kérésben
        'oldpassword' => ['sometimes', 'required', 'current_password'], 
        'newpassword' => ['sometimes', 'required', 'string', Password::min(3), 'confirmed'],
    ];
}

public function messages(): array
{
    return [
        // Régi jelszó üzenetek
        'oldpassword.required'         => 'Current password is required.',
        'oldpassword.current_password' => 'The current password is incorrect.',

        // Új jelszó üzenetek
        'newpassword.required'         => 'New password is required.',
        'newpassword.string'           => 'New password must be a string.',
        'newpassword.min'              => 'New password must be at least 3 characters.',
        'newpassword.confirmed'        => 'New password confirmation does not match.',
    ];
}
}
