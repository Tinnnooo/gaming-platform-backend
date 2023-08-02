<?php

namespace App\Http\Controllers;

use App\Exceptions\BlockedUserException;
use App\Http\Requests\SigninRequest;
use App\Http\Requests\SignupRequest;
use App\Http\Resources\TokenResource;
use App\Services\AuthService;
use App\Traits\RespondHttp;

class AuthController extends Controller
{
    use RespondHttp;

    public function __construct(protected AuthService $authService)
    {
    }

    // get user auth
    public function me()
    {
        $user = auth()->user();
        return $this->respondSuccess([
            'username' => $user->username,
            'game_scores' => $user->game_scores,
            'uploaded_games' => $user->uploaded_games,
        ]);
    }

    // signup platform users
    public function signup(SignupRequest $request)
    {
        $user = $this->authService->signup($request->validated());

        return $this->respondSuccess(new TokenResource($user));
    }


    // signin platform users
    public function signin(SigninRequest $request)
    {
        $user = $this->authService->signin($request->validated());
        if ($user->blocked) {
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
