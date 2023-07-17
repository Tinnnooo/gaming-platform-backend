<?php

namespace App\Services;

use App\Models\PlatformUser;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;

class AuthControllerService
{
    public function signup($validator)
    {
        DB::beginTransaction();

        try{
            $user = PlatformUser::create([
                'username' => $validator['username'],
                'password' => bcrypt($validator['password']),
            ]);

            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
