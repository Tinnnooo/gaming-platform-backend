<?php

namespace App\Http\Controllers;

use App\Exceptions\BlockedUserException;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\TokenResource;
use App\Services\AuthControllerService;
use App\Traits\RespondHttp;

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
        if($user->blocked){
            return $this->respondBlocked($user);
        }

        return $this->respondSuccess(new TokenResource($user));
    }

    public function signout()
    {
        auth()->user()->currentAccessToken()->delete();

        return $this->respondOk();
    }
}
