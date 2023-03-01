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
Route::resource('/device', App\Http\Controllers\DeviceController::class)->middleware('auth');

Route::put('/transaction/{id}/update', 'App\Http\Controllers\TransactionController@updateStatus')->middleware('auth');
Route::get('/report', 'App\Http\Controllers\ReportController@index')->middleware('auth')->name('report');
Route::get('/generate-pdf', 'App\Http\Controllers\ReportController@generatePDF')->middleware('auth');
Route::get('/generate-excel', 'App\Http\Controllers\ReportController@generateExcel')->middleware('auth')->name('laporan.excel');


Route::get('/booking/{id}/add', 'App\Http\Controllers\DeviceController@bookingAdd')->middleware('auth');
Route::get('/booking/{id}', 'App\Http\Controllers\DeviceController@booking')->middleware('auth');

Route::get('/chart-data', 'App\Http\Controllers\HomeController@pieCartData');
Route::get('/chart-pie-data', 'App\Http\Controllers\HomeController@pieCartData2');
Route::get('/profile', 'App\Http\Controllers\HomeController@profile')->middleware('auth')->name('profile');
Route::put('/profile/{id}', 'App\Http\Controllers\HomeController@update')->middleware('auth');

Route::get('/chart-area-data', 'App\Http\Controllers\HomeController@areaCartData');
