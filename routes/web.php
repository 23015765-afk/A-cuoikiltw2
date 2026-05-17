<?php

use Illuminate\Support\Facades\Route;

// ================================================
// ROUTES CÔNG KHAI (không cần đăng nhập)
// ================================================

// Trang chủ — hiển thị danh sách bài viết mới nhất
Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// Xem danh sách bài viết (có filter, tìm kiếm, phân trang)
Route::get('/posts', [App\Http\Controllers\PostController::class, 'index'])->name('posts.index');

// Xem chi tiết 1 bài viết theo slug
Route::get('/posts/{slug}', [App\Http\Controllers\PostController::class, 'show'])->name('posts.show');

// Xem bài viết theo danh mục
Route::get('/categories/{slug}', [App\Http\Controllers\CategoryController::class, 'show'])->name('categories.show');

// Tìm kiếm bài viết
Route::get('/search', [App\Http\Controllers\SearchController::class, 'index'])->name('search');

// ================================================
// ROUTES YÊU CẦU ĐĂNG NHẬP (middleware auth)
// ================================================
Route::middleware(['auth', 'verified'])->group(function () {

    // Dashboard người dùng
    Route::get('/dashboard', [App\Http\Controllers\DashboardController::class, 'index'])->name('dashboard');

    // Bình luận bài viết
    Route::post('/posts/{post}/comments', [App\Http\Controllers\CommentController::class, 'store'])->name('comments.store');
    Route::delete('/comments/{comment}', [App\Http\Controllers\CommentController::class, 'destroy'])->name('comments.destroy');

    // Yêu thích bài viết (toggle: thêm/xóa)
    Route::post('/posts/{post}/favorite', [App\Http\Controllers\FavoriteController::class, 'toggle'])->name('favorites.toggle');
    Route::get('/favorites', [App\Http\Controllers\FavoriteController::class, 'index'])->name('favorites.index');

    // Đánh giá bài viết
    Route::post('/posts/{post}/rating', [App\Http\Controllers\RatingController::class, 'store'])->name('ratings.store');

    // Profile người dùng
    Route::get('/profile', [App\Http\Controllers\ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [App\Http\Controllers\ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [App\Http\Controllers\ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================================================
// ROUTES ADMIN (middleware admin)
// ================================================
Route::prefix('admin')
    ->name('admin.')
    ->middleware(['auth', 'admin'])
    ->group(function () {

    // Dashboard Admin
    Route::get('/', [App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard');

    // Quản lý bài viết (Resource route = CRUD đầy đủ)
    Route::resource('posts', App\Http\Controllers\Admin\PostController::class);

    // Quản lý danh mục
    Route::resource('categories', App\Http\Controllers\Admin\CategoryController::class);

    // Quản lý người dùng
    Route::resource('users', App\Http\Controllers\Admin\UserController::class)->except(['create', 'store']);
    Route::patch('users/{user}/toggle-status', [App\Http\Controllers\Admin\UserController::class, 'toggleStatus'])->name('users.toggle-status');

    // Quản lý bình luận
    Route::get('comments', [App\Http\Controllers\Admin\CommentController::class, 'index'])->name('comments.index');
    Route::patch('comments/{comment}/approve', [App\Http\Controllers\Admin\CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('comments/{comment}', [App\Http\Controllers\Admin\CommentController::class, 'destroy'])->name('comments.destroy');
});

// Routes Authentication của Breeze
require __DIR__.'/auth.php';
