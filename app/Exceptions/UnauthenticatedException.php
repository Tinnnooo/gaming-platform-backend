<?php

namespace App\Exceptions;

use Exception;

class UnauthenticatedException extends Exception
{
    public function render($request, $status = 401)
    {
        return response()->json([
            'status' => 'invalid',
            'message' => $this->getMessage(),
        ], $status);
    }
}
