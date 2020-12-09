<?php

use Illuminate\Support\Facades\Route;

Route::group(['prefix' => 'quan-ly','namespace'=>'App\Http\Controllers\Admin'], function () {
    Route::get('/', 'homeController@index');
    //bậc đào tạo
    Route::group(['prefix' => 'bac-dao-tao'], function () {
        Route::get('/', 'bacDaoTaoController@index');
        Route::post('them', 'bacDaoTaoController@themBacDaoTao');
        Route::post('sua', 'bacDaoTaoController@suaBacDaoTao');
        Route::get('xoa/{id}', 'bacDaoTaoController@xoaBacDaoTao');
    });
    //ngành học
    Route::group(['prefix' => 'nganh-hoc'], function () {
        Route::get('/', 'nganhController@index');
        // Route::post('them', '');
        // Route::post('sua/{id}', '');
        // Route::post('xoa/{id}', '');
    });
    //hệ
    Route::group(['prefix' => 'he'], function () {
        Route::get('/', 'heController@index');
        // Route::post('them', '');
        // Route::post('sua/{id}', '');
        // Route::post('xoa/{id}', '');
    });

    //chương trình đào tạo
    Route::group(['prefix' => 'chuong-trinh-dao-tao'], function () {
        Route::get('/', 'chuongTrinhDTController@index');
        // Route::post('them', '');
        // Route::post('sua/{id}', '');
        // Route::post('xoa/{id}', '');
    });

    //chuẩn đầu ra
    Route::group(['prefix' => 'chuan-dau-ra'], function () {
        Route::get('/', 'chuanDauRaController@index');
        // Route::post('them', '');
        // Route::post('sua/{id}', '');
        // Route::post('xoa/{id}', '');
    });

    //loại học phần
    Route::group(['prefix' => 'loai-hoc-phan'], function () {
        Route::get('/', 'loaiHocPhanController@index');
        // Route::post('them', '');
        // Route::post('sua/{id}', '');
        // Route::post('xoa/{id}', '');
    });

    //loại học phần
    Route::group(['prefix' => 'hoc-phan'], function () {
        Route::get('/', 'hocPhanController@index');
        // Route::post('them', '');
        // Route::post('sua/{id}', '');
        // Route::post('xoa/{id}', '');
    });

    //khối kiến thức
    Route::group(['prefix' => 'khoi-kien-thuc'], function () {
        Route::get('/', 'khoiKienThucController@index');
        // Route::post('them', '');
        // Route::post('sua/{id}', '');
        // Route::post('xoa/{id}', '');
    });

    //phương pháp giảng dạy
    Route::group(['prefix' => 'phuong-phap-giang-day'], function () {
        Route::get('/', 'ppGiangDayController@index');
        // Route::post('them', '');
        // Route::post('sua/{id}', '');
        // Route::post('xoa/{id}', '');
    });
   
});