<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBreedRequest extends FormRequest
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
    // A route-ból kinyerjük a fajta ID-ját a kivételhez
    $breedId = $this->route('breed');

    return [
        // Fajta neve validáció sometimes-szal
        'breed' => 'sometimes|required|string|max:50|unique:breeds,breed,' . $breedId,
    ];
}

public function messages(): array
{
    return [
        'breed.required' => 'A fajta megnevezése kötelező, ha módosítani kívánod!',
        'breed.string'   => 'A fajta nevének szöveges formátumúnak kell lennie!',
        'breed.max'      => 'A fajta neve nem lehet hosszabb 50 karakternél!',
        'breed.unique'   => 'Ez a fajta már szerepel az adatbázisunkban!',
    ];
}

}
