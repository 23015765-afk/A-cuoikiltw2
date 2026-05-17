<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AdminMiddleware
{
    /**
     * Kiểm tra xem user có phải Admin không.
     * Nếu không → redirect về trang chủ với thông báo lỗi.
     *
     * Middleware chạy TRƯỚC khi request đến Controller.
     * Nếu điều kiện không thỏa → return redirect ngay, không chạy tiếp.
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Kiểm tra đã đăng nhập chưa
        if (!auth()->check()) {
            return redirect()->route('login');
        }

        // Kiểm tra có phải Admin không
        if (!auth()->user()->isAdmin()) {
            abort(403, 'Bạn không có quyền truy cập trang này.');
        }

        // Kiểm tra tài khoản có bị khóa không
        if (!auth()->user()->is_active) {
            auth()->logout();
            return redirect()->route('login')->with('error', 'Tài khoản của bạn đã bị khóa.');
        }

        return $next($request);
    }
}
