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
        'colorName.required' => 'A szín megadása kötelező.',
        'colorName.string'   => 'A szín csak szöveg lehet.',
        'colorName.max'      => 'A szín legfeljebb 50 karakter hosszú lehet.',
        'colorName.unique'   => 'Ez a szín már létezik az adatbázisban.',
    ];
}


}
