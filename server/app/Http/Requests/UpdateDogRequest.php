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
            'breedId' => 'required|integer|exists:breeds,id',
            'dogName' => 'required|string|max:255',
            'userId' => 'required|integer|exists:users,id',
            'dateOfBirth' => 'required|date',
            'chipNumber' => [
                'required',
                Rule::unique('dogs', 'chipNumber')->ignore($this->route('id')),
            ],
            'gender' => 'required|boolean',
            'colorId' => 'required|integer|exists:colors,id',
            'weight' => 'nullable|numeric',
            'teeth' => 'required|boolean',
        ];
    }
}
