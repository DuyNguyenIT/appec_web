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
    Route::post('/dang-nhap', 'loginController@login_submit');
    Route::get('/dang-xuat', 'loginController@logout');
     Route::get('cap-nhat-muc-nuoc/{id_ct}/{water}', function ($id_ct,$water) {
        if($id_ct!=null && $water!=null){
            return 'Server nh&#7853;n &#273;&#432;&#7907;c m&#7921;c n&#432;&#7899;c = '.$water;
        }else{
            return 'Có l&#7895;i!!!';
        }
        
    });
});




