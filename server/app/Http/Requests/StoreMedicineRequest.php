<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMedicineRequest extends FormRequest
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
            'medicineName' => 'required|string|max:100|unique:medicines,medicineName', // A gyógyszer neve kötelező, max 100 karakter, és egyedi
        ];
    }

    public function messages()
{
    return [
        'medicineName.required' => 'A gyógyszer nevének megadása kötelező.',
        'medicineName.string'   => 'A gyógyszer neve csak szöveg lehet.',
        'medicineName.max'      => 'A gyógyszer neve legfeljebb 100 karakter hosszú lehet.',
        'medicineName.unique'   => 'Ez a gyógyszer már szerepel a rendszerben.',
    ];
}

}
