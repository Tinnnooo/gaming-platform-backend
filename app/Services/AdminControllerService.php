<?php

namespace App\Services;

use App\Models\PlatformUser;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class AdminControllerService
{
    public function getUser($username)
    {
        $user = PlatformUser::where('username', $username)->firstOrFail();

        if($user->blocked)
        {
            throw new NotFoundHttpException;
        }

        return $user;
    }
}
