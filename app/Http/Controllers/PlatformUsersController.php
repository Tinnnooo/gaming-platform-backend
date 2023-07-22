<?php

namespace App\Http\Controllers;

use App\Exceptions\NotFoundException;
use App\Http\Resources\UserResource;
use App\Models\PlatformUser;
use App\Traits\RespondHttp;
use Illuminate\Http\Request;

class PlatformUsersController extends Controller
{
    use RespondHttp;

    public function getUser($username)
    {
        $user = PlatformUser::where('username', $username)->first();

        if(empty($user)){
            throw new NotFoundException('User not found');
        }

        return $this->respondSuccess(new UserResource($user));
    }
}
