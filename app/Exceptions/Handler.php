<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Auth\Access\AuthorizationException;
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

    public function render($request, Throwable $exception)
    {
        // 權限異常處理
        if ($exception instanceof AuthorizationException) {
            // 如果是後台請求，則重定向到後台登入頁面
            if ($request->is('admin*')) {
                return redirect('/admin/login')->withErrors([
                    'auth' => '很抱歉，您沒有權限進入後台!請與管理人員聯絡'
                ]);
            }
        }
        return parent::render($request, $exception);
    }
}
