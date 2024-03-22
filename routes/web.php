<?php

use App\Http\Controllers\HomeController;
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

Route::get('/', function(){
    return view('index');
})->name('home');

Route::get('/client', [HomeController::class, 'index']);

Route::get('/server', [HomeController::class, 'index2']);

Route::post('/handle', [HomeController::class, 'handle']);

Route::get('/126148', [HomeController::class, 'index3']);

Route::post('/confirmSubmit', [HomeController::class, 'handleBack']);


