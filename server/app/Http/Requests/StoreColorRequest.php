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
            'colorName.required' => 'A színnevet meg kell adni.',
            'colorName.string' => 'A szín neve csak szöveges érték lehet.',
            'colorName.max' => 'A szín neve nem lehet hosszabb, mint 50 karakter.',
            'colorName.unique' => 'Ez a szín már létezik.',
        ];
    }
}
