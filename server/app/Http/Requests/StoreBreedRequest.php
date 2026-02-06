<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBreedRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /** b
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {

        return [
            'breed' => 'required|string|max:50|unique:breeds,breed',
        ];
    }

public function messages()
{
    return [
        'breed.required' => 'A fajta megadása kötelező.',
        'breed.string'   => 'A fajta csak szöveg lehet.',
        'breed.max'      => 'A fajta legfeljebb 50 karakter hosszú lehet.',
        'breed.unique'   => 'Ez a fajta már létezik az adatbázisban.',
    ];
}


}
