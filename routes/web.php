<?php

use App\Http\Controllers\Auth\AuthController;
use App\Http\Controllers\Post\PostController;
use App\Http\Controllers\User\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('login', function () {
    if (auth()->check()) {
        return redirect()->route('posts');
    }
    return view('auth.login');
})->name('login');

Route::get('register', function () {
    return view('auth.register');
})->name('showregister');
Route::post('/register', [AuthController::class, 'register'])->name('register');
Route::post('/login', [AuthController::class, 'login'])->name('login.post');
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');


Route::middleware('auth:sanctum')->group(function () {
    Route::get('/', [UserController::class, 'getUserPosts'])->name('getUserPosts');
    Route::get('/all-posts', [UserController::class, 'AllPosts'])->name('all.posts');
    Route::post('/create-post', [PostController::class, 'store'])->name('posts.store');
    Route::put('/update-post', [PostController::class, 'update'])->name('posts.update');
    Route::put('/update-post', [PostController::class, 'updatePost'])->name('posts.update');
    Route::delete('/delete-post/{id}', [PostController::class, 'destroy'])->name('posts.destroy');

    Route::post('/comments', [PostController::class, 'Commentstore'])->name('comment.store');
    Route::post('/comments/like', [PostController::class, 'like'])->name('comment.like');
   Route::post('/comments/unlike', [PostController::class, 'unlike'])->name('comment.unlike');
   Route::post('/comments/{comment}', [PostController::class, 'updateComment'])->name('comment.update');
   Route::post('/comments/{comment}', [PostController::class, 'deleteComment'])->name('comment.destroy');


   Route::get('/user-with-likes', [PostController::class, 'getUsersWithCommentLikes'])->name('user.likes');
});
