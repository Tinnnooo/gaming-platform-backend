<?php

namespace App\Http\Middleware;

use App\Exceptions\BlockedUserException;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsBlockedUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(auth()->check() && auth()->user()->blocked){
            auth()->user()->currentAccessToken()->delete();

            throw new BlockedUserException;
        }
        return $next($request);
    }
}
