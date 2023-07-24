<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Validation\ValidationException as Validation;

class ValidationException extends Validation
{
    public function render()
    {
        $errors = [];
        foreach($this->validator->errors()->messages() as $field => $errorMessages)
        {
            $errors[$field] = [
                'message' => $errorMessages[0]
            ];
        }

        return response()->json([
            'status' => 'invalid',
            'message' => 'Request body is not valid.',
            'violations' => $errors,
        ], 400);
    }
}
