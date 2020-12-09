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
Route::group(['prefix' => '/','namespace'=>'App\Http\Controllers'], function () {
    Route::get('/', 'loginController@index');
    Route::get('/dang-nhap', 'loginController@index');
    Route::post('/dang-nhap_submit', function () {
        
    });
    Route::get('/dang-xuat', function () {
        
    });
});




