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
}
