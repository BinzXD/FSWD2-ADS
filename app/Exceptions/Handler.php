<?php

namespace App\Exceptions;

use Throwable;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

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
     */
    public function register(): void
    {
        $this->renderable(function (NotFoundHttpException $e, $request) {
            return response()->json([
                'status'    => false,
                'success'   => false,
                'message'   => 'Mohon maaf, sistem kami tidak dapat menemukan data ini',
                'data'      => null
            ], 404);
        });

        // Menangani ModelNotFoundException (404 khusus untuk model yang tidak ditemukan)
        $this->renderable(function (ModelNotFoundException $e, $request) {
            return response()->json([
                'status'    => false,
                'success'   => false,
                'message'   => 'Mohon maaf, data yang Anda cari tidak ditemukan',
                'data'      => null
            ], 404);
        });
        $this->reportable(function (Throwable $e) {
            //
        });
    }
}
