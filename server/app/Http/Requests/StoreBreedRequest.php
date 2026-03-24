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
        'breed.required' => 'Breed is required.',
        'breed.string'   => 'Breed must be a string.',
        'breed.max'      => 'Breed may not be greater than 50 characters.',
        'breed.unique'   => 'This breed already exists.',
    ];
}


}
