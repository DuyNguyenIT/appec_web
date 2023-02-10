<?php

use Illuminate\Support\Facades\Route;


Route::group(['middleware' =>'App\Http\Middleware\isGiaoVu'], function (){  
       Route::group(['prefix' => 'giao-vu','namespace'=>'App\Http\Controllers\GiaoVu'], function () {
              Route::get('/', 'homeController@index');

              //quản lý lớp
              Route::group(['prefix' => 'quan-ly-lop'], function () {
                     Route::get('/', 'lopController@index');
                     Route::get('xem-danh-sach-sinh-vien/{maLop}', 'lopController@xem_danh_sach_sinh_vien');
                     Route::post('cap-nhat-ds-sinh-vien-bang-excel', 'dsSinhVienImportController@import');
                     Route::get('tai-file-mau', 'dsSinhVienImportController@download_template');
                     Route::post('them-lop', 'lopController@addClass');
                     Route::post('sua-lop', 'lopController@editClass');
                     Route::get('xoa-lop/{maLop}', 'lopController@delClass');
              });

              //học phần
              Route::group(['prefix' => 'hoc-phan-giang-day'], function () {
                     Route::get('/xoa-hoc-phan-giang-day/{maHocPhan}/{maLop}/{maHK}/{namHoc}','GiaoVuhocPhanController@xoa_hocphan_giangday');
                     Route::get('/xoa-hoc-phan-giang-day-don/{maHocPhan}/{maLop}/{maHK}/{namHoc}/{maGV}','GiaoVuhocPhanController@xoa_hocphan_giangday_gv');
                     Route::get('/xem-danh-sach-sinh-vien/{maHocPhan}/{maLop}/{maHK}/{namHoc}','GiaoVuhocPhanController@xem_danh_sach_sinh_vien');
                     Route::post('them-hoc-phan-giang-day-submit', 'GiaoVuhocPhanController@them_hoc_phan_giang_day');
                     Route::get('/', 'GiaoVuhocPhanController@index');
                     Route::post('cap-nhat-ds-sinh-vien-bang-excel', 'dsSinhVienHocPhanImport@import');
                     Route::get('tai-file-mau', 'dsSinhVienHocPhanImport@download_template');
              });
          
          
              
              //cập nhật điểm kết thúc
               Route::group(['prefix' => 'cap-nhat-diem-ket-thuc'], function () {
                     Route::get('/', 'capNhatDiemController@index');
                     Route::get('/hoc-phan/{namHoc}/{maHK}','capNhatDiemController@hocphan');
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


                        Route::prefix('thuc-hanh')->group(function () {
                            Route::get('thong-ke-theo-xep-hang/{maCTBaiQH}', 'thongKeController@thong_ke_theo_xep_hang_thuc_hanh');
                            Route::get('get-xep-hang','thongKeController@get_xep_hang_thuc_hanh');
                            Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}', 'thongKeController@thong_ke_theo_diem_chu_thuc_hanh');
                            Route::get('/get-diem-chu','thongKeController@get_diem_chu_thuc_hanh');
                            Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}', 'thongKeController@thong_ke_theo_tieu_chi_thuc_hanh');
                            Route::get('/get-tieu-chi','thongKeController@get_tieu_chi_thuc_hanh'); 
                            Route::get('/thong-ke-theo-abet/{maCTBaiQH}', 'thongKeController@thong_ke_theo_abet_tu_luan');
                            Route::get('/get-abet','thongKeController@get_abet_tu_luan'); 

                        }); 
                        

                        Route::prefix('tu-luan')->group(function () {
                            Route::get('thong-ke-theo-xep-hang/{maCTBaiQH}', 'thongKeController@thong_ke_theo_xep_hang_tu_luan');
                            Route::get('get-xep-hang','thongKeController@get_xep_hang_tu_luan');
                            Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}', 'thongKeController@thong_ke_theo_diem_chu_tu_luan');
                            Route::get('/get-diem-chu','thongKeController@get_diem_chu_tu_luan');
                            Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}', 'thongKeController@thong_ke_theo_tieu_chi_tu_luan');
                            Route::get('/get-tieu-chi','thongKeController@get_tieu_chi_tu_luan'); 
                            Route::get('/thong-ke-theo-abet/{maCTBaiQH}', 'thongKeController@thong_ke_theo_abet_tu_luan');
                            Route::get('/get-abet','thongKeController@get_abet_tu_luan'); 
                        });

                        
                   });
              });
          });
});
