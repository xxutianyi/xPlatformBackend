<?php

namespace App\Exceptions;

use App\Utils\Response;
use App\Utils\ShowType;
use Illuminate\Auth\AuthenticationException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Validation\ValidationException;
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
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    public function render($request, Throwable $e)
    {
        if ($request->expectsJson() && is_a($e, ValidationException::class)) {
            return new Response(
                $request,
                $e->errors(),
                $e->getMessage(),
                ShowType::ERROR_MESSAGE,
                422,
            );
        }

        if ($request->expectsJson() && is_a($e, AuthenticationException::class)) {
            return new Response(
                $request,
                null,
                $e->getMessage(),
                ShowType::SILENT,
                401,
            );
        }

        if ($request->expectsJson()) {
            return new Response(
                $request,
                $this->convertExceptionToArray($e),
                $e->getMessage(),
                ShowType::ERROR_MESSAGE,
                $this->isHttpException($e) ? $e->getStatusCode() : 500,
                $this->isHttpException($e) ? $e->getHeaders() : [],
            );
        }

        return parent::render($request, $e);
    }
}
