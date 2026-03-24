<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreColorRequest extends FormRequest
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
            'colorName' => 'required|string|max:50|unique:colors,colorName',
        ];
    }
        
public function messages()
{
    return [
        'colorName.required' => 'Color is required.',
        'colorName.string'   => 'Color must be a string.',
        'colorName.max'      => 'Color may not be greater than 50 characters.',
        'colorName.unique'   => 'This color already exists.',
    ];
}


}
