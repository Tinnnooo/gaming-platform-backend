<?php

namespace App\Exceptions;

use Exception;

class ServerBusyException extends Exception
{
    public function render($request, $status = 500)
    {
        return response()->json([
            'message' => 'Server is currently busy. Please try again.',
        ], $status);
    }
}
