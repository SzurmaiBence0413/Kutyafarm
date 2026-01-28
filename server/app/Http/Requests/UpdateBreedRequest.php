<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBreedRequest extends FormRequest
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
    { // Az 'id' a route-ból fog jönni, a $this->route('breed') kinyeri a breed id-t.
        $breedId = $this->route('breed'); // A route paraméterben elvárjuk az 'breed' id-t.

        return [
            // Breed validációs szabályok
            'breed' => 'required|string|max:50|unique:breeds,breed,' . $breedId, // Kivéve, ha a jelenlegi rekordról van szó
        ];
    }

    public function messages()
    {
        return [
            'breed.required' => 'A fajtát meg kell adni.',
            'breed.string' => 'A fajta csak szöveget tartalmazhat.',
            'breed.max' => 'A fajta neve nem lehet hosszabb, mint 50 karakter.',
            'breed.unique' => 'Ez a fajta már létezik.',
        ];
    }
}
