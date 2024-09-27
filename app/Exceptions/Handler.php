<?php

namespace App\Exceptions;

use Illuminate\Auth\AuthenticationException; // AuthenticationExceptionクラスのインポート
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
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

    /**
     * Handle unauthenticated user access attempts.
     *
     * @param \Illuminate\Http\Request $request
     * @param \Illuminate\Auth\AuthenticationException $exception
     * @return \Illuminate\Http\RedirectResponse|\Illuminate\Http\JsonResponse
     */
    protected function unauthenticated($request, AuthenticationException $exception)
    {
        // AJAXリクエストの場合はJSONレスポンスを返す
        if ($request->expectsJson()) {
            return response()->json(['message' => 'Unauthenticated.'], 401);
        }

        // 通常のリクエストではログインページにリダイレクトし、エラーメッセージを表示
        return redirect()->route('login')->with('error', 'セッションの有効期限が切れました。再度ログインしてください。');
    }

    /**
     * Handle general exceptions
     */
    public function render($request, Throwable $exception)
    {
        // 未認証の場合、unauthenticatedメソッドで処理される
        if ($exception instanceof AuthenticationException) {
            return $this->unauthenticated($request, $exception);
        }

        // 他の例外処理
        return parent::render($request, $exception);
    }
}
