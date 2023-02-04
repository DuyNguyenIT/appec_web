<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\GiangVien;


Route::group(['middleware' =>'App\Http\Middleware\isGiangVien'], function (){  
     Route::group(['prefix' => 'giang-vien','namespace' => 'App\Http\Controllers\GiangVien'], function () {
          
          Route::post('ckeditor/image_upload', 'GVCKeditorController@upload')->name('uploadgv');
          
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
               
               Route::group(['prefix' => 'chuong'], function () { //route này hiện không dùng
                   Route::get('/{maHocPhan}','GVChuongController@index');
                   Route::post('/themsubmit','GVChuongController@them');
                   Route::post('/suasubmit','GVChuongController@sua');
                   Route::get('/xoa/{id}','GVChuongController@xoa'); 
                   Route::prefix('/muc')->group(function () {  //rout này hiện không dùng
                       
                        //thêm sửa câu hỏi tự luận
                        Route::get('/cau-hoi-tu-luan/{maMuc}/{maCTBaiQH}','GVCauHoiTuLuanController@index');
                        Route::post('/cau-hoi-tu-luan/them','GVCauHoiTuLuanController@them');
                        Route::post('/cau-hoi-tu-luan/sua','GVCauHoiTuLuanController@sua');
                        Route::get('/cau-hoi-tu-luan/xoa/{maCauHoi}','GVCauHoiTuLuanController@xoa');
                        Route::get('/get-cau-hoi-tu-luan-by-mamuc/{maMuc}','GVAjaxController@get_cau_hoi_tu_luan_by_mamuc');
                        
                        //thêm sửa câu hỏi trắc nghiệm
                        Route::get('/get-cau-hoi-trac-nghiem-by-mamuc/{maMuc}','GVAjaxController@get_cau_hoi_trac_nghiem_by_mamuc');
                        Route::get('/cau-hoi-trac-nghiem/{maMuc}','GVMucController@cau_hoi_trac_nghiem');
                        Route::get('/them-cau-hoi-trac-nghiem/?maMuc={maMuc}','GVMucController@view_them_trac_nghiem');
                        Route::post('/cau-hoi-trac-nghiem/them','GVMucController@them_trac_nghiem');
                        Route::post('/cau-hoi-trac-nghiem/sua','GVMucController@sua_trac_nghiem');
                        
                        //thêm sửa câu hỏi thực hành
                        Route::get('/get-cau-hoi-thuc-hanh-by-mamuc/{maMuc}','GVAjaxController@get_cau_hoi_thuc_hanh_by_mamuc');
                        Route::get('/cau-hoi-thuc-hanh/{maMuc}/{maCTBaiQH}','GVMucController@cau_hoi_thuc_hanh');
                        Route::post('/cau-hoi-thuc-hanh/them','GVMucController@them_thuc_hanh');
                        Route::post('/cau-hoi-thuc-hanh/sua','GVMucController@sua_thuc_hanh');
                        Route::get('/cau-hoi-thuc-hanh/xoa/{maCauHoi}','GVMucController@xoa_thuc_hanh');
                        
                        //xem - muc 
                        Route::get('/{maChuong}','GVMucController@index');
                        Route::get('/get-muc-by-machuong/{maChuong}','GVAjaxController@get_muc_by_ma_chuong');
                   });
                  
               });
          });

          ///giang-vien/quy-hoach-danh-gia
          Route::group(['prefix' => 'quy-hoach-danh-gia'], function () {
               //nội dung quy hoạch
               Route::group(['prefix' => 'noi-dung-quy-hoach'], function () {
                    #/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/1
                    Route::get('/{maCTBaiQH}','quyhoachController@noi_dung_quy_hoach');
                    Route::post('/them-noi-dung-quy-hoach-submit','quyhoachController@them_noi_dung_quy_hoach');
                    Route::post('/sua-noi-dung-quy-hoach-submit','quyhoachController@sua_noi_dung_quy_hoach');
                    Route::get('/xoa-noi-dung-quy-hoach/{maNoiDungQH}','quyhoachController@xoa_moi_dung_quy_hoach');
                    Route::get('/chuong/{maNoiDungQH}','quyhoachController@chuong_noidungqh');
                    Route::post('/chuong/them-chuong-noi-dung-quy-hoach', 'quyhoachController@them_chuong_ndqh');
                    Route::get('them-cau-hoi-tu-luan', 'quyhoachController@them_cau_hoi_tu_luan');
                    #/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/su-dung-lai-du-lieu
                    Route::post('su-dung-lai-du-lieu','quyhoachController@su_dung_lai_du_lieu');
                    #/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/xoa-toan-bo-du-lieu/1
                    Route::get('xoa-toan-bo-du-lieu/{maCTBaiQH}','quyhoachController@xoa_toan_bo_du_lieu');
               });

               //nội dung đánh giá
               Route::group(['prefix' => 'noi-dung-danh-gia'], function () {

                    Route::get('/xem-tieu-chi-danh-gia/{maCTBaiQH}', 'quyhoachController@xem_tieu_chi_danh_gia');
                    Route::post('/sua-tieu-chi-danh-gia-submit','quyhoachController@sua_tieu_chi_danh_gia_submit');
                    Route::post('/sua-tieu-chi-danh-gia','quyhoachController@sua_abet_tieu_chi_danh_gia');
                   
                    Route::get('/xoa-tieu-chi-danh-gia/{maTCDG}/{maTCCD}','quyhoachController@xoa_tieu_chi_danh_gia');
                    Route::post('/sua-chuan-abet','quyhoachController@sua_abet_tieu_chi_danh_gia');
                    Route::get('/them-de-thi-tu-luan','quyhoachController@them_de_thi_tu_luan');
                    Route::get('/them-de-thi-trac-nghiem','quyhoachController@them_de_thi_trac_nghiem');

                    Route::get('/them-tieu-chi-danh-gia/{maTCBaiQH}', 'quyhoachController@them_tieu_chi_danh_gia');
                    Route::get('/get-tieu-chuan-by-NDQH/{maNoiDungQH}','GVAjaxController@get_tieu_chuan_by_NDQH');
                    Route::get('/get-kqht-by-NDQH/{maNoiDungQH}','GVAjaxController@get_kqht_by_NDQH');
                    Route::get('/get-cdr3-by-NDQH/{maNoiDungQH}','GVAjaxController@get_cdr3_by_NDQH');
                    Route::post('/them-tieu-chi-submit','quyhoachController@them_tieu_chi_danh_gian_submit');
                    Route::post('/them-tieu-chuan','quyhoachController@them_tieu_chuan_submit');
                    Route::post('/sua-tieu-chuan','quyhoachController@sua_tieu_chuan_submit');
                    Route::get('/xoa-tieu-chuan/{maTCDG}','quyhoachController@xoa_tieu_chuan_submit');
                    Route::post('/moi-cham-bao-cao','quyhoachController@moi_cham_bao_cao');
                    Route::post('/them-phieu-cham','quyhoachController@them_phieu_cham');
                    Route::post('/them-de-tai','quyhoachController@them_de_tai');

                    Route::get('xoa-phieu-cham-do-an/{maDe}/{maSSV}','quyhoachController@xoa_phieu_cham');
                    Route::post('sua-ten-de-tai', 'quyhoachController@sua_ten_de_tai');
                    Route::get('/xoa-ten-de-tai/{maDe}','quyhoachController@xoa_de_tai');
                    
                    Route::get('/get-abet-by-cdr3/{maCDR3}','GVAjaxController@get_abet_by_cdr3');

                    //ngân hàng câu hỏi trắc nghiệm
                    Route::prefix('ngan-hang-cau-hoi-trac-nghiem')->group(function () {
                         //them
                         Route::post('/them-cau-hoi-submit','GVCauHoiTracNghiemController@them');
                         Route::get('/them-cau-hoi','GVCauHoiTracNghiemController@view_them');
                         //sua
                         Route::get('/sua-cau-hoi/{maCauHoi}','GVCauHoiTracNghiemController@view_sua');
                         Route::post('/sua-cau-hoi-submit','GVCauHoiTracNghiemController@sua');
                         //xoa
                         Route::get('/xoa-cau-hoi/{maCauHoi}','GVCauHoiTracNghiemController@xoa');
                         //hien thi
                         Route::get('/{id_muc}/{maCTBaiQH}','GVCauHoiTracNghiemController@index');
                    });

                    //ngan hang cau hoi tu luan
                    Route::prefix('ngan-hang-cau-hoi-tu-luan')->group(function () {
                        Route::get('/{maMuc}/{maCTBaiQH}','GVCauHoiTuLuanController@index');
                        Route::post('/cau-hoi-tu-luan/them','GVCauHoiTuLuanController@them');
                        Route::post('/cau-hoi-tu-luan/sua','GVCauHoiTuLuanController@sua');
                        Route::get('/cau-hoi-tu-luan/xoa/{maCauHoi}','GVCauHoiTuLuanController@xoa');
                        Route::get('/get-cau-hoi-tu-luan-by-mamuc/{maMuc}','GVAjaxController@get_cau_hoi_tu_luan_by_mamuc');
                    });
                    
                    //ngan hag cau hoi thuc hanh
                    Route::prefix('ngan-hang-cau-hoi-thuc-hanh')->group(function () {
                        Route::get('/get-cau-hoi-thuc-hanh-by-mamuc/{maMuc}/{maCTBaiQH}','GVAjaxController@get_cau_hoi_thuc_hanh_by_mamuc');
                        Route::get('/{maMuc}/{maCTBaiQH}','GVCauHoiThucHanhController@index');
                        Route::post('/cau-hoi-thuc-hanh/them','GVCauHoiThucHanhController@them');
                        Route::post('/cau-hoi-thuc-hanh/sua','GVCauHoiThucHanhController@sua');
                        Route::get('/cau-hoi-thuc-hanh/xoa/{maCauHoi}','GVCauHoiThucHanhController@xoa');
                    });
                    
                    //-----------------------------------de thi
                      //thi tự luận
                    Route::post('/them-de-thi-tu-luan-submit', 'GVDeThiTuLuanController@them_de_thi_tu_luan_submit');
                    //thi thực hành
                    Route::post('/them-de-thi-thuc-hanh-submit', 'GVDeThiThucHanhController@them_de_thi_thuc_hanh_submit');
                    //thi trắc nghiệm
                    Route::post('/them-de-thi-trac-nghiem-submit','GVDeThiTracNghiemController@them_de_thi_trac_nghiem_submit');
                    
                    Route::prefix('xem-noi-dung-danh-gia')->group(function () {
                         //ngân hàng câu hỏi
                         Route::get('ngan-hang-cau-hoi', 'GVChuongController@ngan_hang_cau_hoi');
                         //hoi thao
                         //hoi thao. Mai thêm
                         Route::get('xoa-phieu-cham-SV-trong-nhom/{maDe}/{maSSV}', 'quyhoachController@xoa_phieu_cham');
                         Route::get('xoa-de-tai-hoi-thao/{maDe}', 'quyhoachController@xoa_de_tai_hoi_thao');
                         //Hết Mai thêm
                         //tự luận
                         Route::get('/cau-truc-de-tu-luan/{maDe}', 'GVDeThiTuLuanController@cau_truc_de_luan'); //
                         Route::post('/them-cau-hoi-de-tu-luan','GVDeThiTuLuanController@them_cau_hoi_de_luan'); //
                         Route::get('/in-de-tu-luan/{maDe}/{maHocPhan}','GVWordController@in_de_thi_tu_luan');
                         Route::get('/xoa-cau-hoi-de-tu-luan/{maDe}/{maCauHoi}','GVDeThiTuLuanController@xoa_cau_hoi_de_tu_luan');
                         Route::post('sua-phuong-an-tu-luan', 'GVDeThiTuLuanController@chinh_sua_phuong_an_tu_luan');
                         Route::post('/sua-thong-tin-de-tu-luan','GVDeThiTuLuanController@sua_thong_tin_de_luan');
                         Route::get('/xoa-de-tu-luan/{maDe}', 'GVDeThiTuLuanController@xoa_de_tu_luan');
                         
                         //thực hành
                         Route::get('/cau-truc-de-thuc-hanh/{maDe}', 'GVDeThiThucHanhController@cau_truc_de_thuc_hanh');
                         Route::get('/xoa-de-thuc-hanh/{maDe}','GVDeThiThucHanhController@xoa_de_thuc_hanh');
                         Route::post('/them-cau-hoi-de-thuc-hanh','GVDeThiThucHanhController@them_cau_hoi_de_thuc_hanh'); //
                         Route::get('/in-de-thuc-hanh/{maDe}/{maHocPhan}','GVWordController@in_de_thi_thuc_hanh');
                         Route::get('/xoa-cau-hoi-de-thuc-hanh/{maDe}/{maCauHoi}','GVDeThiThucHanhController@xoa_cau_hoi_de_thuc_hanh');
                         Route::post('sua-phuong-an-thuc-hanh', 'GVDeThiThucHanhController@chinh_sua_phuong_an_thuc_hanh');
                         
                         //trắc nghiệm
                         Route::get('/cau-truc-de-trac-nghiem/{maDe}','GVDeThiTracNghiemController@cau_truc_de_trac_nghiem');
                         Route::post('/them-cau-hoi-trac-nghiem','GVDeThiTracNghiemController@them_cau_hoi_de_trac_nghiem');
                         Route::get('/in-de-trac-nghiem/{maDe}/{maHocPhan}','GVWordController@in_de_thi_trac_nghiem');
                         Route::get('/xoa-cau-hoi-trac-nghiem/{maCauHoi}','GVDeThiTracNghiemController@xoa_cau_hoi_de_trac_nghiem');
                         Route::get('/xoa-de-thi-trac-nghiem/{maDe}','GVDeThiTracNghiemController@xoa_de_thi');
                         Route::post('sua-thong-tin-de-trac-nghiem','GVDeThiTracNghiemController@chinh_sua_thong_tin_de');
                         Route::post('/xoa-nhieu-cau-hoi-trac-nghiem','GVDeThiTracNghiemController@xoa_nhieu_cau_hoi_de_trac_nghiem');
                         //xem nội dung
                         Route::get('/{maCTBaiQH}', 'quyhoachController@xem_noi_dung_danh_gia');
                         Route::get('/get-cdr3-from-maCauHoi/{maCauHoi}','GVAjaxController@get_cdr3_from_maCauHoi');
                    });
               }); 



               Route::get('/', 'quyhoachController@index');
               Route::get('xoa-nhom-cong-thuc/{maBaiQH}','quyhoachController@xoa_nhom_cong_thuc');
               Route::get('/{namHoc}/{maHK}', 'quyhoachController@nam_hocki');
               Route::post('/loc','quyhoachController@filter');
               Route::get('/quy-hoach-ket-qua/{maHocPhan}/{maBaiQH}/{maHK}/{namHoc}/{maLop}', 'quyhoachController@quy_hoach_ket_qua_hoc_tap');
               Route::post('/them-quy-hoach', 'quyhoachController@them_quy_hoach');
               Route::post('/chon-nhom-cong-thuc','quyhoachController@chon_nhom_cong_thuc');
               
           });

          
           //cham diem bao cao
         
           Route::group(['prefix' => 'cham-diem-bao-cao'], function () {
               Route::get('/', 'chamDiemBCController@index');
               Route::get('/noi-dung-danh-gia/{maBaiQH}/{maHocPhan}','chamDiemBCController@noi_dung_danh_gia');
               Route::get('/nhap-ket-qua-danh-gia/{maCTBaiQH}', 'chamDiemBCController@nhap_ket_qua_danh_gia');
               Route::get('/nhap-diem-do-an/{maDe}/{maSSV}', 'chamDiemBCController@nhap_diem_do_an');
               Route::post('/cham-diem-submit', 'chamDiemBCController@cham_diem_submit');
               Route::get('/xem-ket-qua-danh-gia/{maPhieuCham}','chamDiemBCController@xem_ket_qua_danh_gia');
               Route::get('/sua-diem-do-an/{maPhieuCham}', 'chamDiemBCController@xem_sua_diem_do_an');

               //thuc hanh
               Route::get('/thuc-hanh/nhap-diem-thuc-hanh/{maDe}/{maSSV}', 'chamDiemBCController@nhap_diem_thuc_hanh');
               Route::get('/thuc-hanh/sua-diem-thuc-hanh/{maDe}/{maSSV}', 'chamDiemBCController@sua_diem_thuc_hanh');
               Route::post('/thuc-hanh/cham-diem-submit','chamDiemBCController@cham_diem_thuc_hanh_submit');
               Route::post('/thuc-hanh/sua-diem-submit','chamDiemBCController@sua_diem_thuc_hanh_submit');
               Route::get('thuc-hanh/xem-ket-qua-danh-gia-thuc-hanh/{maDe}/{maSSV}', 'chamDiemBCController@xem_ket_qua_thuc_hanh');
          });

          //ket qua danh gia
          Route::group(['prefix' => 'ket-qua-danh-gia'], function () {
               
               Route::get('/', 'ketQuaDanhGiaController@index');
               Route::get('/ket-qua-hoc-phan/{maHocPhan}/{maBaiQH}/{maHK}/{namHoc}/{maLop}', 'ketQuaDanhGiaController@chi_tiet_quy_hoach_kq_qua_danh_gia');
                //Mai thêm để mời chấm thi thực hành
                Route::post('/nhap-ket-qua-danh-gia/moi-cham-thuc-hanh','ketQuaDanhGiaController@moi_cham_thuc_hanh');
                //Hết Mai thêm
               Route::get('/nhap-ket-qua-danh-gia/{maCTBaiQH}', 'ketQuaDanhGiaController@nhap_ket_qua_danh_gia');
               Route::get('/sua-ket-qua-danh-gia/{maCTBaiQH}', 'ketQuaDanhGiaController@sua_ket_qua_danh_gia');
              
               Route::get('/xoa-phieu-cham/{maDe}/{maSSV}','quyhoachController@xoa_phieu_cham');
               Route::get('/nhap-diem-do-an/{maDe}/{maSSV}', 'ketQuaDanhGiaController@nhap_diem_do_an');
               Route::post('/cham-diem-submit','ketQuaDanhGiaController@cham_diem_submit');
               Route::get('/xem-ket-qua-danh-gia/{maDe}/{maSSV}/{maCanBo}', 'ketQuaDanhGiaController@xem_ket_qua_danh_gia');
               Route::get('/sua-ket-qua-danh-gia-do-an/{maDe}/{maSSV}/{maCanBo}', 'ketQuaDanhGiaController@sua_ket_qua_danh_gia_do_an');
               Route::get('/xuat-bang-diem-do-an/{maCTBaiQH}', 'ketQuaDanhGiaController@export_bang_diem_do_an');

               Route::prefix('thuc-hanh')->group(function () {
                   Route::post('/them-mot-phieu-cham', 'ketQuaDanhGiaController@them_mot_phieu_cham_thuc_hanh');
                   Route::post('/them-nhieu-phieu-cham', 'ketQuaDanhGiaController@them_nhieu_phieu_cham_thuc_hanh');
                   Route::get('/nhap-diem-thuc-hanh/{maDe}/{maSSV}', 'ketQuaDanhGiaController@nhap_diem_thuc_hanh');
                   Route::get('/sua-diem-thuc-hanh/{maDe}/{maSSV}', 'ketQuaDanhGiaController@sua_diem_thuc_hanh_submit');
                   Route::post('/cham-diem-submit1', 'ketQuaDanhGiaController@cham_diem_thuc_hanh_submit1');
                   Route::post('/cham-diem-submit', 'ketQuaDanhGiaController@cham_diem_thuc_hanh_submit');
                   Route::get('/xem-ket-qua-danh-gia-thuc-hanh/{maDe}/{maSSV}', 'ketQuaDanhGiaController@xem_ket_qua_thuc_hanh');
                   Route::get('/xuat-bang-diem-thuc-hanh/{maCTBaiQH}','ketQuaDanhGiaController@export_diem_thuc_hanh');
                   Route::get('/xoa-mot-phieu-cham/{maPhieuCham}','ketQuaDanhGiaController@xoa_mot_phieu_cham_thuc_hanh');
               });

               Route::prefix('tu-luan')->group(function () {
                    Route::post('/them-mot-phieu-cham', 'ketQuaDanhGiaController@them_mot_phieu_cham_tu_luan');
                    Route::post('/them-nhieu-phieu-cham', 'ketQuaDanhGiaController@them_nhieu_phieu_cham_tu_luan');
                    Route::get('/nhap-diem-tu-luan/{maDe}/{maSSV}', 'ketQuaDanhGiaController@nhap_diem_tu_luan');
                    Route::post('/cham-diem-submit', 'ketQuaDanhGiaController@cham_diem_tu_luan_submit');
                    Route::get('/xem-ket-qua-danh-gia-tu-luan/{maDe}/{maSSV}', 'ketQuaDanhGiaController@xem_ket_qua_tu_luan');
                    Route::get('/sua-diem-tu-luan/{maDe}/{maSSV}', 'ketQuaDanhGiaController@sua_diem_tu_luan');
                    Route::post('/sua-diem-submit', 'ketQuaDanhGiaController@cham_diem_tu_luan_submit');
                    Route::get('/xuat-bang-diem-tu-luan/{maCTBaiQH}','ketQuaDanhGiaController@export_diem_tu_luan');
               });

               Route::prefix('trac-nghiem')->group(function () {

                    Route::post('/them-mot-phieu-cham', 'ketQuaDanhGiaController@them_mot_phieu_cham_trac_nghiem');
                    Route::post('/them-nhieu-phieu-cham', 'ketQuaDanhGiaController@them_nhieu_phieu_cham_trac_nghiem');
                    Route::get('/nhap-diem-trac-nghiem/{maDe}/{maSSV}', 'ketQuaDanhGiaController@nhap_diem_trac_nghiem');
                    Route::post('/cham-diem-submit', 'ketQuaDanhGiaController@cham_diem_trac_nghiem_submit');
                    Route::get('/xem-ket-qua-danh-gia-trac-nghiem/{maDe}/{maSSV}','ketQuaDanhGiaController@xem_ket_qua_trac_nghiem');
                    Route::get('/sua-ket-qua-danh-gia-trac-nghiem/{maDe}/{maSSV}','ketQuaDanhGiaController@xem_sua_ket_qua_trac_nghiem');
                    Route::get('/sua-diem-trac-nghiem-submit','ketQuaDanhGiaController@sua_ket_qua_trac_nghiem');
                    Route::get('/xuat-bang-diem-trac-nghiem/{maCTBaiQH}','ketQuaDanhGiaController@export_diem_trac_nghiem');
               });
          });

          //thong ke
          Route::group(['prefix' => 'thong-ke'], function () {
               Route::group(['prefix' => 'thong-ke-theo-hoc-phan'], function () {            
                    Route::get('/{maGV}/{maHocPhan}/{maHK}/{namHoc}/{maLop}', 'GVThongkeController@thong_ke_theo_hoc_phan');
                    
                    Route::prefix('do-an')->group(function () {
                         Route::get('/thong-ke-theo-clo/{maCTBaiQH}/{maCanBo}','GVThongkeController@thong_ke_theo_kqht_doan');
                         Route::get('/get-clo','GVThongkeController@get_clo_doan');
                         Route::get('/thong-ke-theo-xep-hang/{maCTBaiQH}/{maCanBo}', 'GVThongkeController@thong_ke_theo_xep_hang_doan');
                         Route::get('/get-xep-hang','GVThongkeController@get_xep_hang_doan');
                         Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}/{maCanBo}', 'GVThongkeController@thong_ke_theo_diem_chu_doan');
                         Route::get('/get-diem-chu','GVThongkeController@get_diem_chu_doan');
                         Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}/{maCanBo}', 'GVThongkeController@thong_ke_theo_tieu_chi_doan');
                         Route::get('/get-tieu-chi','GVThongkeController@get_tieu_chi_doan'); 
                         Route::get('/thong-ke-theo-abet/{maCTBaiQH}/{maCanBo}','GVThongkeController@thong_ke_theo_abet_doan');
                         Route::get('/get-abet','GVThongkeController@get_abet_doan');
                         Route::get('xuat-thong-ke-xep-hang/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_xep_hang_do_an');
                         Route::get('xuat-thong-ke-diem-chu/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_diem_chu_do_an');
                         Route::get('xuat-thong-ke-so/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_tieu_chi_do_an');
                         Route::get('xuat-thong-ke-abet/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_abet_do_an');
                         Route::get('xuat-thong-ke-clo/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_clo_do_an');
                    });
                    Route::prefix('khoa-luan')->group(function () {
                         Route::get('/thong-ke-theo-xep-hang-kl/{maCanBo}','GVThongkeController@thong_ke_theo_xep_hang_kl');
                         Route::get('/get-xep-hang-kl','GVThongkeController@get_xep_hang_kl');
                         Route::get('/thong-ke-theo-diem-chu-kl/{maCanBo}','GVThongkeController@thong_ke_theo_diem_chu_kl');
                         Route::get('/get-diem-chu-kl','GVThongkeController@get_diem_chu_kl');
                         Route::get('/thong-ke-theo-tieu-chi-kl/{maCanBo}','GVThongkeController@thong_ke_theo_tieu_chi_kl');
                         Route::get('/get-tieu-chi-kl','GVThongkeController@get_tieu_chi_kl');
                         
                    });
                    Route::prefix('thuc-hanh')->group(function () {

                        Route::get('thong-ke-theo-xep-hang/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_xep_hang_thuc_hanh');
                        Route::get('thong-ke-theo-xep-hang/{maCTBaiQH}/{macb2}', 'GVThongkeController@thong_ke_theo_xep_hang_thuc_hanh2');

                        Route::get('get-xep-hang','GVThongkeController@get_xep_hang_thuc_hanh');
                        Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_diem_chu_thuc_hanh');
                        Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}/{macb2}', 'GVThongkeController@thong_ke_theo_diem_chu_thuc_hanh2');

                        Route::get('/get-diem-chu','GVThongkeController@get_diem_chu_thuc_hanh');
                        Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_tieu_chi_thuc_hanh');
                        Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}/{maCB}', 'GVThongkeController@thong_ke_theo_tieu_chi_thuc_hanh2');

                        Route::get('/get-tieu-chi','GVThongkeController@get_tieu_chi_thuc_hanh'); 
                        #/giang-vien/thong-ke/thong-ke-theo-hoc-phan/thuc-hanh/thong-ke-theo-abet/1
                        Route::get('/thong-ke-theo-abet/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_abet_thuc_hanh');
                        Route::get('/thong-ke-theo-abet/{maCTBaiQH}/{maCB}', 'GVThongkeController@thong_ke_theo_abet_thuc_hanh2');

                        Route::get('/get-abet','GVThongkeController@get_abet_thuc_hanh'); 
                        Route::get('thong-ke-theo-clo/{maCTBaiQH}','GVThongkeController@thong_ke_theo_qkht_thuc_hanh');
                        Route::get('thong-ke-theo-clo/{maCTBaiQH}/{loaiCB}','GVThongkeController@thong_ke_theo_clo_thuc_hanh_cuoi1');
                        Route::get('thong-ke-theo-clo2/{maCTBaiQH}/{maCB}','GVThongkeController@thong_ke_theo_clo_thuc_hanh_cuoi2');

                        Route::get('get-clo','GVThongkeController@get_kqht_thuc_hanh');
                        Route::get('xuat-thong-ke-xep-hang/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_xep_hang_thuc_hanh');
                        Route::get('xuat-thong-ke-diem-chu/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_diem_chu_thuc_hanh');
                        Route::get('xuat-thong-ke-so/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_tieu_chi_thuc_hanh');
                        Route::get('xuat-thong-ke-abet/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_abet_thuc_hanh');
                        Route::get('xuat-thong-ke-clo/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_clo_thuc_hanh');
                    }); 
                    Route::prefix('tu-luan')->group(function () {
                        Route::get('thong-ke-theo-clo/{maCTBaiQH}','GVThongkeController@thong_ke_theo_qkht_tu_luan');
                        Route::get('get-clo','GVThongkeController@get_kqht_tu_luan');
                        Route::get('thong-ke-theo-xep-hang/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_xep_hang_tu_luan');
                        Route::get('get-xep-hang','GVThongkeController@get_xep_hang_tu_luan');
                        Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_diem_chu_tu_luan');
                        Route::get('/get-diem-chu','GVThongkeController@get_diem_chu_tu_luan');
                        Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_tieu_chi_tu_luan');
                        Route::get('/get-tieu-chi','GVThongkeController@get_tieu_chi_tu_luan'); 
                        Route::get('/thong-ke-theo-abet/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_abet_tu_luan');
                        Route::get('/get-abet','GVThongkeController@get_abet_tu_luan'); 
                        Route::get('xuat-thong-ke-xep-hang/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_xep_hang_tu_luan');
                        Route::get('xuat-thong-ke-diem-chu/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_diem_chu_tu_luan');
                        Route::get('xuat-thong-ke-so/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_tieu_chi_tu_luan');
                        Route::get('xuat-thong-ke-abet/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_abet_tu_luan');
                        Route::get('xuat-thong-ke-clo/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_clo_tu_luan');
                      
                    });
                    Route::prefix('trac-nghiem')->group(function () {
                         Route::get('thong-ke-theo-xep-hang/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_xep_hang_trac_nghiem');
                         Route::get('get-xep-hang','GVThongkeController@get_xep_hang_trac_nghiem');
                         Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_diem_chu_trac_nghiem');
                         Route::get('/get-diem-chu','GVThongkeController@get_diem_chu_trac_nghiem');
                         Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_tieu_chi_trac_nghiem');
                         Route::get('/get-tieu-chi','GVThongkeController@get_tieu_chi_trac_nghiem'); 
                         Route::get('/thong-ke-theo-abet/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_abet_trac_nghiem');
                         Route::get('/get-abet','GVThongkeController@get_abet_trac_nghiem'); 
                         Route::get('thong-ke-theo-clo/{maCTBaiQH}','GVThongkeController@thong_ke_theo_kqht_trac_nghiem');
                         Route::get('get-clo','GVThongkeController@get_kqht_trac_nghiem');
                         Route::get('xuat-thong-ke-xep-hang/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_xep_hang_trac_nghiem');
                         Route::get('xuat-thong-ke-diem-chu/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_diem_chu_trac_nghiem');
                         Route::get('xuat-thong-ke-tieu-chi/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_tieu_chi_trac_nghiem');
                         Route::get('xuat-thong-ke-abet/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_abet_trac_nghiem');
                         Route::get('xuat-thong-ke-clo/{maCTBaiQH}','GVThongkeController@export_thong_ke_theo_clo_trac_nghiem');
                     });
               });


               Route::prefix('thong-ke-theo-nam-hoc')->group(function () {
                   #/giang-vien/thong-ke/thong-ke-theo-nam-hoc/abet/2020-2021
                    Route::get('abet/{namHoc}','GVThongKeNamController@gv_thong_ke_abet_theo_nam');
                   #/giang-vien/thong-ke/thong-ke-theo-nam-hoc/so/2020-2021
                   Route::get('so/{namHoc}','GVThongKeNamController@gv_thong_ke_so_theo_nam');
               });

               Route::get('thong-ke-ket-thuc-mon-theo-cdio/{maBaiQH}/{maHocPhan}', 'GVThongKeHetMonController@cdio');
               # /giang-vien/thong-ke/thong-ke-ket-thuc-mon-theo-abet/245/220103_140
               Route::get('thong-ke-ket-thuc-mon-theo-abet/{maBaiQH}/{maHocPhan}', 'GVThongKeHetMonController@abet');

               Route::prefix('xuat-ket-qua-thong-ke-theo-nam-hoc')->group(function () {
                    Route::get('abet/{namHoc}','GVThongKeNamController@gv_export_thong_ke_abet_theo_nam');
                    Route::get('so/{namHoc}','GVThongKeNamController@gv_export_thong_ke_so_theo_nam');
                });
          });

          //bien soan de cuong
          Route::prefix('bien-soan-de-cuong')->group(function () {
            Route::get('/','GVBienSoanDeCuongController@index');
            Route::get('/chinh-de-cuong/{maHocPhan}','GVBienSoanDeCuongController@de_cuong_mon_hoc');
            Route::get('/in-de-cuong-mon-hoc/{maHocPhan}','AdWordController@in_de_cuong_mon_hoc');
            Route::get('/xoa-ket-qua-hoc-tap-mon-hoc/{maKQHT}','GVBienSoanDeCuongController@xoa_ket_qua_hoc_tap_mon_hoc');
            
            //---------chuan dau ra-----------------------------------------------------------------------------
            Route::post('/them_chuan_dau_ra_mon_hoc','GVBienSoanDeCuongController@them_chuan_dau_ra_mon_hoc');
            Route::post('/sua_chuan_dau_ra_mon_hoc','GVBienSoanDeCuongController@sua_chuan_dau_ra_mon_hoc');
            Route::get('/xoa_chuan_dau_ra_mon_hoc/{id}','GVBienSoanDeCuongController@xoa_chuan_dau_ra_mon_hoc');
            Route::post('them-ket-qua-hoc-tap-chuan-dau-ra','GVBienSoanDeCuongController@them_ket_qua_hoc_tap_chuan_dau_ra');
            //
            Route::post('/sua_mo_ta_mon_hoc','GVBienSoanDeCuongController@them_mo_ta_hoc_phan');
            Route::post('/sua_yeu_cau_mon_hoc','GVBienSoanDeCuongController@them_yeu_cau_hoc_phan');
            
            //------------2-tai lieu tham khao-------------------------------------------------------------------
            Route::post('/sua_giao_trinh','GVBienSoanDeCuongController@them_giao_trinh');
            Route::get('/xoa_giao_trinh/{id}','GVBienSoanDeCuongController@xoa_giao_trinh');
            Route::post('/sua_tai_lieu_tham_khao_them','GVBienSoanDeCuongController@them_tai_lieu_tham_khao_them');
            Route::get('/xoa_tai_lieu_tham_khao/{id}','GVBienSoanDeCuongController@xoa_tai_lieu_tham_khao');
            Route::post('/sua_tai_lieu_khac','GVBienSoanDeCuongController@them_tai_lieu_khac');
            Route::get('/xoa_tai_lieu_khac/{id}','GVBienSoanDeCuongController@xoa_tai_lieu_khac');

            //-----------phuong phap giang day------------------------------------------------------------------
            Route::post('/them_phuong_phap_giang_day','GVBienSoanDeCuongController@them_phuong_phap_giang_giay');
            Route::get('/xoa-phuong-phan-giang-day/{id}','GVPhanBienDeCuongController@xoa_phuong_phap_giang_giay');
            Route::post('/them_mon_tien_quyet','GVBienSoanDeCuongController@them_mon_tien_quyet');
            Route::get('/xoa-mon-tien-quyet/{id}','GVPhanBienDeCuongController@xoa_mon_tien_quyet');
            Route::post('/them_muc_do_ky_nang_uti','GVBienSoanDeCuongController@them_muc_do_ky_nang_uti');
            Route::get('/xoa_muc_do_ky_nang_uti/{id}','GVBienSoanDeCuongController@xoa_muc_do_ky_nang_uti');
            //----------noi dung mon hoc------------------------------------------------------------------------- 
            //-----------hoc phan kqhts
            Route::post('/them-chuong-ket-qua-hoc-tap','GVBienSoanDeCuongController@them_chuong_kqht');
            Route::get('/xoa-chuong-ket-qua-hoc-tap/{machuong}/{maKQHT}','GVBienSoanDeCuongController@xoa_chuong_kqht');
            
            //-----------chuong
            Route::post('/them_noi_dung_mon_hoc','GVBienSoanDeCuongController@them_noi_dung_mon_hoc');
            Route::post('/sua-noi-dung-mon-hoc','GVBienSoanDeCuongController@sua_noi_dung_mon_hoc');
            Route::get('/xoa-noi-dung-mon-hoc/{id}','GVBienSoanDeCuongController@xoa_noi_dung_mon_hoc');
            
            //-----------muc
            Route::post('/them_noi_dung_muc_chuong','GVBienSoanDeCuongController@them_muc');
            Route::post('/sua_noi_dung_muc_chuong','GVBienSoanDeCuongController@sua_muc');
            Route::get('/xoa_noi_dung_muc_chuong/{id}','GVBienSoanDeCuongController@xoa_muc');

            //------------phuong thuc danh gia----------------------------------------------------
            Route::post('/them_phuong_phap_danh_gia','GVBienSoanDeCuongController@them_hoc_phan_loaiHTDG');
            Route::post('/sua_phuong_phap_danh_gia', 'GVBienSoanDeCuongController@sua_hoc_phan_loaiHTDG');
            Route::get('/xoa_phuong_phap_danh_gia/{id}', 'GVBienSoanDeCuongController@xoa_hoc_phan_loaiHTDG');

            Route::post('/them_hocphan_loaihtdg_kqht','GVBienSoanDeCuongController@them_hocphan_loaihtdg_kqht');
            Route::get('/xoa_hocphan_loaihtdg_kqht/{id}', 'GVBienSoanDeCuongController@xoa_hocphan_loaihtdg_kqht');

            Route::get('/{maHocPhan}','GVBienSoanDeCuongController@de_cuong_mon_hoc');
          });

          //phan bien de cuong
          Route::prefix('phan-bien-de-cuong')->group(function () {
            Route::get('/','GVPhanBienDeCuongController@index');
            Route::get('/chinh-de-cuong/{maHocPhan}','GVPhanBienDeCuongController@de_cuong_mon_hoc');
            Route::get('/in-de-cuong-mon-hoc/{maHocPhan}','AdWordController@in_de_cuong_mon_hoc');
            Route::get('/xoa-ket-qua-hoc-tap-mon-hoc/{maKQHT}','GVPhanBienDeCuongController@xoa_ket_qua_hoc_tap_mon_hoc');
            
            //---------chuan dau ra-----------------------------------------------------------------------------
            Route::post('/them_chuan_dau_ra_mon_hoc','GVPhanBienDeCuongController@them_chuan_dau_ra_mon_hoc');
            Route::post('/sua_chuan_dau_ra_mon_hoc','GVPhanBienDeCuongController@sua_chuan_dau_ra_mon_hoc');
            Route::get('/xoa_chuan_dau_ra_mon_hoc/{id}','GVPhanBienDeCuongController@xoa_chuan_dau_ra_mon_hoc');
            Route::post('them-ket-qua-hoc-tap-chuan-dau-ra','GVPhanBienDeCuongController@them_ket_qua_hoc_tap_chuan_dau_ra');
            //
            Route::post('/sua_mo_ta_mon_hoc','GVPhanBienDeCuongController@them_mo_ta_hoc_phan');
            Route::post('/sua_yeu_cau_mon_hoc','GVPhanBienDeCuongController@them_yeu_cau_hoc_phan');
            
            //------------2-tai lieu tham khao-------------------------------------------------------------------
            Route::post('/sua_giao_trinh','GVPhanBienDeCuongController@them_giao_trinh');
            Route::get('/xoa_giao_trinh/{id}','GVPhanBienDeCuongController@xoa_giao_trinh');
            Route::post('/sua_tai_lieu_tham_khao_them','GVPhanBienDeCuongController@them_tai_lieu_tham_khao_them');
            Route::get('/xoa_tai_lieu_tham_khao/{id}','GVPhanBienDeCuongController@xoa_tai_lieu_tham_khao');
            Route::post('/sua_tai_lieu_khac','GVPhanBienDeCuongController@them_tai_lieu_khac');
            Route::get('/xoa_tai_lieu_khac/{id}','GVPhanBienDeCuongController@xoa_tai_lieu_khac');

            //-----------phuong phap giang day------------------------------------------------------------------
            Route::post('/them_phuong_phap_giang_day','GVPhanBienDeCuongController@them_phuong_phap_giang_giay');
            Route::get('/xoa-phuong-phan-giang-day/{id}','GVPhanBienDeCuongController@xoa_phuong_phap_giang_giay');
            Route::post('/them_mon_tien_quyet','GVPhanBienDeCuongController@them_mon_tien_quyet');
            Route::get('/xoa-mon-tien-quyet/{id}','GVPhanBienDeCuongController@xoa_mon_tien_quyet');
            Route::post('/them_muc_do_ky_nang_uti','GVPhanBienDeCuongController@them_muc_do_ky_nang_uti');
            Route::get('/xoa_muc_do_ky_nang_uti/{id}','GVPhanBienDeCuongController@xoa_muc_do_ky_nang_uti');
            //----------noi dung mon hoc------------------------------------------------------------------------- 
            //-----------hoc phan kqhts
            Route::post('/them-chuong-ket-qua-hoc-tap','GVPhanBienDeCuongController@them_chuong_kqht');
            Route::get('/xoa-chuong-ket-qua-hoc-tap/{machuong}/{maKQHT}','GVPhanBienDeCuongController@xoa_chuong_kqht');
            
            //-----------chuong
            Route::post('/them_noi_dung_mon_hoc','GVPhanBienDeCuongController@them_noi_dung_mon_hoc');
            Route::post('/sua-noi-dung-mon-hoc','GVPhanBienDeCuongController@sua_noi_dung_mon_hoc');
            Route::get('/xoa-noi-dung-mon-hoc/{id}','GVPhanBienDeCuongController@xoa_noi_dung_mon_hoc');
            
            //-----------muc
            Route::post('/them_noi_dung_muc_chuong','GVPhanBienDeCuongController@them_muc');
            Route::post('/sua_noi_dung_muc_chuong','GVPhanBienDeCuongController@sua_muc');
            Route::get('/xoa_noi_dung_muc_chuong/{id}','GVPhanBienDeCuongController@xoa_muc');

            //------------phuong thuc danh gia----------------------------------------------------
            Route::post('/them_phuong_phap_danh_gia','GVPhanBienDeCuongController@them_hoc_phan_loaiHTDG');
            Route::post('/sua_phuong_phap_danh_gia', 'GVPhanBienDeCuongController@sua_hoc_phan_loaiHTDG');
            Route::get('/xoa_phuong_phap_danh_gia/{id}', 'GVPhanBienDeCuongController@xoa_hoc_phan_loaiHTDG');

            Route::post('/them_hocphan_loaihtdg_kqht','GVPhanBienDeCuongController@them_hocphan_loaihtdg_kqht');
            Route::get('/xoa_hocphan_loaihtdg_kqht/{id}', 'GVPhanBienDeCuongController@xoa_hocphan_loaihtdg_kqht');

            Route::get('/{maHocPhan}','GVPhanBienDeCuongController@de_cuong_mon_hoc');
          });
          
     });
});
   