<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('auth.auth');
});
Route::get('/login', [App\Http\Controllers\Auth\AuthController::class, 'authForm'])->name('auth');
Route::post('/login', [App\Http\Controllers\Auth\AuthController::class, 'login'])->name('login');
Route::post('/register', [App\Http\Controllers\Auth\AuthController::class, 'register'])->name('register');

Route::group(['middleware' => ['auth', 'prevent.back.history'], 'prefix' => 'app'], function () {
    Route::post('logout', [App\Http\Controllers\Auth\AuthController::class, 'logout'])->name('logout');
    Route::get('users/{id}/edit', [App\Http\Controllers\UserController::class, 'edit'])->name('users.edit');
    Route::put('users/{id}', [App\Http\Controllers\UserController::class, 'update'])->name('users.update');
    Route::get('users/create', [App\Http\Controllers\UserController::class, 'create'])->name('users.create');
    Route::post('users', [App\Http\Controllers\UserController::class, 'store'])->name('users.store');
    Route::get('users', [App\Http\Controllers\UserController::class, 'index'])->name('users.index');
    Route::delete('users/{id}', [App\Http\Controllers\UserController::class, 'destroy'])->name('users.destroy');
});

Route::get('password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('password/email', [App\Http\Controllers\Auth\PasswordResetController::class, 'sendResetLinkEmail'])->name('password.email');
Route::get('password/reset/{token}', [App\Http\Controllers\Auth\PasswordResetController::class, 'showResetForm'])->name('password.reset');
Route::post('password/reset', [App\Http\Controllers\Auth\PasswordResetController::class, 'reset'])->name('password.update');
