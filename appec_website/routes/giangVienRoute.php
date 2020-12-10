<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiangVien;


   Route::group(['prefix' => 'giang-vien','namespace' => 'App\Http\Controllers\GiangVien'], function () {
    
    Route::get('/', 'homeController@index');
    //học phần
    Route::group(['prefix' => 'hoc-phan'], function () {
         Route::get('/', 'hocPhanController@index');
         Route::get('/hoc-phan-ctdt/{maCT}','hocPhanController@hocPhanViaCTDT');
         Route::post('/giang-vien-day-hoc-phan','hocPhanController@hocPhanController@giang_vien_day_hoc_phan');
          Route::get('/xem-ds-sv/{maLop}', 'hocPhanController@xem_ds_sv_giang_day');
         Route::get('/xem-ket-qua-hoc-tap/{maHocPhan}','hocPhanController@xem_ket_qua_hoc_tap');
          //     Route::post('them', '');
    //     Route::post('chinh-sua/{id}', '');
    //     Route::post('xoa/{id}', '');
     });
    //ngành học
    Route::group(['prefix' => 'quy-hoach-danh-gia'], function () {
         Route::get('/', 'quyhoachController@index');
         Route::get('/quy-hoach-ket-qua/{maHocPhan}', 'quyhoachController@quy_hoach_ket_qua_hoc_tap');
    //     Route::post('chinh-sua/{id}', '');
    //     Route::post('xoa/{id}', '');
     });
    //hệ
    Route::group(['prefix' => 'de-danh-gia'], function () {
         Route::get('/', 'deDanhGiaController@index');
    //     Route::post('them', '');
    //     Route::post('chinh-sua/{id}', '');
    //     Route::post('xoa/{id}', '');
     });

    //chương trình đào tạo
    Route::group(['prefix' => 'cham-diem-bao-cao'], function () {
         Route::get('/', 'chamDiemBCController@index');
    //     Route::post('them', '');
    //     Route::post('chinh-sua/{id}', '');
    //     Route::post('xoa/{id}', '');
     });

    //chuẩn đầu ra
    Route::group(['prefix' => 'ket-qua-danh-gia'], function () {
         Route::get('/', 'ketQuaDanhGiaController@index');
    //     Route::post('them', '');
    //     Route::post('chinh-sua/{id}', '');
    //     Route::post('xoa/{id}', '');
     });

    
   });