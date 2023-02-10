<?php

use Illuminate\Support\Facades\Route;
Route::group(['prefix' => 'bo-mon','namespace' => 'App\Http\Controllers\BoMon'], function () {
    Route::get('/', 'BMHomeController@index');

    //quản lý lớp
    Route::group(['prefix' => 'quan-ly-lop'], function () {
        Route::get('/', 'BMlopController@index');
        Route::get('xem-danh-sach-sinh-vien/{maLop}', 'BMlopController@xem_danh_sach_sinh_vien');
        Route::post('cap-nhat-ds-sinh-vien-bang-excel', 'dsSinhVienImportController@import');
        Route::get('tai-file-mau', 'dsSinhVienImportController@download_template');
        Route::post('them-lop', 'BMlopController@addClass');
        Route::post('sua-lop', 'BMlopController@editClass');
        Route::get('xoa-lop/{maLop}', 'BMlopController@delClass');
    });

    //route phan cong giang day
    Route::prefix('phan-cong-giang-day')->group(function () {
        Route::get('/','BMhocPhanController@index');
        Route::get('/{namHoc}','BMhocPhanController@xem_phan_cong_giang_day_theo_nam_hoc');
        Route::post('them-phan-cong-giang-day-submit', 'BMhocPhanController@them_hoc_phan_giang_day');
        Route::get('/xoa-hoc-phan-giang-day/{maHocPhan}/{maLop}/{maHK}/{namHoc}','BMhocPhanController@xoa_hocphan_giangday');
        Route::get('/xoa-hoc-phan-giang-day-don/{maHocPhan}/{maLop}/{maHK}/{namHoc}/{maGV}','BMhocPhanController@xoa_hocphan_giangday_gv');
        Route::get('/xem-danh-sach-sinh-vien/{maHocPhan}/{maLop}/{maHK}/{namHoc}','BMhocPhanController@xem_danh_sach_sinh_vien');
    });

    //route phan quyen nhan de cuong

    //
    
});