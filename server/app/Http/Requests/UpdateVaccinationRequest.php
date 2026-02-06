<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateVaccinationRequest extends FormRequest
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
    $vaccinationId = $this->route('vaccination');

    return [
        'dogId' => ['required', 'integer', 'exists:dogs,id'],
        'medicineId' => ['required', 'integer', 'exists:medicines,id'],
        'timeOfVaccination' => [
            'required',
            'date',
            function ($attribute, $value, $fail) use ($vaccinationId) {
                $exists = \DB::table('vaccinations')
                    ->where('dogId', $this->input('dogId'))
                    ->where('medicineId', $this->input('medicineId'))
                    ->where('timeOfVaccination', $value)
                    ->when($vaccinationId, function($query) use ($vaccinationId) {
                        $query->where('id', '<>', $vaccinationId);
                    })
                    ->exists();

                if ($exists) {
                    $fail('Ez az oltás már létezik ugyanazzal a kutyával, gyógyszerrel és időponttal.');
                }
            },
        ],
        'vaccinationPrice' => ['required', 'integer', 'min:0'],
    ];
}}
