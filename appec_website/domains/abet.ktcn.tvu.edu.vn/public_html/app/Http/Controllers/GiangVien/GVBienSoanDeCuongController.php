<?php

namespace App\Http\Controllers\GiangVien;

use App\Models\he;

use Carbon\Carbon;
use App\Models\muc;
use App\Models\CDR1;
use App\Models\CDR3;
use App\Models\nganh;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\cNganh;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\ctDaoTao;
use App\Models\ctKhoiKT;
use App\Models\bacDaoTao;
use App\Models\cdr2_abet;
use App\Models\cdr3_abet;
use App\Models\chuan_abet;
use App\Models\ppGiangDay;
use App\Models\chuong_kqht;
use App\Models\loaiDanhGia;
use App\Models\loaiHocPhan;
use App\Models\monTienQuyet;
use App\Models\mucDoDanhGia;
use Illuminate\Http\Request;
use App\Models\loaiHTDanhGia;
use App\Models\hocPhan_kqHTHP;
use App\Models\mucDoKyNangUIT;
use App\Models\hocPhan_ctDaoTao;
use App\Models\ct_khoi_kien_thuc;
use App\Models\bien_soan_de_cuong;
use App\Models\hocPhan_ppGiangDay;
use App\Models\tai_lieu_tham_khao;
use App\Http\Controllers\Controller;
use App\Models\hocPhan_loaiHTDanhGia;
use Illuminate\Support\Facades\Session;
use App\Http\Controllers\CommonController;
use App\Models\hocPhan_loaiHTDanhGia_KQHT;

class GVBienSoanDeCuongController extends Controller
{
    public function index(Type $var = null)
    {
        $bienSoan=bien_soan_de_cuong::where('maGV',session::get('maGV'))->pluck('maHocPhan');
        $hocphan=hocPhan::whereIn('maHocPhan',$bienSoan)->where('isDelete',false)->orderBy('maHocPhan','desc')->with('hocphan_ctdt')->get();
        $ctkhoi=ctKhoiKT::where('isDelete',false)->orderBy('maCTKhoiKT','asc')->get();
        $ctdt=ctDaoTao::all();
        $loaihp=loaiHocPhan::all();
        foreach ($hocphan as $hp) {
            foreach ($hp->hocphan_ctdt as $hp_ctdt) {
                $ct=ctDaoTao::where('maCT',$hp_ctdt->maCT)->first();
                $hp_ctdt->tenCT=$ct->tenCT;
            }
        }
        return view('giangvien.biensoandecuong.dshocphan',compact('hocphan','ctkhoi','ctdt','loaihp'));
    }

    //////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////HIỂN THỊ ĐỀ CƯƠNG MÔN HỌC//////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    public function de_cuong_mon_hoc(Request $request,$maHocPhan)
    {   
       
        if(bien_soan_de_cuong::where('maGV',session::get('maGV'))->where('maHocPhan',$maHocPhan)->count('maHocPhan')==0){
            return redirect('/giang-vien/bien-soan-de-cuong');
        }
        $bienSoan=bien_soan_de_cuong::where('maGV',session::get('maGV'))->where('maHocPhan',$maHocPhan)->first();
        $now = Carbon::now();
        $start=Carbon::parse($bienSoan->thoiGianBatDau)->format('Y-m-d h:m:s');
        $end=Carbon::parse($bienSoan->thoiGianKetThuc)->format('Y-m-d h:m:s');
        
        if (!$now->between($start, $end)) {
            CommonController::warning_notify('Hết thời gian!','Time out');
            return redirect('/giang-vien/bien-soan-de-cuong');
        }
        //luu phien lam viec
        Session::put('maHocPhan',$maHocPhan);
        //hàm hiển thị đề cương chi tiết
        //1/ Thông tin chung
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)->where('isDelete',false)->first();
        $loaiMonHoc=loaiHocPhan::all();
        $mon=hocPhan::where('maHocPhan','!=',$maHocPhan)->where('isDelete',false)->get(); //hiển thị combobox cho phép chọn môn tiên quyết
        $hocphan_ctdaotao=hocPhan_ctDaoTao::where('isDelete',false)->where('maHocPhan',$maHocPhan)->with('ctDaoTao')->first(); //**chổ này cần chỉ khi có nhiều chương trình đào tạo hơn
        //**lấy tên hệ, tên bậc, tên ngành->thay đổi đối với 1 học phần thuộc nhiều chương trình đào tạo
        $he=$bac=$CNganh="";
        $he=he::findOrFail($hocphan_ctdaotao->ctDaoTao[0]->maHe);
        $bac=bacDaoTao::findOrFail($hocphan_ctdaotao->ctDaoTao[0]->maBac);
        $CNganh=cNganh::findOrFail($hocphan_ctdaotao->ctDaoTao[0]->maCNganh);
        $nganh=new nganh();
        if ($CNganh) {
            $nganh=nganh::findOrFail($CNganh->maNganh);
        }
        $monTQ=monTienQuyet::where('maHocPhan',$maHocPhan)->where('isDelete',false)->with('hoc_phan')->get();
        // $hp_ctdt=hocPhan_ctDaoTao::where('isdelete',false)->where('maH')
        //2/ Tài liệu tham khảo
        $tailieu=tai_lieu_tham_khao::where('maHocPhan',$maHocPhan)->first();
        //3 mô tả
        //4 Chuẩn đầu ra môn học
        $cdr1=CDR1::all();//biến này để in chủ đề
        $cdr=CDR1::join('cdr_cd2',function($x){ //biến này để chạy combobox cho modal thêm chuẩn đầu ra môn học
            $x->on('cdr_cd1.maCDR1','=','cdr_cd2.maCDR1')
            ->where('cdr_cd2.isDelete',false);
        })
        ->join('cdr_cd3',function($x){
            $x->on('cdr_cd2.maCDR2','=','cdr_cd3.maCDR2')
            ->where('cdr_cd3.isDelete',false);
        })
        ->get();
        //bien nay chay noi dung trong bang chuan đau ra mon hoc
        $kqht=hocPhan_kqHTHP::get_kqht_cdr3_abet($maHocPhan);

        $chuan_abet=chuan_abet::all();//combobox chuẩn abet
        //5 nội dung môn học
        $kqht_hp=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) 
        ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
        ->get('maKQHT');
        $getKQHT=kqHTHP::whereIn('maKQHT',$kqht_hp)->get(); //biến hiện combobox kqht thêm chương (vì select distinct không chạy nên dùng wherein)
        
        $mucDoDG=mucDoDanhGia::where('isDelete',false)->get();  //hiện combobox mức độ đánh giá trong chương
        
        $noidung=chuong::where('chuong.isdelete',false)->where('chuong.maHocPhan',$maHocPhan)
        ->orderBy('chuong.id','asc')
        ->with('muc')
        ->with('chuong_kqht')
        ->get();
        
        $chuong_array=chuong::where('chuong.isdelete',false)->where('chuong.maHocPhan',$maHocPhan)
        ->orderBy('chuong.id','asc')
        ->pluck('id');
        
        $mudokynangUIT=mucDoKyNangUIT::whereIn('muc_do_ky_nang_itu.id_chuong',$chuong_array)
        ->orderBy('muc_do_ky_nang_itu.maCDR1')
        ->join('cdr_cd1','cdr_cd1.maCDR1','=','muc_do_ky_nang_itu.maCDR1')
        ->join('kqht_hp','kqht_hp.maKQHT','=','muc_do_ky_nang_itu.maKQHT')
        ->get();
        foreach ($noidung as $nd) {
            foreach ($nd->chuong_kqht as $x) {
                $temp=kqHTHP::where('maKQHT',$x->maKQHT)->first();
                $x->maKQHTVB=$temp->maKQHTVB;
                $x->tenKQHT=$temp->tenKQHT;
            }
        }
        //6 Phương pháp giảng dạy
        $ppgd=ppGiangDay::where('isDelete',false)->orderBy('maPP','desc')->get(); //biến tạo combobox giảng dạy
        $hp_ppgd=hocPhan_ppGiangDay::where('isDelete',false)->where('maHocPhan',$maHocPhan)->with('ppGiangDay')->get(); //biển hiển thị phương pháp giảng dạy 
        //7 Phương pháp đánh giá
        $loaiDG=loaiDanhGia::where('isDelete',false)->get();
        $loaiHTDG=loaiHTDanhGia::where('isDelete',false)->get(); //chọn hình thức
        $hocPhan_loaiHTDG=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('maHocPhan',$maHocPhan)
        ->with('loai_danh_gia')
        ->with('loaiHTDanhGia')
        ->with('hp_loaihtdg_kqht')
        ->get(); //biến này in bảng phương thức đánh giá
        //phản hồi
        
        return view('giangvien.biensoandecuong.noidungdecuong',['hocPhan'=>$hocPhan,'monHoc'=>$mon,'hocphan_ctdaotao'=>$hocphan_ctdaotao,
        'monTQ'=>$monTQ,'tailieu'=>$tailieu,
        'he'=>$he,'bac'=>$bac,'CNganh'=>$CNganh,'nganh'=>$nganh,
        'CDR1'=>$cdr1,'cdr'=>$cdr,'kqht'=>$kqht,'getKQHT'=>$getKQHT,'mudokynangUIT'=>$mudokynangUIT,'chuan_abet'=>$chuan_abet,
        'ppGiangDay'=>$ppgd,'hocPhan_ppGiangDay'=>$hp_ppgd,
        'noidung'=>$noidung,'loaiDG'=>$loaiDG, 'mucDoDG'=>$mucDoDG,
        'loaiHTDG'=>$loaiHTDG,'hocPhan_loaiHTDG'=>$hocPhan_loaiHTDG]);
    }
    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////CÁC HÀM XỬ LÝ CHO THÊM ĐỀ CƯƠNG/////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////    
    //MON TIEN QUYET
    public function them_mon_tien_quyet(Request $request)
    {
        monTienQuyet::create(['maHocPhan'=>$request->maHocPhan,'maMonTienQuyet'=>$request->maMonTienQuyet]);
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_mon_tien_quyet($id)
    {
        monTienQuyet::find($id)->delete();
        //phản hồi
        CommonController::success_notify('Xóa thành công','Deleted successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));

    }

    //GIAO TRINH----------------------------------------------------------------
    public function them_giao_trinh(Request $request)
    {
        //sửa tài liệu tham khảo
        tai_lieu_tham_khao::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['giaoTrinh'=>$request->giaoTrinh]);
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_giao_trinh($id)
    {
        $tailieu=tai_lieu_tham_khao::find($id);
        if($tailieu){
            $tailieu->giaoTrinh=null;
            $tailieu->update();
            Commoncontroller::success_notify('Xóa thành công!','Deleted successfully');
        }
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    // TAI LIEU THAM KHAO------------------------------------------------------
    public function them_tai_lieu_tham_khao_them(Request $request)
    {
        //sửa tài liệu tham khảo
        tai_lieu_tham_khao::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['thamKhaoThem'=>$request->thamKhaoThem]);
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_tai_lieu_tham_khao($id)
    {
        $tailieu=tai_lieu_tham_khao::find($id);
        if($tailieu){
            $tailieu->thamKhaoThem=null;
            $tailieu->update();
            Commoncontroller::success_notify('Xóa thành công!','Deleted successfully');
        }
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));

    }

    //TAI LIEU KHAC------------------------------------------------------------
    public function them_tai_lieu_khac(Request $request)
    {
        //sửa tài liệu tham khảo
        tai_lieu_tham_khao::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['taiLieuKhac'=>$request->taiLieuKhac]);
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_tai_lieu_khac($id)
    {
        $tailieu=tai_lieu_tham_khao::find($id);
        if($tailieu){
            $tailieu->taiLieuKhac=null;
            $tailieu->update();
            Commoncontroller::success_notify('Xóa thành công!','Deleted successfully');
        }
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    //YEU CAU HOC PHAN---------------------------------------------------------------
    public function them_yeu_cau_hoc_phan(Request $request)  
    {
        //sửa học phần
        //hocPhan::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['yeuCau'=>$request->yeuCau]);
        $hp=hocPhan::where('mahocPhan',$request->maHocPhan)->first();
        $hp->yeuCau=$request->yeuCau;
        $hp->save();
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    //MO TA HOC PHAN
    public function them_mo_ta_hoc_phan(Request $request) 
    {
        //sửa học phần
        hocPhan::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['moTaHocPhan'=>$request->moTaHocPhan]);
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    //CHUAN DAU RA MON HOC
    public function them_chuan_dau_ra_mon_hoc(Request $request) 
    {
        //1.them ket qua hoc tap
        kqHTHP::create(['maKQHTVB'=>$request->maKQHTVB,'tenKQHT'=>$request->tenKQHT]);
        //2.lay ma kqht mới thêm
        $kqht=kqHTHP::where('isDelete',false)->orderBy('maKQHT','desc')->first();
        //3.them hocphan_kqht
        $arrray_maCDR3=$request->maCDR3;
        foreach ($arrray_maCDR3 as $maCDR3) {
            //tim tuong quan chuan dau ra 2 và abet
            $cdr3=CDR3::where('maCDR3',$maCDR3)->first();
            if($cdr3){
                $cdr3_abet=cdr3_abet::where('maCDR3',$cdr3->maCDR3)->first();
                if($cdr3_abet){
                     //luu ket qua chuan dau ra theo tuong quan abet
                    hocPhan_kqHTHP::create(['maHocPhan'=>$request->maHocPhan,'maKQHT'=>$kqht->maKQHT,'maCDR3'=>$cdr3->maCDR3,'maChuanAbet'=>$cdr3_abet->maChuanAbet]);
                }else{
                    CommonController::warning_notify('Không tìm thấy chuẩn abe','Abet SO outcome is not exits');
                  return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
                }
               
                
            }else{
                CommonController::warning_notify('Không tìm thấy CDR3','LV3 outcome is not exits');
                return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
            }
        }
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }


    public function sua_chuan_dau_ra_mon_hoc(Request $request)
    {
        # 1. Sửa KQht
        //1.thêm kết quả học tập
        kqHTHP::updateOrCreate(['maKQHT'=>$request->maKQHT],['maKQHTVB'=>$request->maKQHTVB,'tenKQHT'=>$request->tenKQHT]);
        // sửa học phần kqht chuẩn đầu ra cdio và chuẩn đầu ra abet
        $abet=CommonController::get_abet_from_cdr3($request->maCDR3);
        if($abet){ 
            hocPhan_kqHTHP::updateOrCreate(['id'=>$request->id],['maHocPhan'=>$request->maHocPhan,'maKQHT'=>$request->maKQHT,'maCDR3'=>$request->maCDR3,
            'maChuanAbet'=>$abet]);
        }else{
            hocPhan_kqHTHP::updateOrCreate(['id'=>$request->id],['maHocPhan'=>$request->maHocPhan,'maKQHT'=>$request->maKQHT,'maCDR3'=>$request->maCDR3]);
        }
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_chuan_dau_ra_mon_hoc($id)
    {
        hocPhan_kqHTHP::find($id)->delete();
        CommonController::success_notify('Xóa thành công','Deleted successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }
    
    public function them_ket_qua_hoc_tap_chuan_dau_ra(Request $request)
    {
       
        //1 lay kqht
        $kqht=kqHTHP::where('maKQHT',$request->maKQHT)->first();
        //kiem tra neu co roi thi khong them
        $hp_kqht=hocPhan_kqHTHP::where('maHocPhan',Session::get('maHocPhan'))->where('maKQHT',$kqht->maKQHT)->where('maCDR3',$request->maCDR3)->count('maCDR3');
        if($hp_kqht>0){
            CommonController::warning_notify('CDR3 đã được chọn','CDIO was choise');
            return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
        }
        //2 them hp_kqht
        $abet=CommonController::get_abet_from_cdr3($request->maCDR3);
        
        if ($abet) {
            hocPhan_kqHTHP::create(['maHocPhan'=>Session::get('maHocPhan'),'maKQHT'=>$kqht->maKQHT,'maCDR3'=>$request->maCDR3,'maChuanAbet'=>$abet]);
        }else{
            hocPhan_kqHTHP::create(['maHocPhan'=>Session::get('maHocPhan'),'maKQHT'=>$kqht->maKQHT,'maCDR3'=>$request->maCDR3,'maChuanAbet'=>1]);
        }
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }
    public function xoa_ket_qua_hoc_tap_mon_hoc($maKQHT)
    {
        //kiem tra kqht co duoc su dung
        $chuong_kqht=chuong_kqht::where('maKQHT',$maKQHT)->count('id');
        if($chuong_kqht>0){
            CommonController::warning_notify('Kết quả có liên kết với chương, không thể xóa','This result is used in a chaprer, delete denied!');
            return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
        }
        $cauhoi=cauHoi::where('maKQHT',$maKQHT)->count('maCauHoi');
        if($chuong_kqht>0){
            CommonController::warning_notify('Kết quả có liên kết với câu hỏi, không thể xóa','This result is used in a question, delete denied!');
            return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
        }
        //tien hanh xoa
        hocPhan_kqHTHP::where('maHocPhan',Session::get('maGV'))->where('maKQHT',$maKQHT)->delete();
        kqHTHP::find($maKQHT)->delete();
        //phản hồi
        CommonController::success_notify('Xóa thành công','Deleted successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    //NỘI DUNG MÔN HỌC
    public function them_noi_dung_mon_hoc(Request $request)  //thêm nội dung môn học (chương)
    {
        //1.thêm chương mới
        chuong::create(['tenchuong'=>$request->tenchuong,'tenkhongdau'=>CommonController::con_str($request->tenchuong),
        'soTietLT'=>$request->soTietLT,'soTietTH'=>$request->soTietTH,'soTietKhac'.$request->soTietKhac,'mota'=>$request->mota,
        'maHocPhan'=>$request->maHocPhan]);
        $chg=chuong::where('isdelete',false)->orderBy('id','desc')->first();
        //2.cập nhật chương vào bảng hocphan_kqht
        if($chg){
            foreach ($request->maKQHT as $data) {
               chuong_kqht::create(['machuong'=>$chg->id,'maKQHT'=>$data]);
            }
        }
        //3.phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function them_chuong_kqht(Request $request)
    {
        foreach ($request->maKQHT as $makqht) {
            if(chuong_kqht::where('machuong',$request->machuong)->where('maKQHT',$makqht)->count('id')==0){
                chuong_kqht::create(['machuong'=>$request->machuong,'maKQHT'=>$makqht]);
            }
        }
        //3.phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }
    public function xoa_chuong_kqht($machuong,$maKQHT)
    {
        chuong_kqht::where('machuong',$machuong)->where('maKQHT',$maKQHT)->delete();
        //3.phản hồi
        CommonController::success_notify('Xóa thành công','Deleted successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function sua_noi_dung_mon_hoc(Request $request)
    {
        chuong::updateOrCreate(['id'=>$request->id],['tenchuong'=>$request->tenchuong,
        'tenkhongdau'=>CommonController::con_str($request->tenchuong),
        'mota'=>$request->mota,'soTietLT'=>$request->soTietLT,'soTietTH'=>$request->soTietTH]);
      
        //3.phản hồi
        CommonController::success_notify('Sửa thành công','Edited successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_noi_dung_mon_hoc($id)
    {
        //kiem tra neu chuong co muc thi khong the xoa
        if(muc::where('id_chuong',$id)->count('id')){
            CommonController::warning_notify('Có tồn tại các mục con, không thể xóa!!','There are items in chapter, can not delete');
            return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
        }
        if(chuong_kqht::where('machuong',$id)->count('id')>0){
            CommonController::warning_notify('Có tồn tại kết quả học tập, không thể xóa!!','There are results in chapter, can not delete');
            return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
        }
        chuong::where('id',$id)->delete();
        //phan hoi
        CommonController::success_notify('Xóa thành công','Deleted successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function them_muc_do_ky_nang_uti(Request $request)
    {
        # code...
        $kqht=$request->maKQHT;
        for ($i=0; $i < count($kqht); $i++) { 
            mucDoKyNangUIT::create(['id_chuong'=>$request->id_chuong,'maKQHT'=>$kqht[$i],'maCDR1'=>$request->maCDR1,'ky_nang'=>$request->ky_nang]);
        }
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_muc_do_ky_nang_uti($id)
    {
        mucDoKyNangUIT::find($id)->delete();
        //3.phản hồi
        CommonController::success_notify('Xóa thành công','Deleted successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function them_muc(Request $request)//thêm mục
    {
        //thêm mục mới
        muc::create($request->all());
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function sua_muc(Request $request)
    {
        muc::updateOrCreate(['id'=>$request->id],['maMucVB'=>$request->maMucVB,'tenMuc'=>$request->tenMuc]);
        //phản hồi
        CommonController::success_notify('Sửa thành công','Edited successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_muc($id)
    {
        //kiem tra muc co cau hoi
        if(cauHoi::where('id_muc',$id)->count('maCauHoi')>0){
            CommonController::warning_notify('Trong mục có câu hỏi!!','There are questions in this item!');
            return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
        }
        muc::where('id',$id)->delete();
        //phản hồi
        CommonController::success_notify('Xóa thành công','Deleted successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function them_phuong_phap_giang_giay(Request $request)//thêm phương pháp giảng dạy
    {
        //thêm bảng hocphan_ppGiangDay
        hocPhan_ppGiangDay::create(['maHocPhan'=>$request->maHocPhan,'maPP'=>$request->maPP,'dienGiai'=>$request->dienGiai]);
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_phuong_phap_giang_giay($id)
    {
        hocPhan_ppGiangDay::find($id)->delete();
        //phản hồi
        CommonController::success_notify('Xoá thành công','Deleted successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }
    
    public function them_hoc_phan_loaiHTDG(Request $request)  //thêm học phần _ loại hình thức đánhg giá
    {
        $tile_group1=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('groupCT',1)->where('maHocPhan',$request->maHocPhan)->sum('trongSo');
        $tile_group2=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('groupCT',2)->where('maHocPhan',$request->maHocPhan)->sum('trongSo');
        if($tile_group1==100 && $request->groupCT==1){
            alert()->warning('Tỉ lệ công thức 1 đã đạt 100%, không thể thêm phương thức đánh giá!!','Cảnh báo');
            return back();
        }
        if($tile_group2==100 && $request->groupCT==2){
            alert()->warning('Tỉ lệ công thức 2 đã đạt 100%, không thể thêm phương thức đánh giá!!','Cảnh báo');
            return back();
        }
        hocPhan_loaiHTDanhGia::create(['maHocPhan'=>$request->maHocPhan,'maLoaiDG'=>$request->maLoaiDG,'maLoaiHTDG'=>$request->maLoaiHTDG,'trongSo'=>$request->trongSo,'groupCT'=>$request->groupCT]);
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function sua_hoc_phan_loaiHTDG(Request $request)
    {
        hocPhan_loaiHTDanhGia::updateOrCreate(["id"=>$request->id],["maLoaiDG"=>$request->maLoaiDG,"maLoaiHTDG"=>$request->maLoaiHTDG,
        "groupCT"=>$request->groupCT,"trongSo"=>$request->trongSo]);

        // phan hoi
        CommonController::success_notify('Sửa thành công','Edited successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_hoc_phan_loaiHTDG($id)
    {
        hocPhan_loaiHTDanhGia_KQHT::where('maHP_LHTDG',$id)->delete();
        hocPhan_loaiHTDanhGia::find($id)->delete();

        // phan hoi
        CommonController::success_notify('Xóa thành công','Deleted successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function them_hocphan_loaihtdg_kqht(Request $request)
    {
        $arr_kqht=$request->maKQHT;
        foreach ($arr_kqht as $value) {
            //kiem tra neu kqht da duoc chon thi bo qua
            if(hocPhan_loaiHTDanhGia_KQHT::where('maKQHT',$value)->where('maHP_LHTDG',$request->maHP_LHTDG)->count('maKQHT')>0){
                continue;
            }
            //tien hanh cap nhat
            $kqht=kqHTHP::find($value);
            $maKQHTVB = ($kqht) ? $kqht->maKQHTVB : "" ;
            hocPhan_loaiHTDanhGia_KQHT::create(['maHP_LHTDG'=>$request->maHP_LHTDG,
            'maKQHT'=>$value,'maKQHTVB'=>$maKQHTVB]);
        }
        //phản hồi
        CommonController::success_notify('Thêm thành công','Added successfully');
        return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }

    public function xoa_hocphan_loaihtdg_kqht($id)
    {
        hocPhan_loaiHTDanhGia_KQHT::find($id)->delete();
         //phản hồi
         CommonController::success_notify('Xóa thành công','Deleted successfully');
         return redirect('/giang-vien/bien-soan-de-cuong/chinh-de-cuong/'.session::get('maHocPhan'));
    }
    ///////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////HẾT XỬ LÝ ĐỀ CƯƠNG////////////////
    //////////////////////////////////////////////////////////////////////////////////
}
