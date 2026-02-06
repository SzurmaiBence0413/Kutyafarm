<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateDogRequest extends FormRequest
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
        // Az 'id' paraméter lekérése a route-ból
        $dogId = $this->route('dog'); // A route paraméterben elvárjuk a kutya ID-t.

       return [
    'breedId'     => 'sometimes|required|integer|exists:breeds,id',
    'dogName'     => 'sometimes|required|string|max:255',
    'userId'      => 'sometimes|required|integer|exists:users,id',
    'dateOfBirth' => 'sometimes|required|date',
    'chipNumber'  => [
        'sometimes',
        'required',
        Rule::unique('dogs', 'chipNumber')->ignore($this->route('dog') ?? $this->route('id')),
    ],
    'gender'      => 'sometimes|required|boolean',
    'colorId'     => 'sometimes|required|integer|exists:colors,id',
    'weight'      => 'sometimes|nullable|numeric',
    'teeth'       => 'sometimes|required|boolean',
];
    }

public function messages()
{
    return [
        // Fajták (breedId)
        'breedId.required'  => 'A fajta megadása kötelező, ha módosítani kívánod.',
        'breedId.integer'   => 'A fajta azonosítója csak szám lehet.',
        'breedId.exists'    => 'A kiválasztott fajta nem szerepel a rendszerben.',

        // Név (dogName)
        'dogName.required'  => 'A kutya nevét nem hagyhatod üresen.',
        'dogName.string'    => 'A névnek szöveges formátumúnak kell lennie.',
        'dogName.max'       => 'A név nem lehet hosszabb 255 karakternél.',

        // Gazdi (userId)
        'userId.required'   => 'A tulajdonos azonosítóját kötelező megadni.',
        'userId.integer'    => 'A tulajdonos azonosítója csak szám lehet.',
        'userId.exists'     => 'A megadott felhasználó nem található.',

        // Születési idő (dateOfBirth)
        'dateOfBirth.required' => 'A születési dátumot meg kell adnod.',
        'dateOfBirth.date'     => 'Kérlek, érvényes dátum formátumot használj.',

        // Chip szám (chipNumber)
        'chipNumber.required' => 'A chip számot kötelező kitölteni.',
        'chipNumber.unique'   => 'Ez a chip szám már foglalt, egy másik kutyához tartozik.',

        // Nem (gender)
        'gender.required'   => 'A kutya nemét kötelező megadni.',
        'gender.boolean'    => 'A nem mező értéke érvénytelen.',

        // Szín (colorId)
        'colorId.required'  => 'A szín megadása kötelező.',
        'colorId.integer'   => 'A szín azonosítója csak szám lehet.',
        'colorId.exists'    => 'A kiválasztott szín nem létezik.',

        // Súly (weight)
        'weight.numeric'    => 'A súlyhoz csak számot írhatsz (pl. 12.5).',

        // Fogazat (teeth)
        'teeth.required'    => 'A fogazat állapotát kötelező megadni.',
        'teeth.boolean'     => 'A fogazat mező értéke érvénytelen.',
    ];
}
}
