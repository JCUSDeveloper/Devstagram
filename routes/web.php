<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\LikeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ImageController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\LogoutController;
use App\Http\Controllers\CommentsController;
use App\Http\Controllers\FollowerController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PerfilController;
use App\Http\Controllers\RegisterController;
use Symfony\Component\HttpKernel\HttpCache\HttpCache;

// Rutas Modificar Perfil
Route::middleware('auth')->group(function () {
    Route::get('/', HomeController::class)->name('home');
    Route::get('/edit-profile', [PerfilController::class, 'index'])->name('perfil.index');
    Route::post('/edit-profile', [PerfilController::class, 'store'])->name('perfil.store');
});

// Otras rutas sin parámetros dinámicos
Route::get('/register', [RegisterController::class, 'index'])->name('register');
Route::post('/register', [RegisterController::class, 'store']);

Route::get('/login', [LoginController::class, 'index'])->name('login');
Route::post('/login', [LoginController::class, 'store'])->name('login.posts');
Route::post('/logout', [LogoutController::class, 'store'])->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/posts/create', [PostController::class, 'create'])->name('posts.create');
    Route::post('/posts', [PostController::class, 'store'])->name('posts.store');
});
Route::post('/imagenes', [ImageController::class, 'store'])->name('imagenes.store');
Route::delete('/post/{post}', [PostController::class, 'destroy'])->name('posts.destroys');

// Like Fotos
Route::post('/posts/{post}/likes', [LikeController::class, 'store'])->name('posts.likes.store');
Route::delete('/posts/{post}/likes', [LikeController::class, 'destroy'])->name('posts.likes.destroy');

// Rutas dinámicas con parámetros
Route::get('/{user:username}/posts/{post}', [PostController::class, 'show'])->name('posts.show');
Route::get('/{user:username}', [PostController::class, 'index'])->name('posts.index');
Route::post('/{user:username}/posts/{post}', [CommentsController::class, 'store'])->name('comentarios.store');
//Siguiendo usuarios
Route::post('/{user:username}/follow', [FollowerController::class, 'store'])->name('users.follow');
Route::delete('/{user:username}/unfollow', [FollowerController::class, 'destroy'])->name('users.unfollow');

