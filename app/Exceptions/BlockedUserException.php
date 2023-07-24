<?php

namespace App\Exceptions;

use Exception;

class BlockedUserException extends Exception
{
    public function render($request)
    {
        return response()->json([
            'status' => 'blocked',
            'message' => 'You have been blocked by an administrator.',
            'reason' => auth()->user()->blocked->reason,
        ]);
    }
}
