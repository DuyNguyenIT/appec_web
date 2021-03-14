<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiangVien;


Route::group(['middleware' =>'App\Http\Middleware\isGiangVien'], function (){  
     Route::group(['prefix' => 'giang-vien','namespace' => 'App\Http\Controllers\GiangVien'], function () {
          Route::post('ckeditor/image_upload', 'GVCKEditorController@upload')->name('uploadgv');
          Route::get('/', 'homeController@index');
          //học phần
           Route::group(['prefix' => 'hoc-phan'], function () {
               Route::get('/', 'GVHocPhanController@index');
               Route::get('/in-de-cuong-mon-hoc/{maHocPhan}', 'GVWordController@in_de_cuong_mon_hoc');
               Route::get('/hoc-phan-ctdt/{maCT}','GVHocPhanController@hocPhanViaCTDT');
               Route::post('/giang-vien-day-hoc-phan','GVHocPhanController@GVHocPhanController@giang_vien_day_hoc_phan');
               Route::get('/xem-ds-sv/{maLop}', 'GVHocPhanController@xem_ds_sv_giang_day');
               Route::get('/xem-ket-qua-hoc-tap/{maHocPhan}','GVHocPhanController@xem_ket_qua_hoc_tap');
               Route::get('/chuan-dau-ra-dap-ung-giang-day/{maHocPhan}/{maLop}/{maHK}/{namHoc}/{maBaiQH}', 'GVHocPhanController@chuan_dau_ra_dap_ung_giang_day');
               Route::post('/them-chuan-dau-ra', 'GVHocPhanController@them_chuan_dau_ra');
               Route::post('/sua-chuan-dau-ra', 'GVHocPhanController@sua_chuan_dau_ra');
               Route::get('/xem-de-cuong-chi-tiet/{maHocPhan}','GVHocPhanController@xem_de_cuong_chi_tiet');
               Route::group(['prefix' => 'chuong'], function () {
                   Route::get('/{maHocPhan}','GVChuongController@index');
                   Route::post('/themsubmit','GVChuongController@them');
                   Route::post('/suasubmit','GVChuongController@sua');
                   Route::get('/xoa/{id}','GVChuongController@xoa'); 
                   Route::prefix('/muc')->group(function () {
                        Route::get('/{maChuong}','GVMucController@index'); 
                        //thêm sửa câu hỏi tự luận
                        Route::get('/cau-hoi-tu-luan/{maMuc}','GVMucController@cau_hoi_tu_luan');
                        Route::post('/cau-hoi-tu-luan/them','GVMucController@them_tu_luan');
                        Route::post('/cau-hoi-tu-luan/sua','GVMucController@sua_tu_luan');
                        //thêm sửa câu hỏi trắc nghiệm
                        Route::get('/cau-hoi-trac-nghiem/{maMuc}','GVMucController@cau_hoi_trac_nghiem');
                        Route::post('/cau-hoi-trac-nghiem/them','GVMucController@them_trac_nghiem');
                        Route::post('/cau-hoi-trac-nghiem/sua','GVMucController@sua_trac_nghiem');
                        //thêm sửa câu hỏi thực hành
                        Route::get('/cau-hoi-thuc-hanh/{maMuc}','GVMucController@cau_hoi_thuc_hanh');
                        Route::post('/cau-hoi-thuc-hanh/them','GVMucController@them_thuc_hanh');
                        Route::post('/cau-hoi-thuc-hanh/sua','GVMucController@sua_thuc_hanh');
                   });
                   Route::group(['prefix' => '/{idchuong}/{tenkhongdau}/cau-hoi-tu-luan'], function () {
                       Route::get('/','GVCauHoiTuLuanController@index');
                       Route::post('/them','GVCauHoiTuLuanController@them');
                       Route::post('/sua','GVCauHoiTuLuanController@sua');
                   });

               });

           });
          //quy hoạch đánh giá
          Route::group(['prefix' => 'quy-hoach-danh-gia'], function () {
               Route::get('/', 'quyhoachController@index');
               Route::get('/quy-hoach-ket-qua/{maHocPhan}/{maBaiQH}/{maHK}/{namHoc}/{maLop}', 'quyhoachController@quy_hoach_ket_qua_hoc_tap');
               Route::post('/them-quy-hoach', 'quyhoachController@them_quy_hoach');
               Route::post('/chon-nhom-cong-thuc','quyhoachController@chon_nhom_cong_thuc');
               //nội dung quy hoạch
               Route::group(['prefix' => 'noi-dung-quy-hoach'], function () {
                    Route::get('/{maCTBaiQH}','quyhoachController@noi_dung_quy_hoach');
                    Route::post('/them-noi-dung-quy-hoach-submit','quyhoachController@them_noi_dung_quy_hoach_submit');
                    Route::get('/chuong/{maNoiDungQH}','quyhoachController@chuong_noidungqh');
                    Route::post('/chuong/them-chuong-noi-dung-quy-hoach', 'quyhoachController@them_chuong_ndqh');
                    Route::get('them-cau-hoi-tu-luan', 'quyhoachController@them_cau_hoi_tu_luan');
               });

               //nội dung đánh giá
               Route::group(['prefix' => 'noi-dung-danh-gia'], function () {
                    Route::get('/xem-tieu-chi-danh-gia/{maCTBaiQH}', 'quyhoachController@xem_tieu_chi_danh_gia');
                    Route::get('/them-de-thi-tu-luan','quyhoachController@them_de_thi_tu_luan');
                    Route::get('/them-de-thi-trac-nghiem','quyhoachController@them_de_thi_trac_nghiem');

                    Route::get('/them-tieu-chi-danh-gia/{maTCBaiQH}', 'quyhoachController@them_tieu_chi_danh_gia');
                    Route::get('/get-tieu-chuan-by-NDQH/{maNoiDungQH}','quyhoachController@get_tieu_chuan_by_NDQH');
                    Route::post('/them-tieu-chi-submit','quyhoachController@them_tieu_chi_danh_gian_submit');
                    Route::post('/them-tieu-chuan','quyhoachController@them_tieu_chuan_submit');
                    Route::post('/moi-cham-bao-cao','quyhoachController@moi_cham_bao_cao');
                    Route::post('/them-phieu-cham','quyhoachController@them_phieu_cham');
                    Route::post('/them-de-tai','quyhoachController@them_de_tai');

                    //thi tự luận
                    Route::post('/them-de-thi-tu-luan-submit', 'quyhoachController@them_de_thi_tu_luan_submit');
                    //thi thực hành
                    Route::post('/them-de-thi-thuc-hanh-submit', 'quyhoachController@them_de_thi_thuc_hanh_submit');
                    //thi trắc nghiệm
                    Route::post('/them-de-thi-trac-nghiem-submit','quyhoachController@them_de_thi_trac_nghiem_submit');
                    

                    Route::prefix('xem-noi-dung-danh-gia')->group(function () {
                         //xem nội dung
                         Route::get('/{maCTBaiQH}', 'quyhoachController@xem_noi_dung_danh_gia');
                         //tự luận
                         Route::get('/cau-truc-de-tu-luan/{maDe}', 'quyhoachController@cau_truc_de_luan'); //
                         Route::post('/them-cau-hoi-de-luan','quyhoachController@them_cau_hoi_de_luan'); //
                         Route::get('/in-de-tu-luan/{maDe}/{maHocPhan}','GVWordController@in_de_thi_tu_luan');
                         //thực hành
                         Route::get('/cau-truc-de-thuc-hanh/{maDe}', 'quyhoachController@cau_truc_de_thuc_hanh');
                         Route::post('/them-cau-hoi-de-thuc-hanh','quyhoachController@them_cau_hoi_de_thuc_hanh'); //
                         Route::get('/in-de-thuc-hanh/{maDe}/{maHocPhan}','GVWordController@in_de_thi_thuc_hanh');
                         
                         //trắc nghiệm
                         Route::get('/cau-truc-de-trac-nghiem/{maDe}','quyhoachController@cau_truc_de_trac_nghiem');
                         Route::post('/them-cau-hoi-trac-nghiem','quyhoachController@them_cau_hoi_de_trac_nghiem');
                         Route::get('/in-de-trac-nghiem/{maDe}/{maHocPhan}','GVWordController@in_de_thi_trac_nghiem');
                    });
               }); 
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
               Route::get('/noi-dung-danh-gia/{maBaiQH}/{maHocPhan}','chamDiemBCController@noi_dung_danh_gia');
               Route::get('/nhap-ket-qua-danh-gia/{maCTBaiQH}', 'chamDiemBCController@nhap_ket_qua_danh_gia');
               Route::get('/nhap-diem-do-an/{maDe}/{maSSV}', 'chamDiemBCController@nhap_diem_do_an');
               Route::post('/cham-diem-submit', 'chamDiemBCController@cham_diem_submit');
               Route::get('/xem-ket-qua-danh-gia/{maPhieuCham}','chamDiemBCController@xem_ket_qua_danh_gia');
          });

          //kết quả đánh giá
          Route::group(['prefix' => 'ket-qua-danh-gia'], function () {
               Route::get('/', 'ketQuaDanhGiaController@index');
               Route::get('/ket-qua-hoc-phan/{maHocPhan}/{maBaiQH}/{maHK}/{namHoc}/{maLop}', 'ketQuaDanhGiaController@chi_tiet_quy_hoach_kq_qua_danh_gia');
               Route::get('/nhap-ket-qua-danh-gia/{maCTBaiQH}', 'ketQuaDanhGiaController@nhap_ket_qua_danh_gia');
               Route::get('/nhap-diem-do-an/{maDe}/{maSSV}', 'ketQuaDanhGiaController@nhap_diem_do_an');
               Route::post('/cham-diem-submit','ketQuaDanhGiaController@cham_diem_submit');
               Route::get('/xem-ket-qua-danh-gia/{maDe}/{maSSV}/{maCanBo}', 'ketQuaDanhGiaController@xem_ket_qua_danh_gia');
              
               Route::prefix('tuluan')->group(function () {
                   Route::post('/them-phieu-cham', 'ketQuaDanhGiaController@them_phieu_cham_tu_luan');
               });
          });
         });
});
   