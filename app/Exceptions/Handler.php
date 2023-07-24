<?php

namespace App\Exceptions;

use Exception;
use Throwable;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e) {
            //
        });

        $this->renderable(function (Exception $exception) {
            if($exception instanceof AuthenticationException){
                if (empty(request()->header('Authorization'))) {
                    return response()->json([
                        'status' => 'unauthenticated',
                        'message' => 'Missing token'
                    ], 401);
                };

                return response()->json([
                    'status' => 'unauthenticated',
                    'message' => 'Invalid token',
                ], 401);
            }

            if($exception instanceof NotFoundHttpException && request()->is('api/*')){
                return response()->json([
                    'status' => 'not-found',
                    'message' => 'Not found'
                ], 404);
            }

            return parent::render(request(), $exception);
        });
    }
}
