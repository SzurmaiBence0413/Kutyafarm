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
        // Az 'id' paraméter lekérése a route-ból
        $medicineId = $this->route('medicine'); // A route paraméterben elvárjuk a gyógyszer ID-t.

        return [
            'medicineName' => 'required|string|max:100|unique:medicines,medicineName,' . $medicineId, // Kivéve, ha a jelenlegi rekordról van szó
        ];
    }
}
