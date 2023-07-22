<?php

namespace App\Services;

use App\Exceptions\ServerBusyException;
use App\Exceptions\UnauthenticatedException;
use App\Models\PlatformUser;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\QueryException;

class AuthControllerService
{
    public function signup($validator)
    {
        DB::beginTransaction();

        try{
            $user = PlatformUser::create([
                'username' => $validator['username'],
                'password' => bcrypt($validator['password']),
                'last_login_at' => now()
            ]);

            DB::commit();

            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw new ServerBusyException;
        }
    }

    public function signin($userData)
    {
        DB::beginTransaction();

        // try{
            if(!auth('platform_users')->once($userData)){
                throw new UnauthenticatedException('Wrong username or password');
            }

            $user = auth('platform_users')->user();
            $user->last_login_at = now();
            $user->save();

            DB::commit();
            return $user;
        // } catch (\Exception $e) {
        //     DB::rollBack();

        //     throw new  ServerBusyException;
        // }
    }
}
