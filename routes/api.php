<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\BlogController;
use App\Http\Controllers\Api\CommentController;
use App\Http\Controllers\Api\ContactController;
use App\Http\Controllers\Api\DashboardController;
use App\Http\Controllers\Api\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/dashboard', [DashboardController::class, 'dashboard']);

Route::middleware('auth:sanctum')->post('/blogs', [BlogController::class, 'store']);
Route::get('/blogs', [BlogController::class, 'index']);
Route::get('/blogs/{id}', [BlogController::class, 'show']);
Route::middleware('auth:sanctum')->put('/blogs/{id}', [BlogController::class, 'update']); // Update blog
Route::middleware('auth:sanctum')->delete('/blogs/{id}', [BlogController::class, 'destroy']); // Delete blog
Route::get('/blogs/{id}/comments', [CommentController::class, 'index']); // Get comments
Route::post('/blogs/{id}/comments', [CommentController::class, 'store']); // Post a comment

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::get('/user', function (Request $request) {
        return $request->user();
    });
});

Route::middleware('auth:sanctum')->get('/validate-token', [AuthController::class, 'validateToken']);

Route::middleware('auth:sanctum')->get('/users', [UserController::class, 'index']); // Get all users
Route::middleware('auth:sanctum')->get('/users/{id}', [UserController::class, 'show']); // Get single user
Route::middleware('auth:sanctum')->post('/users', [UserController::class, 'store']); // Create user
Route::middleware('auth:sanctum')->put('/users/{id}', [UserController::class, 'update']); // Update user with role
Route::middleware('auth:sanctum')->delete('/users/{id}', [UserController::class, 'destroy']); // Delete user

Route::post('/contact', [ContactController::class, 'store']); // Submit contact message
Route::middleware('auth:sanctum')->get('/contact', [ContactController::class, 'index']); // Get all contact messages
Route::middleware('auth:sanctum')->get('/contact/{id}', [ContactController::class, 'show']); // Get single message
Route::middleware('auth:sanctum')->delete('/contact/{id}', [ContactController::class, 'destroy']); // Delete message
