<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChatController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Session;

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
    return redirect('chat');
});

Route::middleware('auth')->group(function () {


Route::get('chat',[ChatController::class,'chat']);
Route::get('getOldMessages',[ChatController::class,'getOldMessages']);
Route::post('send',[ChatController::class,'send']);
Route::post('saveToSession',[ChatController::class,'saveToSession']);
Route::post('deleteSession',[ChatController::class,'deleteSession']);

});
// Auth Routes
Route::get('login', [AuthController::class,'index'])->name('login');
Route::post('post-login', [AuthController::class,'postLogin']);
Route::get('logout', [AuthController::class,'logout']);
