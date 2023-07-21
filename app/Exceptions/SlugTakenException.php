<?php

namespace App\Exceptions;

use Exception;

class SlugTakenException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'message' => 'invalid',
            'slug' => 'Game title already exist',
        ], 400);
    }
}
