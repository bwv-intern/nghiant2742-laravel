<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\ProductController;
use App\Models\User;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

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
    $id = Auth::id();
    if (!$id) {
        return view('index');
    }

    $user = DB::table('users')->find($id);
    return view('index', ['name' => $user->name]);
})->name('home');

// Auth
Route::get('/login', [AuthController::class, 'login'])->name('login');

Route::post('/login', [AuthController::class, 'handleLogin']);

Route::get('/register', [AuthController::class, 'register'])->name('register');

Route::post('/register', [AuthController::class, 'handleRegister']);

Route::get('/logout', [AuthController::class, 'logout'])->name('logout');


// Product
Route::get('/product', [ProductController::class, 'index'])->name('product');

Route::get('/product/{id}', [ProductController::class, 'show']);

Route::get('/add', [ProductController::class, 'add'])->name('product.add');

Route::post('/add', [ProductController::class, 'store']);

Route::get('/edit/{id}', [ProductController::class, 'edit'])->name('product.edit');

Route::put('/edit/{id}', [ProductController::class, 'update']);

Route::delete('/delete/{id}', [ProductController::class, 'destroy'])->name('product.delete');

// Post
Route::get('/posts', [PostController::class, 'index']);

Route::get('/client', [HomeController::class, 'index']);

Route::get('/server', [HomeController::class, 'index2']);

Route::post('/handle', [HomeController::class, 'handle']);

Route::get('/126148', [HomeController::class, 'index3']);

Route::post('/confirmSubmit', [HomeController::class, 'handleBack']);