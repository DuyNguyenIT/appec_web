<?php

use Illuminate\Support\Facades\Route;

Route::group(['middleware' =>'App\Http\Middleware\isAdmin'], function (){ 
    
    Route::group(['prefix' => 'quan-ly','namespace'=>'App\Http\Controllers\Admin'], function () {
    Route::post('ckeditor/image_upload', 'GVCKEditorController@upload')->name('upload');
    Route::get('/', 'homeController@index');
    
    //bac đao tao
    Route::group(['prefix' => 'bac-dao-tao'], function () {
        Route::get('/', 'bacDaoTaoController@index');
        Route::post('them', 'bacDaoTaoController@them');
        Route::post('sua', 'bacDaoTaoController@sua');
        Route::get('xoa/{maBac}', 'bacDaoTaoController@xoa');
    });

    //nganh học
    Route::group(['prefix' => 'nganh-hoc'], function () {
        Route::get('/', 'nganhController@index');
        Route::post('them', 'nganhController@them');
        Route::post('sua/', 'nganhController@sua');
        Route::get('xoa/{maNganh}', 'nganhController@xoa');
    });

    //PTTMai them
    //chuyen nganh
    Route::group(['prefix' => 'chuyen-nganh'], function () {
        Route::get('/', 'cNganhController@index');
        Route::post('them', 'cNganhController@them');
        Route::post('sua', 'cNganhController@sua');
        Route::get('xoa/{maCNganh}', 'cNganhController@xoa');
    });

    //Het PTTMai them
    //he
    Route::group(['prefix' => 'he'], function () {
        Route::get('/', 'heController@index');
        Route::post('/them', 'heController@them');
        Route::post('/sua', 'heController@sua');
        Route::get('xoa/{maHe}', 'heController@xoa_he');
    });

    //chuong trinh dao tao
    Route::group(['prefix' => 'chuong-trinh-dao-tao'], function () {
        Route::get('/', 'chuongTrinhDTController@index');
        Route::post('them', 'chuongTrinhDTController@them');
        Route::post('sua', 'chuongTrinhDTController@sua');
        Route::get('xoa/{maCT}', 'chuongTrinhDTController@xoa');
        Route::get('/excel','chuongTrinhDTController@excel');
        
    });

    //xem chuong trinh dao tao
    Route::group(['prefix' => 'bien-soan-va-phan-bien-de-cuong'], function () {
        Route::get('/', 'xemChuongtrinhDTController@index');
        Route::post('/dieu-chinh-thoi-gian-bien-soan','xemChuongtrinhDTController@dieu_chinh_thoi_gian_soan_de_cuong');
        Route::prefix('xem-thong-tin-hoc-phan')->group(function () {
            Route::get('/{maHocPhan}', 'xemChuongtrinhDTController@xem_thong_tin_hoc_phan');
            Route::post('/them-bien-soan-de-cuong','xemChuongtrinhDTController@them_bien_soan_de_cuong');
            Route::post('/them-phan-bien-de-cuong','xemChuongtrinhDTController@them_phan_bien_de_cuong');
            Route::get('/xoa-bien-soan-de-cuong/{maGV}','xemChuongtrinhDTController@xoa_bien_soan_de_cuong');
            Route::get('/xoa-phan-bien-de-cuong/{maGV}','xemChuongtrinhDTController@xoa_phan_bien_de_cuong');
        });
    });
    
    //chuan dau ra
    Route::group(['prefix' => 'chuan-dau-ra'], function () {
        Route::get('/', 'chuanDauRaController@index');
        Route::post('them', 'chuanDauRaController@them_cdr_submit');
        Route::post('sua', 'chuanDauRaController@sua_cdr_submit');
        Route::get('xoa/{maCDR1}', 'chuanDauRaController@xoa_cdr_submit');
        Route::get('/chuan-dau-ra-2/{maCDR1}', 'chuanDauRaController@chuanDR2');
        Route::post('/chuan-dau-ra-2/them', 'chuanDauRaController@them_cdr2_submit');
        Route::post('/chuan-dau-ra-2/sua', 'chuanDauRaController@sua_cdr2_submit');
        Route::get('/chuan-dau-ra-2/xoa/{maCDR2}', 'chuanDauRaController@xoa_cdr2_submit');
        Route::get('/chuan-dau-ra-3/{maCDR2}', 'chuanDauRaController@chuanDR3');
        Route::post('/chuan-dau-ra-3/them', 'chuanDauRaController@them_cdr3_submit');
        Route::post('/chuan-dau-ra-3/sua', 'chuanDauRaController@sua_cdr3_submit');
        Route::get('/chuan-dau-ra-3/xoa/{maCDR3}', 'chuanDauRaController@xoa_cdr3_submit');
        // Route::post('sua/{id}', '');
        // Route::post('xoa/{id}', '');
    });

    //chuan dau ra 2 <-> abet
    Route::prefix('chuan-dau-ra2-abet')->group(function () {
        Route::get('/','AdCDR2_ABETController@index');
        Route::post('/them','AdCDR2_ABETController@them');
        Route::post('/sua','AdCDR2_ABETController@sua');
        Route::get('xoa/{id}','AdCDR2_ABETController@xoa');
    });

    //chuan dau ra 2 <-> abet
    Route::prefix('chuan-dau-ra3-abet')->group(function () {
        Route::get('/','AdCDR3_ABETController@index');
        Route::post('/them','AdCDR3_ABETController@them');
        Route::post('/sua','AdCDR3_ABETController@sua');
        Route::get('xoa/{id}','AdCDR3_ABETController@xoa');
    });

    //loai hoc phan
    Route::group(['prefix' => 'loai-hoc-phan'], function () {
        Route::get('/', 'loaiHocPhanController@index');
        Route::post('them', 'loaiHocPhanController@them');
        Route::post('sua', 'loaiHocPhanController@sua');
        Route::get('xoa/{maLoaiHocPhan}', 'loaiHocPhanController@xoa');
    });

    //bien soan de cuong
    Route::prefix('bien-soan-de-cuong')->group(function () {
        Route::get('/', 'AdBienSoanDeCuongController@index');
        Route::post('/them','AdBienSoanDeCuongController@them');
        Route::post('/sua','AdBienSoanDeCuongController@sua');
    });

    ///quan-ly/hoc-phan
    Route::group(['prefix' => 'hoc-phan'], function () {
        Route::get('/', 'hocPhanController@index');
        Route::post('them', 'hocPhanController@them');
        Route::post('sua', 'hocPhanController@sua');
        Route::post('them-hoc-phan-ctdt','hocPhanController@them_hoc_phan_ctdt');
        Route::get('xoa/{maHocPhan}', 'hocPhanController@xoa');
        //chuong trinh dao tao
        Route::get('/hoc-phan-ct-dao-tao/{mahocphan}','hocPhanController@hocphan_ctdtao');
        Route::post('/chinh-sua-hoc-phan-ct-dao-tao','hocPhanController@sua_hocphan_ctdtao');
        Route::get('/xoa-hoc-phan-ct-dao-tao/{id}','hocPhanController@xoa_hocphan_ctdtao');
        
        ///quan-ly/hoc-phan/de-cuong-mon-hoc/
        Route::prefix('/de-cuong-mon-hoc')->group(function () {
           
            Route::get('/in-de-cuong-mon-hoc/{maHocPhan}','AdWordController@in_de_cuong_mon_hoc');
            Route::get('/xoa-ket-qua-hoc-tap-mon-hoc/{maKQHT}','hocPhanController@xoa_ket_qua_hoc_tap_mon_hoc');
            
            //---------chuan dau ra-----------------------------------------------------------------------------
            Route::post('/them_chuan_dau_ra_mon_hoc','hocPhanController@them_chuan_dau_ra_mon_hoc');
            Route::post('/sua_chuan_dau_ra_mon_hoc','hocPhanController@sua_chuan_dau_ra_mon_hoc');
            Route::get('/xoa_chuan_dau_ra_mon_hoc/{id}','hocPhanController@xoa_chuan_dau_ra_mon_hoc');
            Route::post('them-ket-qua-hoc-tap-chuan-dau-ra','hocPhanController@them_ket_qua_hoc_tap_chuan_dau_ra');
            //
            Route::post('/sua_mo_ta_mon_hoc','hocPhanController@them_mo_ta_hoc_phan');
            Route::post('/sua_yeu_cau_mon_hoc','hocPhanController@them_yeu_cau_hoc_phan');
            
            //------------2-tai lieu tham khao-------------------------------------------------------------------
            Route::post('/sua_giao_trinh','hocPhanController@them_giao_trinh');
            Route::get('/xoa_giao_trinh/{id}','hocPhanController@xoa_giao_trinh');
            Route::post('/sua_tai_lieu_tham_khao_them','hocPhanController@them_tai_lieu_tham_khao_them');
            Route::get('/xoa_tai_lieu_tham_khao/{id}','hocPhanController@xoa_tai_lieu_tham_khao');
            Route::post('/sua_tai_lieu_khac','hocPhanController@them_tai_lieu_khac');
            Route::get('/xoa_tai_lieu_khac/{id}','hocPhanController@xoa_tai_lieu_khac');

            //-----------phuong phap giang day------------------------------------------------------------------
            Route::post('/them_phuong_phap_giang_day','hocPhanController@them_phuong_phap_giang_giay');
            Route::get('/xoa-phuong-phap-giang-day/{id}','hocPhanController@xoa_phuong_phap_giang_giay');
            Route::post('/them_mon_tien_quyet','hocPhanController@them_mon_tien_quyet');
            Route::get('/xoa-mon-tien-quyet/{id}','hocPhanController@xoa_mon_tien_quyet');
            Route::post('/them_muc_do_ky_nang_uti','hocPhanController@them_muc_do_ky_nang_uti');
            Route::get('/xoa_muc_do_ky_nang_uti/{id}','hocPhanController@xoa_muc_do_ky_nang_uti');
            //----------noi dung mon hoc------------------------------------------------------------------------- 
            //-----------hoc phan kqhts
            Route::post('/them-chuong-ket-qua-hoc-tap','hocPhanController@them_chuong_kqht');
            Route::get('/xoa-chuong-ket-qua-hoc-tap/{machuong}/{maKQHT}','hocPhanController@xoa_chuong_kqht');
            
            //-----------chuong
            Route::post('/them_noi_dung_mon_hoc','hocPhanController@them_noi_dung_mon_hoc');
            Route::post('/sua-noi-dung-mon-hoc','hocPhanController@sua_noi_dung_mon_hoc');
            Route::get('/xoa-noi-dung-mon-hoc/{id}','hocPhanController@xoa_noi_dung_mon_hoc');
            
            //-----------muc
            Route::post('/them_noi_dung_muc_chuong','hocPhanController@them_muc');
            Route::post('/sua_noi_dung_muc_chuong','hocPhanController@sua_muc');
            Route::get('/xoa_noi_dung_muc_chuong/{id}','hocPhanController@xoa_muc');

            //------------phuong thuc danh gia----------------------------------------------------
            Route::post('/them_phuong_phap_danh_gia','hocPhanController@them_hoc_phan_loaiHTDG');
            Route::post('/sua_phuong_phap_danh_gia', 'hocPhanController@sua_hoc_phan_loaiHTDG');
            Route::get('/xoa_phuong_phap_danh_gia/{id}', 'hocPhanController@xoa_hoc_phan_loaiHTDG');

            Route::post('/them_hocphan_loaihtdg_kqht','hocPhanController@them_hocphan_loaihtdg_kqht');
            Route::get('/xoa_hocphan_loaihtdg_kqht/{id}', 'hocPhanController@xoa_hocphan_loaihtdg_kqht');

            Route::get('/{maHocPhan}','hocPhanController@de_cuong_mon_hoc');
        });

        // Route::post('sua/{id}', '');
        // Route::post('xoa/{id}', '');\

    });

    //khoi kien thuc
    Route::group(['prefix' => 'khoi-kien-thuc'], function () {
        Route::get('/', 'khoiKienThucController@index');
        Route::post('them', 'khoiKienThucController@them');
        Route::post('sua', 'khoiKienThucController@sua');
        Route::get('xoa/{maKhoiKT}', 'khoiKienThucController@xoa');
    });

    //phuong phap giang day
    Route::group(['prefix' => 'phuong-phap-giang-day'], function () {
        Route::get('/', 'ppGiangDayController@index');
        Route::post('/them', 'ppGiangDayController@them');
        Route::post('/sua', 'ppGiangDayController@sua');
        // Route::post('xoa/{id}', '');
    });

    //quan ly tai khoan
    Route::prefix('tai-khoan')->group(function () {
        Route::get('/','AdAccountController@index');
        Route::post('/them', 'AdAccountController@them');
        Route::post('/sua', 'AdAccountController@sua');
        Route::get('/xoa/{username}','AdAccountController@xoa');
        Route::get('/khoa/{username}','AdAccountController@khoa');

        Route::get('/mo-khoa/{username}','AdAccountController@mo_khoa');

    });

    //PTTMai them, thongng ke admin
    Route::group(['prefix' => 'thong-ke'], function () {
        Route::get('/', 'thongKeController@index');
        Route::group(['prefix' => 'thong-ke-cap-chuong-trinh'], function () {
           
            Route::get('/abet/{maCT}', 'thongKeController@thong_ke_CT_theo_CDR3_Abet');
            Route::get('/get-chuan-dau-ra-3-chuong-trinh','thongKeController@get_CDR3_chuong_trinh');
            Route::get('/thong-ke-abet','thongKeController@get_Abet_chuong_trinh');
            Route::get('/{maCT}', 'thongKeController@thong_ke_CT_theo_CDR3');
            Route::get('/export/{maCT}', 'thongKeController@export_ct');
            Route::get('/export-abet/{maCT}', 'thongKeController@export_abet');
            
            //Route::get('/thong-ke-theo-diem-chu/{maCTBaiQH}/{maCanBo}', 'thongKeController@thong_ke_theo_diem_chu');
            //Route::get('/get-diem-chu','thongKeController@get_diem_chu');
            //Route::get('/thong-ke-theo-tieu-chi/{maCTBaiQH}/{maCanBo}', 'thongKeController@thong_ke_theo_tieu_chi');
            //Route::get('/get-tieu-chi','thongKeController@get_tieu_chi'); 


            //Route::get('/thong-ke-theo-xep-hang-kl/{maCanBo}','thongKeController@thong_ke_theo_xep_hang_kl');
            //Route::get('/get-xep-hang-kl','thongKeController@get_xep_hang_kl');
            //Route::get('/thong-ke-theo-diem-chu-kl/{maCanBo}','thongKeController@thong_ke_theo_diem_chu_kl');
            //Route::get('/get-diem-chu-kl','thongKeController@get_diem_chu_kl');
            //Route::get('/thong-ke-theo-tieu-chi-kl/{maCanBo}','thongKeController@thong_ke_theo_tieu_chi_kl');
            //
                
        });
    });
    //H&#7871;t ph&#7847;n PTTMai th�m

    Route::prefix('thong-ke-ket-qua-theo-hoc-ki')->group(function () {
        Route::get('chuong-trinh', 'thongKeChuongTrinhController@index');
        Route::get('chuong-trinh/namhoc/{maCT}','thongKeChuongTrinhController@chon_thoi_gian');
        Route::get('chuong-trinh/namhoc/lop/thong-ke-theo-abet/{maLop}','thongKeChuongTrinhController@thong_ke_theo_abet');
        Route::get('chuong-trinh/namhoc/lop/export-thong-ke-theo-abet/{maLop}','thongKeChuongTrinhController@export_excel_abet_hoc_ki');
        Route::get('chuong-trinh/namhoc/lop/thong-ke-theo-clo/{maLop}','thongKeChuongTrinhController@thong_ke_theo_clo');
        Route::get('chuong-trinh/namhoc/lop/thong-ke-theo-so/{maLop}','thongKeChuongTrinhController@thong_ke_theo_so');
        Route::get('chuong-trinh/namhoc/lop/{maHK}/{namHoc}','thongKeChuongTrinhController@chon_lop');
    });
});
});