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
            'description' => 'nullable|string|max:1000',
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
        'breedId.required' => 'Breed is required.',
        'breedId.integer'  => 'Breed ID must be an integer.',
        'breedId.exists'   => 'The selected breed does not exist.',

        'dogName.required' => 'Dog name is required.',
        'dogName.string'   => 'Dog name must be a string.',
        'dogName.max'      => 'Dog name may not be greater than 255 characters.',

        'description.string' => 'Description must be a string.',
        'description.max'    => 'Description may not be greater than 1000 characters.',

        'userId.required'  => 'Owner is required.',
        'userId.integer'   => 'Owner ID must be an integer.',
        'userId.exists'    => 'The selected owner does not exist.',

        'dateOfBirth.required' => 'Date of birth is required.',
        'dateOfBirth.date'     => 'Date of birth must be a valid date.',

        'chipNumber.required' => 'Chip number is required.',
        'chipNumber.string'   => 'Chip number must be a string.',
        'chipNumber.max'      => 'Chip number may not be greater than 15 characters.',
        'chipNumber.unique'   => 'This chip number is already taken.',

        'gender.required' => 'Gender is required.',
        'gender.boolean'  => 'Gender must be true or false.',

        'colorId.required' => 'Color is required.',
        'colorId.integer'  => 'Color ID must be an integer.',
        'colorId.exists'   => 'The selected color does not exist.',

        'weight.numeric' => 'Weight must be a number.',

        'teeth.required' => 'Teeth is required.',
        'teeth.boolean'  => 'Teeth must be true or false.',
    ];
}


}
