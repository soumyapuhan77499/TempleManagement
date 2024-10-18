<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\AuthenticationException; // Add this import
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
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
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /**
     * Override the default unauthenticated response.
     *
     * @param \Illuminate\Http\Request  $request
     * @param \Illuminate\Auth\AuthenticationException  $exception
     * @return \Illuminate\Http\Response
     */
    protected function unauthenticated($request, AuthenticationException $exception)
{
    // Check if the guard used is 'api' or 'sanctum', and force JSON response
    if ($request->is('api/*') || $request->expectsJson()) {
        return response()->json([
            'status' => 401,
            'message' => 'Invalid or missing authentication token.',
            'data' => null,
        ], 401);
    }

    // For web requests, redirect to the login page
    // return redirect()->guest(route('templelogin'));
}

}
