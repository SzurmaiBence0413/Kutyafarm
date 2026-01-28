<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateColorRequest extends FormRequest
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
        $colorId = $this->route('color'); // A route paraméterben elvárjuk a szín ID-t.

        return [
            // Szín neve validáció
            'colorName' => 'required|string|max:50|unique:colors,colorName,' . $colorId,
        ];
    }


}
