<?php

namespace App\Http\Controllers\Admin;

use App\Models\CDR1;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\ppGiangDay;
use App\Models\chuong_kqht;
use App\Models\loaiDanhGia;
use App\Models\loaiHocPhan;
use App\Models\monTienQuyet;
use Illuminate\Http\Request;
use App\Models\loaiHTDanhGia;
use App\Models\hocPhan_kqHTHP;
use App\Models\ct_khoi_kien_thuc;
use App\Models\hocPhan_ppGiangDay;
use App\Models\tai_lieu_tham_khao;
use App\Http\Controllers\Controller;
use App\Models\hocPhan_loaiHTDanhGia;
use App\Http\Controllers\CommonController;

class hocPhanController extends Controller
{
    public function index(Type $var = null)
    {
        $hp=hocPhan::all();
        $ctkkt=ct_khoi_kien_thuc::all();
        return view('admin.hocphan.hocphan',['hocPhan'=>$hp,'ctkkt'=>$ctkkt]);
    }

    public function them_hp(Request $request) //thêm học phần mới
    {
        //tính tổng số tín chỉ
        $request->tongSoTinChi=$request->tinChiLyThuyet+$request->tinChiThucHanh;
        //tạo học phần
        hocPhan::create(['maHocPhan'=>$request->maHocPhan,'tenHocPhan'=>$request->tenHocPhan,'tongSoTinChi'=>$request->tongSoTinChi,
        'tinChiLyThuyet'=>$request->tinChiLyThuyet,'tinChiThucHanh'=>$request->tinChiThucHanh,'maCTKhoiKT'=>$request->maCTKhoiKT]);
        //phản hồi
        alert()->success('Thêm thành công','Thông báo');
        return redirect('quan-ly/hoc-phan');
    }
    //////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////HIỂN THỊ ĐỀ CƯƠNG MÔN HỌC//////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    public function de_cuong_mon_hoc(Request $request,$maHocPhan)
    {//hàm hiển thị đề cương chi tiết
        //1/ Thông tin chung
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        $loaiMonHoc=loaiHocPhan::all();
        $mon=hocPhan::where('maHocPhan','!=',$maHocPhan)->get(); //hiển thị combobox cho phép chọn môn tiên quyết
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

        $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) //biến này chạy nội dung trong bảng chuẩn đầu ra môn học
        ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->join('cdr_cd3',function($t){
            $t->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->join('cdr_cd2',function($t){
            $t->on('cdr_cd2.maCDR2','=','cdr_cd3.maCDR2')
            ->where('cdr_cd2.isDelete',false);
        })
        ->join('cdr_cd1',function($t){
            $t->on('cdr_cd1.maCDR1','=','cdr_cd2.maCDR1')
            ->where('cdr_cd1.isDelete',false);
        })
        ->get();

        //5 nội dung môn học
        $kqht_hp=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) 
        ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
        ->get('maKQHT');

        $getKQHT=kqHTHP::whereIn('maKQHT',$kqht_hp)->get(); //biến hiện combobox kqht thêm chương (vì select distinct không chạy nên dùng wherein)
        
        $noidung=chuong::where('chuong.isdelete',false)->where('chuong.maHocPhan',$maHocPhan)
        ->orderBy('chuong.id','asc')
        ->with('chuong_kqht')
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
        ->get();
        //phản hồi
        return view('admin.hocphan.themdecuong',['hocPhan'=>$hocPhan,'monHoc'=>$mon,'monTQ'=>$monTQ,
        'tailieu'=>$tailieu,'CDR1'=>$cdr1,'cdr'=>$cdr,'kqht'=>$kqht,'getKQHT'=>$getKQHT,
        'ppGiangDay'=>$ppgd,'hocPhan_ppGiangDay'=>$hp_ppgd,'noidung'=>$noidung,'loaiDG'=>$loaiDG,
        'loaiHTDG'=>$loaiHTDG]);

    }
    /////////////////////////////////////////////////////////////////////////////////////////////////
    //////////////////////////////////////////////CÁC HÀM XỬ LÝ CHO THÊM ĐỀ CƯƠNG/////////////////
    /////////////////////////////////////////////////////////////////////////////////////////////////    
    
    public function them_mon_tien_quyet(Request $request)
    {
        monTienQuyet::create(['maHocPhan'=>$request->maHocPhan,'maMonTienQuyet'=>$request->maMonTienQuyet]);
        //phản hồi
        alert()->success('Cập nhật môn tiên quyết thành công!!','Thông báo');
        return back();
    }

    public function them_giao_trinh(Request $request)
    {
        //sửa tài liệu tham khảo
        tai_lieu_tham_khao::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['giaoTrinh'=>$request->giaoTrinh]);
        //phản hồi
        alert()->success('Cập nhật thành công!!','Thông báo');
        return back();
    }
    public function them_tai_lieu_tham_khao_them(Request $request)
    {
        //sửa tài liệu tham khảo
        tai_lieu_tham_khao::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['thamKhaoThem'=>$request->thamKhaoThem]);
        //phản hồi
        alert()->success('Cập nhật thành công!!','Thông báo');
        return back();
    }
    public function them_tai_lieu_khac(Request $request)
    {
        //sửa tài liệu tham khảo
        tai_lieu_tham_khao::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['taiLieuKhac'=>$request->taiLieuKhac]);
        //phản hồi
        alert()->success('Cập nhật thành công!!','Thông báo');
        return back();
    }

    public function them_yeu_cau_hoc_phan(Request $request)
    {
        //sửa học phần
        //hocPhan::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['yeuCau'=>$request->yeuCau]);
        $hp=hocPhan::where('mahocPhan',$request->maHocPhan)->first();
        $hp->yeuCau=$request->yeuCau;
        $hp->save();
        //phản hồi
        alert()->success('Thêm yêu cầu thành công!!','Thông báo');
        return back();
    }
    public function them_mo_ta_hoc_phan(Request $request)
    {
        //sửa học phần
        hocPhan::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['moTaHocPhan'=>$request->moTaHocPhan]);
        
        //phản hồi
        alert()->success('Thêm mô tả thành công!!','Thông báo');
        return back();
    }
    public function them_chuan_dau_ra_mon_hoc(Request $request) //thêm chuẩn đầu ra môn học
    {
        //1.thêm kết quả học tập
       
        kqHTHP::create(['maKQHTVB'=>$request->maKQHTVB,'tenKQHT'=>$request->tenKQHT]);
        //2.lấy mã kqht mới thêm
        $kqht=kqHTHP::where('isDelete',false)->orderBy('maKQHT','desc')->first();
        //3.thêm hocphan_kqht
        $arrray_maCDR3=$request->maCDR3;
        foreach ($arrray_maCDR3 as $maCDR3) {
            hocPhan_kqHTHP::create(['maHocPhan'=>$request->maHocPhan,'maKQHT'=>$kqht->maKQHT,'maCDR3'=>$maCDR3]);
        }

        //phản hồi
        alert()->success('Thêm chuẩn đầu ra thành công!!','Thông báo');
        return back();
    }

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
        //phản hồi
        alert()->success('Thêm nội dung thành công!!','Thông báo');
        return back();
    }

    public function them_phuong_phap_giang_giay(Request $request)
    {
        //thêm bảng hocphan_ppGiangDay
        hocPhan_ppGiangDay::create(['maHocPhan'=>$request->maHocPhan,'maPP'=>$request->maPP,'dienGiai'=>$request->dienGiai]);
        //phản hồi
        alert()->success('Thêm phương pháp giảng dạy thành công!!','Thông báo');
        return back();
        
    }


    public function them_hoc_phan_loaiHTDG(Request $request)
    {
        hocPhan_loaiHTDanhGia::create(['maHocPhan'=>$request->maHocPhan,'maLoaiDG'=>$request->maLoaiDG,'maLoaiHTDG'=>$request->maLoaiHTDG]);
         //phản hồi
         alert()->success('Thêm phương pháp giảng dạy thành công!!','Thông báo');
         return back();
    }

    ///////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////HẾT XỬ LÝ ĐỀ CƯƠNG////////////////
    //////////////////////////////////////////////////////////////////////////////////
}
