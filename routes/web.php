<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CommentController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\DeepThoughtController;
use App\Http\Controllers\RegistrationController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('demo');
});

Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

Route::get('/register', [RegistrationController::class, 'showRegistrationForm'])->name('register')->middleware('auth');
Route::post('/register', [RegistrationController::class, 'register']);

Route::get('/users', [UserController::class, 'index'])->name('users.index')->middleware('auth');
Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('auth');
Route::get('/users/{id}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('auth'); // Show edit form
Route::put('/users/{id}', [UserController::class, 'update'])->name('users.update')->middleware('auth'); // Handle update request

Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard')->middleware('auth');

Route::get('/blogs/create', [BlogController::class, 'create'])->name('blogs.create')->middleware('auth');
Route::post('/blogs', [BlogController::class, 'store'])->name('blogs.store')->middleware('auth');
Route::get('/blogs', [BlogController::class, 'index'])->name('blogs.index');
Route::delete('/blogs/{id}', [BlogController::class, 'destroy'])->name('blogs.destroy')->middleware('auth');
Route::get('/blogs/{id}', [BlogController::class, 'show'])->name('blogs.show');
Route::get('/blogs/{id}/edit', [BlogController::class, 'edit'])->name('blogs.edit')->middleware('auth');
Route::put('/blogs/{id}', [BlogController::class, 'update'])->name('blogs.update')->middleware('auth');
Route::post('/blogs/{id}/comment', [CommentController::class, 'store'])->name('comments.store');
Route::delete('/comments/{id}', [CommentController::class, 'destroy'])->name('comments.destroy')->middleware('auth');;


Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('auth');
Route::post('/posts', [PostController::class, 'store'])->name('posts.store')->middleware('auth');
Route::get('/posts', [PostController::class, 'index'])->name('posts.index');
Route::get('/posts/{id}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('auth');
Route::put('/posts/{id}', [PostController::class, 'update'])->name('posts.update')->middleware('auth');
Route::delete('/posts/{id}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('auth');

Route::get('/contact', [ContactController::class, 'showForm'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'submitForm'])->name('contact.submit');
Route::get('/contact/messages', [ContactController::class, 'index'])->name('contact.index')->middleware('auth');
Route::get('/contact/messages/{id}', [ContactController::class, 'show'])->name('contact.showDetails')->middleware('auth');
Route::delete('/contact/messages/{id}', [ContactController::class, 'destroy'])
    ->name('contact.destroy')
    ->middleware('auth');


Route::get('/deep-thoughts', [DeepThoughtController::class, 'index'])->name('deep-thoughts.index');
Route::middleware(['auth'])->group(function () {
    Route::get('/deep-thoughts/create', [DeepThoughtController::class, 'create'])->name('deep-thoughts.create');
    Route::post('/deep-thoughts', [DeepThoughtController::class, 'store'])->name('deep-thoughts.store');
    Route::get('/deep-thoughts/{id}/edit', [DeepThoughtController::class, 'edit'])->name('deep-thoughts.edit');
    Route::put('/deep-thoughts/{id}', [DeepThoughtController::class, 'update'])->name('deep-thoughts.update');
    Route::delete('/deep-thoughts/{id}', [DeepThoughtController::class, 'destroy'])->name('deep-thoughts.destroy');
});

