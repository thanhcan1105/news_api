<?php

use App\Http\Controllers\HomeController;
use Illuminate\Support\Facades\Route;

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
// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', 'AdminController@index');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout')->name('logout');
//user


// Backend section start
Route::get('getResults', [HomeController::class, 'getResult']);
Route::get('crawlData', [HomeController::class, 'crawlData']);
