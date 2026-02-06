<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreDogRequest extends FormRequest
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
            'breedId' => 'required|integer|exists:breeds,id',  // breedId nem kötelező, ha megadva van, akkor validálja
            'dogName' => 'required|string|max:255',
            'userId' => 'required|integer|exists:users,id',
            'dateOfBirth' => 'required|date',
            'chipNumber' => 'required|string|max:15|unique:dogs,chipNumber',
            'gender' => 'required|boolean',
            'colorId' => 'required|integer|exists:colors,id',
            'weight' => 'nullable|numeric',
            'teeth' => 'required|boolean',
        ];
    }

    public function messages()
{
    return [
        'breedId.required' => 'A fajta megadása kötelező.',
        'breedId.integer'  => 'A fajta azonosítója csak egész szám lehet.',
        'breedId.exists'   => 'A megadott fajta nem létezik.',

        'dogName.required' => 'A kutya nevének megadása kötelező.',
        'dogName.string'   => 'A kutya neve csak szöveg lehet.',
        'dogName.max'      => 'A kutya neve legfeljebb 255 karakter hosszú lehet.',

        'userId.required'  => 'A gazda megadása kötelező.',
        'userId.integer'   => 'A gazda azonosítója csak egész szám lehet.',
        'userId.exists'    => 'A megadott gazda nem létezik.',

        'dateOfBirth.required' => 'A születési dátum megadása kötelező.',
        'dateOfBirth.date'     => 'A születési dátum nem érvényes dátum.',

        'chipNumber.required' => 'A chip szám megadása kötelező.',
        'chipNumber.string'   => 'A chip szám csak szöveg lehet.',
        'chipNumber.max'      => 'A chip szám legfeljebb 15 karakter hosszú lehet.',
        'chipNumber.unique'   => 'Ez a chip szám már szerepel a rendszerben.',

        'gender.required' => 'A nem megadása kötelező.',
        'gender.boolean'  => 'A nem értéke csak igaz vagy hamis lehet.',

        'colorId.required' => 'A szín megadása kötelező.',
        'colorId.integer'  => 'A szín azonosítója csak egész szám lehet.',
        'colorId.exists'   => 'A megadott szín nem létezik.',

        'weight.numeric' => 'A súly csak szám lehet.',

        'teeth.required' => 'A fogazat megadása kötelező.',
        'teeth.boolean'  => 'A fogazat értéke csak igaz vagy hamis lehet.',
    ];
}


}
