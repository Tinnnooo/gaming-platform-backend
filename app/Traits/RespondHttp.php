<?php

namespace App\Traits;

trait RespondHttp
{
    public function respondSuccess($data, $status = 200)
    {
        return response()->json($data, $status);
    }
}
