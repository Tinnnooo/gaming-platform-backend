<?php

namespace App\Http\Requests;

use App\Exceptions\ValidationException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;

class EditGameRequest extends FormRequest
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
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'nullable|min:3|max:60',
            'description' => 'nullable|min:0|max:200',
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        throw new ValidationException($validator);
    }
}
