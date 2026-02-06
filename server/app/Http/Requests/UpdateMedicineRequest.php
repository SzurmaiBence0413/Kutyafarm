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
    // A route paraméterből kinyerjük az ID-t az egyediség vizsgálatához
    $medicineId = $this->route('medicine');

    return [
        // Gyógyszer neve validáció sometimes-szal
        'medicineName' => 'sometimes|required|string|max:100|unique:medicines,medicineName,' . $medicineId,
    ];
}

public function messages(): array
{
    return [
        'medicineName.required' => 'A gyógyszer nevének megadása kötelező módosításkor!',
        'medicineName.string'   => 'A gyógyszer neve csak szöveg lehet!',
        'medicineName.max'      => 'A gyógyszer neve nem lehet hosszabb 100 karakternél!',
        'medicineName.unique'   => 'Ez a gyógyszernév már szerepel a nyilvántartásban!',
    ];
}
}
