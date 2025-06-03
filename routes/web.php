<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Mail;
use App\Models\User;
use App\Mail\LoginNotification;
use App\Http\Controllers\{
    AuthController,
    PostController,
    UserController,
    AdminController,
    FacebookController,
    GoogleController,
    CommentController
};
use App\Http\Controllers\AdminPostController;
use App\Http\Controllers\Frontend\HomeController;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/

Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']); // alias route

// Authentication
Route::get('login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('login', [AuthController::class, 'login']);
Route::get('register', [AuthController::class, 'showRegisterForm'])->name('register');
Route::post('register', [AuthController::class, 'register']);
Route::post('logout', [AuthController::class, 'logout'])->name('logout');

// Password Reset
Route::get('forgot-password', [AuthController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [AuthController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('reset-password/{token}', [AuthController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [AuthController::class, 'reset'])->name('password.update');

// Social Login
Route::get('redirect-google', [GoogleController::class, 'index'])->name('redirect-google');
Route::get('callback-google', [GoogleController::class, 'callback']);

// View post details (public)
Route::get('/posts/{post}/show', [PostController::class, 'show'])->name('posts.show');

// Admin user view
Route::get('/users/{id}', [AdminController::class, 'show'])->name('admin.users.show');

// Test Email
Route::get('/test-mail', function () {
    $user = User::first();
    Mail::to('your_email@gmail.com')->send(new LoginNotification($user));
    return 'Mail sent (check your inbox/spam)';
});


/*
|--------------------------------------------------------------------------
| Authenticated User Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth'])->group(function () {
    // Post likes and saves
    Route::post('/posts/{post}/like', [PostController::class, 'toggleLike'])->name('posts.toggleLike');
    Route::post('/posts/{post}/toggle-save', [PostController::class, 'toggleSave'])->name('posts.toggleSave');

    // Comments
    Route::post('/posts/{post}/comment', [CommentController::class, 'store'])->name('posts.comment');
    Route::get('/comments/{comment}/edit', [CommentController::class, 'edit'])->name('comments.edit');
    Route::put('/comments/{comment}', [CommentController::class, 'update'])->name('comments.update');

    // User Dashboard
    Route::get('/user/dashboard', [UserController::class, 'dashboard'])->name('user.dashboard')->middleware('is_user');
    Route::resource('posts', PostController::class)->middleware('is_user');

    // View user profile
    Route::get('/users/{user}', [UserController::class, 'show'])->name('users.show');
});


/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'is_admin'])->prefix('admin')->name('admin.')->group(function () {
    // Dashboard
    Route::get('/dashboard', [AdminController::class, 'dashboard'])->name('dashboard');

    // Manage users
    Route::delete('/users/{id}', [AdminController::class, 'destroy'])->name('users.destroy');
    Route::get('/users/{id}', [AdminController::class, 'show'])->name('users.show');

    // Manage posts
    Route::get('/posts/{post}/edit', [AdminPostController::class, 'edit'])->name('posts.edit');
    Route::put('/posts/{post}', [AdminPostController::class, 'update'])->name('posts.update');
    Route::delete('/posts/{post}', [AdminPostController::class, 'destroy'])->name('posts.destroy');
    Route::get('/posts/{id}', [AdminController::class, 'showPost'])->name('posts.show');

    // Manage comments and likes
    Route::delete('/comments/{comment}', [AdminController::class, 'Commentdestroy'])->name('comments.destroy');
    Route::delete('/likes/{id}', [AdminController::class, 'Likedestroy'])->name('likes.destroy');
});
