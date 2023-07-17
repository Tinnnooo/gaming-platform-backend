<?php

namespace App\Http\Controllers;

use App\Http\Requests\SignupRequest;
use App\Services\AuthControllerService;
use App\Traits\RespondHttp;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    use RespondHttp;

    public function __construct(protected AuthControllerService $authControllerService)
    {

    }

    public function signup(SignupRequest $request)
    {
        $user = $this->authControllerService->signup($request->validated());

        return $this->respondSuccess([
            'message' => 'success',
            'token' => $user->createToken('accessToken')->plainTextToken,
        ]);
    }
}
