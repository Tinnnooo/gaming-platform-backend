<?php

namespace App\Http\Controllers;

use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\TokenResource;
use App\Services\AuthControllerService;
use App\Traits\RespondHttp;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    use RespondHttp;

    public function __construct(protected AuthControllerService $authControllerService)
    {
    }

    // signup platform users
    public function signup(SignupRequest $request)
    {
        $user = $this->authControllerService->signup($request->validated());

        return $this->respondSuccess(new TokenResource($user));
    }


    // signin platform users
    public function signin(SigninRequest $request)
    {
        $user = $this->authControllerService->signin($request->validated());

        return $this->respondSuccess(new TokenResource($user));
    }

    public function signout()
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->respondOk();
    }
}
