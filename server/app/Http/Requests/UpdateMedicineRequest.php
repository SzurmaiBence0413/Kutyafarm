<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMedicineRequest extends FormRequest
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
        $medicineId = $this->route('id') ?? $this->route('medicine');

        return [
            'medicineName' => 'sometimes|required|string|max:100|unique:medicines,medicineName,' . $medicineId,
            'shortName' => 'sometimes|nullable|string|max:120',
            'badge' => 'sometimes|nullable|string|max:50',
            'description' => 'sometimes|nullable|string|max:1000',
            'recommendedAge' => 'sometimes|nullable|string|max:120',
            'frequency' => 'sometimes|nullable|string|max:180',
            'sideEffects' => 'sometimes|nullable|string|max:180',
            'displayOrder' => 'sometimes|nullable|integer|min:1|max:9999',
        ];
    }

    public function messages(): array
    {
        return [
            'medicineName.required' => 'Medicine name is required when updating.',
            'medicineName.unique' => 'This medicine name is already taken.',
        ];
    }
}
