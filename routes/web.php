<?php

use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GoogleController;
use App\Mail\LoginNotification;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\CommentController;


// Route::get('/',[HomeController::class,'index'] );
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

Route::middleware(['auth'])->group(function () {
    // Route::post('/posts/{id}/like', [PostController::class, 'toggleLike'])->name('posts.like');
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.toggleLike');
    // Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comment');
    Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comment');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

    Route::get('/admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard')->middleware('is_admin');
    Route::delete('/admin/users/{id}', [AdminController::class, 'destroy'])->name('admin.users.destroy')->middleware('is_admin');

    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard')->middleware('is_user');
    Route::resource('posts', PostController::class)->middleware('is_user');
});

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
});

Route::get('/posts/{post}/show',[PostController::class,'show'])->name('posts.show');
Route::get('/users/{id}', [AdminController::class, 'show'])->name('admin.users.show');

Route::get('/test-mail', function () {
    $user = User::first(); // get any existing user

    Mail::to('your_email@gmail.com')->send(new LoginNotification($user));
    return 'Mail sent (check your inbox/spam)';
});

Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');


Route::get('admin/posts/{id}', [AdminController::class, 'showPost'])->name('admin.posts.show');
Route::delete('admin/comments/{comment}', [AdminController::class, 'Commentdestroy'])->name('admin.comments.destroy');
Route::delete('/likes/{id}', [AdminController::class, 'Likedestroy'])->name('likes.destroy');

Route::post('/posts/{post}/toggle-save', [PostController::class, 'toggleSave'])->name('posts.toggleSave');
Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');

Route::get('redirect-google',[GoogleController::class,'index'])->name('redirect-google');
Route::get('callback-google',[GoogleController::class,'callback']);
Route::get('/home', [HomeController::class, 'index'])->name('home');
