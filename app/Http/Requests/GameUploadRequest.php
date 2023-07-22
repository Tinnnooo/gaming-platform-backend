<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class GameUploadRequest extends FormRequest
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
            'zipfile' => 'required|mimes:zip|max:2048',
        ];
    }
}