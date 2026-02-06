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
        'oldpassword.required'         => 'A jelenlegi jelszavadat kötelező megadni a módosításhoz!',
        'oldpassword.current_password' => 'A megadott jelenlegi jelszó nem egyezik a nálunk tárolttal!',

        // Új jelszó üzenetek
        'newpassword.required'         => 'Kérlek, adj meg egy új jelszót!',
        'newpassword.string'           => 'Az új jelszónak szövegesnek kell lennie!',
        'newpassword.min'              => 'Az új jelszónak legalább 3 karakter hosszúnak kell lennie!',
        'newpassword.confirmed'        => 'Az új jelszó és a megerősítése nem egyezik!',
    ];
}
}