<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' =>'App\Http\Middleware\isGiaoVu'], function (){  
       Route::group(['prefix' => 'giao-vu','namespace'=>'App\Http\Controllers\GiaoVu'], function () {
              Route::get('/', 'homeController@index');
              //quản lý lớp
              Route::group(['prefix' => 'quan-ly-lop'], function () {
                     Route::get('/', 'lopController@index');
                     Route::get('xem-danh-sach-sinh-vien/{maLop}', 'lopController@xem_danh_sach_sinh_vien');
              //     Route::post('chinh-sua/{id}', '');
              //     Route::post('xoa/{id}', '');
              });
              //học phần
              Route::group(['prefix' => 'hoc-phan-giang-day'], function () {
                     Route::get('/', 'hocPhanController@index');
                     Route::post('them-hoc-phan-giang-day-submit', 'hocPhanController@them_hoc_phan_giang_day');
                    
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
                   Route::group(['prefix' => 'thong-ke-theo-hoc-phan'], function () {
                        Route::get('/{maGV}/{maHocPhan}/{maHK}/{namHoc}/{maLop}', 'thongKeController@thong_ke_theo_hoc_phan');
                        Route::get('/thong-ke-theo-xep-hang/{maCTBaiQH}/{maCanBo}', 'thongKeController@thong_ke_theo_xep_hang');
                        Route::get('/get-xep-hang','thongKeController@get_xep_hang');
                        Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}/{maCanBo}', 'thongKeController@thong_ke_theo_diem_chu');
                        Route::get('/get-diem-chu','thongKeController@get_diem_chu');
                        Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}/{maCanBo}', 'thongKeController@thong_ke_theo_tieu_chi');
                        Route::get('/get-tieu-chi','thongKeController@get_tieu_chi'); 


                        Route::get('/thong-ke-theo-xep-hang-kl/{maCanBo}','thongKeController@thong_ke_theo_xep_hang_kl');
                        Route::get('/get-xep-hang-kl','thongKeController@get_xep_hang_kl');
                        Route::get('/thong-ke-theo-diem-chu-kl/{maCanBo}','thongKeController@thong_ke_theo_diem_chu_kl');
                        Route::get('/get-diem-chu-kl','thongKeController@get_diem_chu_kl');
                        Route::get('/thong-ke-theo-tieu-chi-kl/{maCanBo}','thongKeController@thong_ke_theo_tieu_chi_kl');
                        Route::get('/get-tieu-chi-kl','thongKeController@get_tieu_chi_kl');
                   });
              });
          });
});
