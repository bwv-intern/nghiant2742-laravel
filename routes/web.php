<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ErrorController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
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

Route::get('admin/login', [AuthController::class, 'login'])->name('login');
Route::post('admin/login', [AuthController::class, 'handleLogin']);

Route::group(['middleware' => ['auth', 'check.route.exists']], function () {
    Route::get('admin', [AuthController::class, 'index'])->name('admin');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
    Route::get('admin/error/403', [ErrorController::class, 'deniedPermission'])->name('403');
    Route::get('admin/error/404', [ErrorController::class, 'notFound'])->name('404');
    Route::fallback(function () {
        return redirect()->route('404');
    });


    Route::group(['middleware' => ['checkRole:0']], function () {
        Route::get('admin/user', [UserController::class, 'index'])->name('user');
        Route::get('admin/user/add', [UserController::class, 'create'])->name('user.add');
        Route::post('admin/user/add', [UserController::class, 'store'])->name('user.store');
        Route::get('users/export', [UserController::class, 'exportCSV'])->name('user.export');
        Route::get('admin/user/{id}', [UserController::class, 'show']);
        Route::put('admin/user/{id}', [UserController::class, 'update']);
    });

    Route::group(['middleware' => ['checkRole:0,2']], function () {
        Route::get('admin/product', [ProductController::class, 'index'])->name('product');
    });
});