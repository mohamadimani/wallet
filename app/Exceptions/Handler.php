<?php

namespace App\Exceptions;

use App\Facades\ApiResponse;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\BadRequestHttpException;
use Throwable;

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
    }

    public function render($request, Throwable $exception)
    {
        if ($exception instanceof BadRequestHttpException) {
            return ApiResponse::message($exception->getMessage())
                ->status(Response::HTTP_BAD_REQUEST)
                ->send();
        }

        return parent::render($request, $exception);
    }
}
