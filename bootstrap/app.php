<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware) {
        // 1. Đăng ký alias cho middleware (Dùng gọi riêng lẻ trong từng Route)
        $middleware->alias([
            'admin'        => \App\Http\Middleware\AdminMiddleware::class,
            'check.active' => \App\Http\Middleware\CheckActiveUser::class,
        ]);

        // 2. Thêm vào web middleware group để tự động chạy cho TẤT CẢ các request nhóm web
        $middleware->appendToGroup('web', [
            \App\Http\Middleware\CheckActiveUser::class,
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
