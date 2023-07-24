<?php

namespace App\Traits;

trait RespondHttp
{
    public function respondSuccess($data, $status = 200)
    {
        return response()->json($data, $status);
    }

    public function respondInvalid($message, $status = 401)
    {
        return response()->json([
            "status" => "invalid",
            'message' => $message,
        ], $status);
    }

    public function respondOk($status = 200)
    {
        return response()->json([
            'status' => 'success',
        ], $status);
    }

    public function respondBlocked($user)
    {
        return response()->json([
            'status' => 'blocked',
            'message' => 'You have been blocked by an administrator.',
            'reason' => $user->blocked->reason,
        ], 401);
    }
}
