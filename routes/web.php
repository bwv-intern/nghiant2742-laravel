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
    return "Welcome";
});

Route::get('/client', [HomeController::class, 'index']);

Route::get('/server', [HomeController::class, 'index2']);

Route::post('/handle', [HomeController::class, 'handle']);

