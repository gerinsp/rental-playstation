<?php

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

Route::get('/', function () {
    return redirect('/home');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home')->middleware('auth');

Route::resource('/members', App\Http\Controllers\MemberController::class)->middleware('auth');
Route::resource('/playstation', App\Http\Controllers\PlayController::class)->middleware('auth');
Route::resource('/transaction', App\Http\Controllers\TransactionController::class)->middleware('auth');
Route::get('/report', 'App\Http\Controllers\ReportController@index')->middleware('auth')->name('report');
Route::get('/generate-pdf', 'App\Http\Controllers\ReportController@generatePDF')->middleware('auth');

Route::get('/chart-data', 'App\Http\Controllers\HomeController@pieCartData');
Route::get('/profile', 'App\Http\Controllers\HomeController@profile')->middleware('auth')->name('profile');
Route::put('/profile/{id}', 'App\Http\Controllers\HomeController@update')->middleware('auth');

Route::get('/chart-area-data', 'App\Http\Controllers\HomeController@areaCartData');
