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
     'description' => 'sometimes|nullable|string|max:1000',
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
        'breedId.required'  => 'Breed is required when updating.',
        'breedId.integer'   => 'Breed ID must be an integer.',
        'breedId.exists'    => 'The selected breed does not exist.',

        // Név (dogName)
        'dogName.required'  => 'Dog name is required.',
        'dogName.string'    => 'Dog name must be a string.',
        'dogName.max'       => 'Dog name may not be greater than 255 characters.',

        // Gazdi (userId)
        'userId.required'   => 'Owner is required.',
        'userId.integer'    => 'Owner ID must be an integer.',
        'userId.exists'     => 'The selected owner does not exist.',

        // Születési idő (dateOfBirth)
        'dateOfBirth.required' => 'Date of birth is required.',
        'dateOfBirth.date'     => 'Date of birth must be a valid date.',

        // Chip szám (chipNumber)
        'chipNumber.required' => 'Chip number is required.',
        'chipNumber.unique'   => 'This chip number is already taken.',

        // Nem (gender)
        'gender.required'   => 'Gender is required.',
        'gender.boolean'    => 'Gender must be true or false.',

        // Szín (colorId)
        'colorId.required'  => 'Color is required.',
        'colorId.integer'   => 'Color ID must be an integer.',
        'colorId.exists'    => 'The selected color does not exist.',

        // Súly (weight)
        'weight.numeric'    => 'Weight must be a number.',

        // Fogazat (teeth)
        'teeth.required'    => 'Teeth is required.',
        'teeth.boolean'     => 'Teeth must be true or false.',
    ];
}
}
