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
            'medicineName' => 'required|string|max:100|unique:medicines,medicineName',
            'shortName' => 'nullable|string|max:120',
            'badge' => 'nullable|string|max:50',
            'description' => 'nullable|string|max:1000',
            'recommendedAge' => 'nullable|string|max:120',
            'frequency' => 'nullable|string|max:180',
            'sideEffects' => 'nullable|string|max:180',
            'displayOrder' => 'nullable|integer|min:1|max:9999',
        ];
    }

    public function messages(): array
    {
        return [
            'medicineName.required' => 'Medicine name is required.',
            'medicineName.unique' => 'This medicine already exists.',
        ];
    }
}
