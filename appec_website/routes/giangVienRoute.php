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
                         
                        //thêm sửa câu hỏi tự luận
                        Route::get('/cau-hoi-tu-luan/{maMuc}','GVMucController@cau_hoi_tu_luan');
                        Route::post('/cau-hoi-tu-luan/them','GVMucController@them_tu_luan');
                        Route::post('/cau-hoi-tu-luan/sua','GVMucController@sua_tu_luan');
                        Route::get('/cau-hoi-tu-luan/xoa/{maCauHoi}','GVMucController@xoa_tu_luan');
                        Route::get('/get-cau-hoi-tu-luan-by-mamuc/{maMuc}','GVMucController@get_cau_hoi_tu_luan_by_mamuc');
                        //thêm sửa câu hỏi trắc nghiệm
                        Route::get('/get-cau-hoi-trac-nghiem-by-mamuc/{maMuc}','GVMucController@get_cau_hoi_trac_nghiem_by_mamuc');
                        Route::get('/cau-hoi-trac-nghiem/{maMuc}','GVMucController@cau_hoi_trac_nghiem');
                        Route::get('/them-cau-hoi-trac-nghiem/?maMuc={maMuc}','GVMucController@view_them_trac_nghiem');
                       
                        Route::post('/cau-hoi-trac-nghiem/them','GVMucController@them_trac_nghiem');
                        Route::post('/cau-hoi-trac-nghiem/sua','GVMucController@sua_trac_nghiem');
                        //thêm sửa câu hỏi thực hành
                        Route::get('/get-cau-hoi-thuc-hanh-by-mamuc/{maMuc}','GVMucController@get_cau_hoi_thuc_hanh_by_mamuc');
                        Route::get('/cau-hoi-thuc-hanh/{maMuc}','GVMucController@cau_hoi_thuc_hanh');
                        Route::post('/cau-hoi-thuc-hanh/them','GVMucController@them_thuc_hanh');
                        Route::post('/cau-hoi-thuc-hanh/sua','GVMucController@sua_thuc_hanh');
                        Route::get('/cau-hoi-thuc-hanh/xoa/{maCauHoi}','GVMucController@xoa_thuc_hanh');
                        //xem - muc 
                        Route::get('/{maChuong}','GVMucController@index');
                        Route::get('/get-muc-by-machuong/{maChuong}','GVMucController@get_muc_by_ma_chuong');
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
               Route::post('/loc','quyhoachController@filter');
               Route::get('/quy-hoach-ket-qua/{maHocPhan}/{maBaiQH}/{maHK}/{namHoc}/{maLop}', 'quyhoachController@quy_hoach_ket_qua_hoc_tap');
               Route::post('/them-quy-hoach', 'quyhoachController@them_quy_hoach');
               Route::post('/chon-nhom-cong-thuc','quyhoachController@chon_nhom_cong_thuc');
               

               //nội dung quy hoạch
               Route::group(['prefix' => 'noi-dung-quy-hoach'], function () {
                    Route::get('/{maCTBaiQH}','quyhoachController@noi_dung_quy_hoach');
                    Route::post('/them-noi-dung-quy-hoach-submit','quyhoachController@them_noi_dung_quy_hoach');
                    Route::post('/sua-noi-dung-quy-hoach-submit','quyhoachController@sua_noi_dung_quy_hoach');
                    Route::get('/xoa-noi-dung-quy-hoach/{maNoiDungQH}','quyhoachController@sua_noi_dung_quy_hoach_submit');
                    Route::get('/chuong/{maNoiDungQH}','quyhoachController@chuong_noidungqh');
                    Route::post('/chuong/them-chuong-noi-dung-quy-hoach', 'quyhoachController@them_chuong_ndqh');
                    Route::get('them-cau-hoi-tu-luan', 'quyhoachController@them_cau_hoi_tu_luan');
               });

               //nội dung đánh giá
               Route::group(['prefix' => 'noi-dung-danh-gia'], function () {

                    Route::get('/xem-tieu-chi-danh-gia/{maCTBaiQH}', 'quyhoachController@xem_tieu_chi_danh_gia');
                    Route::post('/sua-tieu-chi-danh-gia','quyhoachController@sua_abet_tieu_chi_danh_gia');
                    Route::post('/sua-chuan-abet','quyhoachController@sua_abet_tieu_chi_danh_gia');
                    Route::get('/them-de-thi-tu-luan','quyhoachController@them_de_thi_tu_luan');
                    Route::get('/them-de-thi-trac-nghiem','quyhoachController@them_de_thi_trac_nghiem');

                    Route::get('/them-tieu-chi-danh-gia/{maTCBaiQH}', 'quyhoachController@them_tieu_chi_danh_gia');
                    Route::get('/get-tieu-chuan-by-NDQH/{maNoiDungQH}','quyhoachController@get_tieu_chuan_by_NDQH');
                    Route::post('/them-tieu-chi-submit','quyhoachController@them_tieu_chi_danh_gian_submit');
                    Route::post('/them-tieu-chuan','quyhoachController@them_tieu_chuan_submit');
                    Route::post('/moi-cham-bao-cao','quyhoachController@moi_cham_bao_cao');
                    Route::post('/them-phieu-cham','quyhoachController@them_phieu_cham');
                    Route::post('/them-de-tai','quyhoachController@them_de_tai');
                    Route::get('xoa-phieu-cham-do-an/{maDe}/{maSSV}','quyhoachController@xoa_phieu_cham');
                    Route::post('sua-ten-de-tai', 'quyhoachController@sua_ten_de_tai');

                    //thi tự luận
                    Route::post('/them-de-thi-tu-luan-submit', 'quyhoachController@them_de_thi_tu_luan_submit');
                    //thi thực hành
                    Route::post('/them-de-thi-thuc-hanh-submit', 'quyhoachController@them_de_thi_thuc_hanh_submit');
                    //thi trắc nghiệm
                    Route::post('/them-de-thi-trac-nghiem-submit','quyhoachController@them_de_thi_trac_nghiem_submit');

                    //ngân hàng câu hỏi trắc nghiệm
                    Route::prefix('ngan-hang-cau-hoi-trac-nghiem')->group(function () {
                         //them
                         Route::post('/them-cau-hoi-submit','GVMucController@them_trac_nghiem');
                         Route::get('/them-cau-hoi','GVMucController@view_them_trac_nghiem');
                         //sua
                         Route::get('/sua-cau-hoi/{maCauHoi}','GVMucController@view_sua_trac_nghiem');
                         Route::post('/sua-cau-hoi-submit','GVMucController@sua_trac_nghiem');
                         //xoa
                         Route::get('/xoa-cau-hoi/{maCauHoi}','GVMucController@xoa_trac_nghiem');
                         //hien thi
                         Route::get('/{id_muc}','GVMucController@cau_hoi_trac_nghiem');
                    });

                    //ngan hang cau hoi tu luan

                    //ngan hag cau hoi thuc hanh
                    
                    Route::prefix('xem-noi-dung-danh-gia')->group(function () {
                         //ngân hàng câu hỏi
                         Route::get('ngan-hang-cau-hoi', 'GVChuongController@ngan_hang_cau_hoi');
                         //tự luận
                         Route::get('/cau-truc-de-tu-luan/{maDe}', 'quyhoachController@cau_truc_de_luan'); //
                         Route::post('/them-cau-hoi-de-luan','quyhoachController@them_cau_hoi_de_luan'); //
                         Route::get('/in-de-tu-luan/{maDe}/{maHocPhan}','GVWordController@in_de_thi_tu_luan');
                         Route::get('/xoa-cau-hoi-de-tu-luan/{maDe}/{maCauHoi}','quyhoachController@xoa_cau_hoi_de_tu_luan');
                         Route::post('sua-phuong-an-tu-luan', 'quyhoachController@chinh_sua_phuong_an_tu_luan');
                         //thực hành
                         Route::get('/cau-truc-de-thuc-hanh/{maDe}', 'quyhoachController@cau_truc_de_thuc_hanh');
                         Route::get('/xoa-de-thuc-hanh/{maDe}','quyhoachController@xoa_de_thuc_hanh');
                         Route::post('/them-cau-hoi-de-thuc-hanh','quyhoachController@them_cau_hoi_de_thuc_hanh'); //
                         Route::get('/in-de-thuc-hanh/{maDe}/{maHocPhan}','GVWordController@in_de_thi_thuc_hanh');
                         Route::get('/xoa-cau-hoi-de-thuc-hanh/{maDe}/{maCauHoi}','quyhoachController@xoa_cau_hoi_de_thuc_hanh');
                         Route::post('sua-phuong-an-thuc-hanh', 'quyhoachController@chinh_sua_phuong_an_thuc_hanh');
                         //trắc nghiệm
                         Route::get('/cau-truc-de-trac-nghiem/{maDe}','quyhoachController@cau_truc_de_trac_nghiem');
                         Route::post('/them-cau-hoi-trac-nghiem','quyhoachController@them_cau_hoi_de_trac_nghiem');
                         Route::get('/in-de-trac-nghiem/{maDe}/{maHocPhan}','GVWordController@in_de_thi_trac_nghiem');
                         Route::get('/xoa-cau-hoi-trac-nghiem/{maCauHoi}','quyhoachController@xoa_cau_hoi_de_trac_nghiem');
                         //xem nội dung
                         Route::get('/{maCTBaiQH}', 'quyhoachController@xem_noi_dung_danh_gia');
                    });
               }); 
           });
         

           //cham diem bao cao
          
           Route::group(['prefix' => 'cham-diem-bao-cao'], function () {
               Route::get('/', 'chamDiemBCController@index');
               Route::get('/noi-dung-danh-gia/{maBaiQH}/{maHocPhan}','chamDiemBCController@noi_dung_danh_gia');
               Route::get('/nhap-ket-qua-danh-gia/{maCTBaiQH}', 'chamDiemBCController@nhap_ket_qua_danh_gia');
               Route::get('/nhap-diem-do-an/{maDe}/{maSSV}', 'chamDiemBCController@nhap_diem_do_an');
               Route::post('/cham-diem-submit', 'chamDiemBCController@cham_diem_submit');
               Route::get('/xem-ket-qua-danh-gia/{maPhieuCham}','chamDiemBCController@xem_ket_qua_danh_gia');
          });

          //ket qua danh gia
          Route::group(['prefix' => 'ket-qua-danh-gia'], function () {
               Route::get('/', 'ketQuaDanhGiaController@index');
               Route::get('/ket-qua-hoc-phan/{maHocPhan}/{maBaiQH}/{maHK}/{namHoc}/{maLop}', 'ketQuaDanhGiaController@chi_tiet_quy_hoach_kq_qua_danh_gia');
               Route::get('/nhap-ket-qua-danh-gia/{maCTBaiQH}', 'ketQuaDanhGiaController@nhap_ket_qua_danh_gia');
               Route::get('/nhap-diem-do-an/{maDe}/{maSSV}', 'ketQuaDanhGiaController@nhap_diem_do_an');
               Route::post('/cham-diem-submit','ketQuaDanhGiaController@cham_diem_submit');
               Route::get('/xem-ket-qua-danh-gia/{maDe}/{maSSV}/{maCanBo}', 'ketQuaDanhGiaController@xem_ket_qua_danh_gia');
               
               Route::prefix('thuc-hanh')->group(function () {
                   Route::post('/them-mot-phieu-cham', 'ketQuaDanhGiaController@them_mot_phieu_cham_thuc_hanh');
                   Route::post('/them-nhieu-phieu-cham', 'ketQuaDanhGiaController@them_nhieu_phieu_cham_thuc_hanh');
                   Route::get('/nhap-diem-thuc-hanh/{maDe}/{maSSV}', 'ketQuaDanhGiaController@nhap_diem_thuc_hanh');
                   Route::post('/cham-diem-submit', 'ketQuaDanhGiaController@cham_diem_thuc_hanh_submit');
                   Route::get('/xem-ket-qua-danh-gia-thuc-hanh/{maDe}/{maSSV}', 'ketQuaDanhGiaController@xem_ket_qua_thuc_hanh');
               });

               Route::prefix('tu-luan')->group(function () {
                    Route::post('/them-mot-phieu-cham', 'ketQuaDanhGiaController@them_mot_phieu_cham_tu_luan');
                    Route::post('/them-nhieu-phieu-cham', 'ketQuaDanhGiaController@them_nhieu_phieu_cham_tu_luan');
                    Route::get('/nhap-diem-tu-luan/{maDe}/{maSSV}', 'ketQuaDanhGiaController@nhap_diem_tu_luan');
                    Route::post('/cham-diem-submit', 'ketQuaDanhGiaController@cham_diem_tu_luan_submit');
                    Route::get('/xem-ket-qua-danh-gia-tu-luan/{maDe}/{maSSV}', 'ketQuaDanhGiaController@xem_ket_qua_tu_luan');
               });

               Route::prefix('trac-nghiem')->group(function () {
                    Route::post('/them-mot-phieu-cham', 'ketQuaDanhGiaController@them_mot_phieu_cham_trac_nghiem');
                    Route::post('/them-nhieu-phieu-cham', 'ketQuaDanhGiaController@them_nhieu_phieu_cham_trac_nghiem');
                    Route::get('/nhap-diem-trac-nghiem/{maDe}/{maSSV}', 'ketQuaDanhGiaController@nhap_diem_trac_nghiem');
                    Route::post('/cham-diem-submit', 'ketQuaDanhGiaController@cham_diem_trac_nghiem_submit');
                    Route::get('/xem-ket-qua-danh-gia-trac-nghiem/{maDe}/{maSSV}','ketQuaDanhGiaController@xem_ket_qua_trac_nghiem');
               });
          });

            //thong ke
          Route::group(['prefix' => 'thong-ke'], function () {
               Route::group(['prefix' => 'thong-ke-theo-hoc-phan'], function () {            
                    Route::get('/{maGV}/{maHocPhan}/{maHK}/{namHoc}/{maLop}', 'GVThongkeController@thong_ke_theo_hoc_phan');
                    
                    Route::prefix('do-an')->group(function () {
                         Route::get('/thong-ke-theo-xep-hang/{maCTBaiQH}/{maCanBo}', 'GVThongkeController@thong_ke_theo_xep_hang_doan');
                         Route::get('/get-xep-hang','GVThongkeController@get_xep_hang_doan');
                         Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}/{maCanBo}', 'GVThongkeController@thong_ke_theo_diem_chu_doan');
                         Route::get('/get-diem-chu','GVThongkeController@get_diem_chu_doan');
                         Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}/{maCanBo}', 'GVThongkeController@thong_ke_theo_tieu_chi_doan');
                         Route::get('/get-tieu-chi','GVThongkeController@get_tieu_chi_doan'); 
                         Route::get('/thong-ke-theo-abet/{maCTBaiQH}/{maCanBo}','GVThongkeController@thong_ke_theo_abet_doan');
                         Route::get('/get-abet','GVThongkeController@get_abet_doan');
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
                        Route::get('get-xep-hang','GVThongkeController@get_xep_hang_thuc_hanh');
                        Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_diem_chu_thuc_hanh');
                        Route::get('/get-diem-chu','GVThongkeController@get_diem_chu_thuc_hanh');
                        Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_tieu_chi_thuc_hanh');
                        Route::get('/get-tieu-chi','GVThongkeController@get_tieu_chi_thuc_hanh'); 
                        Route::get('/thong-ke-theo-abet/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_abet_thuc_hanh');
                        Route::get('/get-abet','GVThongkeController@get_abet_thuc_hanh'); 
                        Route::get('thong-ke-theo-kqht/{maCTBaiQH}','GVThongkeController@thong_ke_theo_kqht_thuc_hanh');
                        Route::get('get-kqht','GVThongkeController@get_kqht_thuc_hanh');
                    }); 
                    Route::prefix('tu-luan')->group(function () {
                        Route::get('thong-ke-theo-xep-hang/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_xep_hang_tu_luan');
                        Route::get('get-xep-hang','GVThongkeController@get_xep_hang_tu_luan');
                        Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_diem_chu_tu_luan');
                        Route::get('/get-diem-chu','GVThongkeController@get_diem_chu_tu_luan');
                        Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_tieu_chi_tu_luan');
                        Route::get('/get-tieu-chi','GVThongkeController@get_tieu_chi_tu_luan'); 
                        Route::get('/thong-ke-theo-abet/{maCTBaiQH}', 'GVThongkeController@thong_ke_theo_abet_tu_luan');
                        Route::get('/get-abet','GVThongkeController@get_abet_tu_luan'); 
                        Route::get('thong-ke-theo-kqht/{maCTBaiQH}','GVThongkeController@thong_ke_theo_kqht_tu_luan');
                        Route::get('get-kqht','GVThongkeController@get_kqht_tu_luan');
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
                         Route::get('thong-ke-theo-kqht/{maCTBaiQH}','GVThongkeController@thong_ke_theo_kqht_trac_nghiem');
                         Route::get('get-kqht','GVThongkeController@get_kqht_trac_nghiem');
                     });
               });
          });
     });
});
   