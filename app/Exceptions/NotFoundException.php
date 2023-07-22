<?php

namespace App\Exceptions;

use Exception;

class NotFoundException extends Exception
{
    public function render($request){
        return response()->json([
            'message' => 'Data not found.'
        ], 404);
    }
}
