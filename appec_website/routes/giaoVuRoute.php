<?php

use Illuminate\Support\Facades\Route;


 Route::group(['prefix' => 'giao-vu','namespace'=>'App\Http\Controllers\GiaoVu'], function () {
    Route::get('/', 'homeController@index');
    //quản lý lớp
    Route::group(['prefix' => 'quan-ly-lop'], function () {
           Route::get('/', 'lopController@index');
    //     Route::post('them', '');
    //     Route::post('chinh-sua/{id}', '');
    //     Route::post('xoa/{id}', '');
    });
    //học phần
    Route::group(['prefix' => 'hoc-phan'], function () {
           Route::get('/', 'hocPhanController@index');
    //     Route::post('them', '');
    //     Route::post('chinh-sua/{id}', '');
    //     Route::post('xoa/{id}', '');
    });
    //cập nhật điểm kết thúc
     Route::group(['prefix' => 'cap-nhat-diem-ket-thuc'], function () {
           Route::get('/', 'capNhatDiemController@index');
    //     Route::post('them', '');
    //     Route::post('chinh-sua/{id}', '');
    //     Route::post('xoa/{id}', '');
     });

    //thống kê
     Route::group(['prefix' => 'thong-ke'], function () {
         Route::get('/', 'thongKeController@index');
    //     Route::post('them', '');
    //     Route::post('chinh-sua/{id}', '');
    //     Route::post('xoa/{id}', '');
    });

   

    
});