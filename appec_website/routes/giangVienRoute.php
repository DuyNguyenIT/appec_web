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
     //  Route::post('them', '');
     //  Route::post('chinh-sua/{id}', '');
     //  Route::post('xoa/{id}', '');
     });
    //quy hoạch đánh giá
     Route::group(['prefix' => 'quy-hoach-danh-gia'], function () {
         Route::get('/', 'quyhoachController@index');
         Route::get('/quy-hoach-ket-qua/{maHocPhan}/{maBaiQH}/{maHK}/{namHoc}/{maLop}', 'quyhoachController@quy_hoach_ket_qua_hoc_tap');
         Route::post('/them-quy-hoach', 'quyhoachController@them_quy_hoach');
         Route::get('xem-noi-dung-danh-gia/{maCTBaiQH}', 'quyhoachController@xem_noi_dung_danh_gia');
         Route::get('xem-tieu-chi-danh-gia/{maCTBaiQH}', 'quyhoachController@xem_tieu_chi_danh_gia');
         Route::post('/them-phieu-cham','quyhoachController@them_phieu_cham');
         Route::post('/them-de-tai','quyhoachController@them_de_tai');
     });
    //đề đánh giá
    Route::group(['prefix' => 'de-danh-gia'], function () {
         Route::get('/', 'deDanhGiaController@index');
    //   Route::post('them', '');
    //   Route::post('chinh-sua/{id}', '');
    //   Route::post('xoa/{id}', '');
     });

    //chấm điểm báo cáo
    Route::group(['prefix' => 'cham-diem-bao-cao'], function () {
         Route::get('/', 'chamDiemBCController@index');
    //   Route::post('them', '');
    //   Route::post('chinh-sua/{id}', '');
    //   Route::post('xoa/{id}', '');
     });

    //kết quả đánh giá
    Route::group(['prefix' => 'ket-qua-danh-gia'], function () {
         Route::get('/', 'ketQuaDanhGiaController@index');
         Route::get('/ket-qua-hoc-phan/{maHocPhan}/{maBaiQH}/{maHK}/{namHoc}/{maLop}', 'ketQuaDanhGiaController@chi_tiet_quy_hoach_kq_qua_danh_gia');
         Route::get('nhap-ket-qua-danh-gia/{maCTBaiQH}', 'ketQuaDanhGiaController@nhap_ket_qua_danh_gia');
         Route::get('nhap-diem-do-an/{maDe}/{maSSV}', 'ketQuaDanhGiaController@nhap_diem_do_an');
         Route::post('cham-diem-submit','ketQuaDanhGiaController@cham_diem_submit');
     });

    
   });