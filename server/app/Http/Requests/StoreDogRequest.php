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

}
