<?php

namespace App\Http\Requests;

use App\Models\AdoptionRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateAdoptionStatusRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'status' => [
                'required',
                'string',
                Rule::in([
                    AdoptionRequest::STATUS_APPROVED,
                    AdoptionRequest::STATUS_REJECTED,
                ]),
            ],
        ];
    }

    public function messages(): array
    {
        return [
            'status.required' => 'Status is required.',
            'status.string' => 'Status must be a string.',
            'status.in' => 'Status must be either "approved" or "rejected".',
        ];
    }
}
