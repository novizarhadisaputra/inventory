<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Support\Facades\Log;
use App\Http\Transformers\ResponseTransformer;
use Illuminate\Validation\ValidationException;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Laravel\Lumen\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\HttpException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that should not be reported.
     *
     * @var array
     */
    protected $dontReport = [
        // AuthorizationException::class,
        // HttpException::class,
        // ModelNotFoundException::class,
        // ValidationException::class,
    ];

    /**
     * Report or log an exception.
     *
     * This is a great spot to send exceptions to Sentry, Bugsnag, etc.
     *
     * @param  \Throwable  $e
     * @return void
     *
     * @throws \Exception
     */
    public function report(Throwable $e)
    {
        parent::report($e);
    }

    /**
     * Render an exception into an HTTP response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Throwable  $e
     * @return \Illuminate\Http\Response|\Illuminate\Http\JsonResponse
     *
     * @throws \Throwable
     */
    public function render($request, Throwable $e)
    {
        Log::info(" ");
        Log::info("error message: ");
        Log::info($e->getMessage());
        Log::info(" ");

        if ($request->is('api') || $request->is('api/*')) {
            if ($e instanceof MethodNotAllowedHttpException) {
                return (new ResponseTransformer(null, 'Bad Request', 400))->toJson();
            } else if ($e instanceof NotFoundHttpException) {
                return (new ResponseTransformer(null, 'Not Found', 404))->toJson();
            } else {
                return (new ResponseTransformer(null, $e->getMessage(), 400))->toJson();
            }
        }
        return parent::render($request, $e);
    }
}
