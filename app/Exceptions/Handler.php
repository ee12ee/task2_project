<?php

namespace App\Exceptions;

use App\Http\Traits\ApiResponse;
use Exception;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
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
        $this->renderable(function (ValidationException $exception, $request) {
            return ApiResponse::sendResponse(422,'',
                ['errors' => $exception->validator->errors()->getMessages()]);
        });
        $this->renderable(function (NotFoundHttpException $exception, $request) {
            if ( $exception->getPrevious() instanceof ModelNotFoundException){
                return ApiResponse::sendResponse(404,'record not found');}
                return ApiResponse::sendResponse(404,'route not found');}
        );

        $this->renderable(function (AuthenticationException $exception, $request) {
            return ApiResponse::sendResponse(401,'Not Authenticated');
        });
}}
