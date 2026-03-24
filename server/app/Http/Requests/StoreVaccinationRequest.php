<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreVaccinationRequest extends FormRequest
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
            'dogId' => 'required|integer|exists:dogs,id', // A kutyának léteznie kell
            'medicineId' => 'required|integer|exists:medicines,id', // A gyógyszernek léteznie kell
            'timeOfVaccination' => 'required|date', // Az oltás időpontja kötelező és érvényes dátumnak kell lennie
            'vaccinationPrice' => 'required|integer|min:0', // Az oltás ára egész szám és legalább 0
        ];
    }

    public function messages()
{
    return [
        'dogId.required' => 'Dog is required.',
        'dogId.integer'  => 'Dog ID must be an integer.',
        'dogId.exists'   => 'The selected dog does not exist.',

        'medicineId.required' => 'Medicine is required.',
        'medicineId.integer'  => 'Medicine ID must be an integer.',
        'medicineId.exists'   => 'The selected medicine does not exist.',

        'timeOfVaccination.required' => 'Vaccination date is required.',
        'timeOfVaccination.date'     => 'Vaccination date must be a valid date.',

        'vaccinationPrice.required' => 'Vaccination price is required.',
        'vaccinationPrice.integer'  => 'Vaccination price must be an integer.',
        'vaccinationPrice.min'      => 'Vaccination price cannot be negative.',
    ];
}

}
