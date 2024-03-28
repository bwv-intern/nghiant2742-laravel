<?php

use App\Http\Controllers\AuthController;
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

Route::group(['middleware' => ['auth']], function () {
    Route::get('admin', [AuthController::class, 'index'])->name('admin');
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
   
    Route::get('admin/product', function() {
        return view('product.index');
    });
});