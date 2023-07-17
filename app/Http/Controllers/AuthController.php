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
        if (!Auth::guard('platform_users')->attempt($request->validated())) {
            return $this->respondInvalid('Wrong username or password');
        };

        return $this->respondSuccess(new TokenResource(auth('platform_users')->user()));
    }

    public function signout()
    {
        Auth::guard('platform_users')->user()->currentAccessToken()->delete();

        return $this->respondOk();
    }
}
