<?php

namespace App\Http\Controllers\Admin;

use App\Models\he;
use App\Models\muc;
use App\Models\CDR1;
use App\Models\nganh;
use App\Models\chuong;
use App\Models\cNganh;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\ctDaoTao;
use App\Models\ctKhoiKT;
use App\Models\bacDaoTao;
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
use App\Models\hocPhan_ppGiangDay;
use App\Models\tai_lieu_tham_khao;
use App\Http\Controllers\Controller;
use App\Models\hocPhan_loaiHTDanhGia;
use App\Http\Controllers\CommonController;

class hocPhanController extends Controller
{
    public function index(Type $var = null)
    {
        $hocphan=hocPhan::where('isDelete',false)->orderBy('maHocPhan','desc')->with('ctkhoi')->get();
        
        $ctkhoi=ctKhoiKT::where('isDelete',false)->orderBy('maCTKhoiKT','asc')->get();
        $ctdt=ctDaoTao::all();
        $loaihp=loaiHocPhan::all();
        return view('admin.hocphan.hocphan',compact('hocphan','ctkhoi','ctdt','loaihp')     );
    }

    public function them(Request $request) //thêm học phần mới
    {

        //tính tổng số tín chỉ
        $request->tongSoTinChi=$request->tinChiLyThuyet+$request->tinChiThucHanh;
        //tạo học phần
        hocPhan::create(['maHocPhan'=>$request->maHocPhan,'tenHocPhan'=>$request->tenHocPhan,'tongSoTinChi'=>$request->tongSoTinChi,
        'tinChiLyThuyet'=>$request->tinChiLyThuyet,'tinChiThucHanh'=>$request->tinChiThucHanh,'maCTKhoiKT'=>$request->maCTKhoiKT]);
        hocPhan_ctDaoTao::create($request->all());
        //phản hồi
        alert()->success('Thêm thành công','Thông báo');
        return redirect('quan-ly/hoc-phan');
    }

     //Sửa học phần
     public function sua(Request $request)
     {
         try {
             $tclt=$request->tinChiLyThuyet;
             $tcth=$request->tinChiThucHanh;
             $tongtc=$tclt+$tcth;
             //echo $tongtc;
             $hp=hocPhan::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['tenHocPhan'=>$request->tenHocPhan,'tongSoTinChi'=>$tongtc,'tinChiLyThuyet'=>$request->tinChiLyThuyet,'tinChiThucHanh'=>$request->tinChiThucHanh,'moTaHocPhan'=>$request->moTaHocPhan,'maCTKhoiKT'=>$request->maCTKhoiKT] );
             
             alert()->success('Updated successfully', 'Message');
             return redirect('/quan-ly/hoc-phan');
         } catch (\Throwable $th) {
            // dd ("lỗi ".$th); hiện lỗi thử
             alert()->error('Error:'.$th, 'Update failed');
            return redirect('/quan-ly/hoc-phan');
         }
     }
 
     //xóa học phần
     public function xoa($maHocPhan)
     {
         try {
             $hp=hocPhan::updateOrCreate(['maHocPhan'=>$maHocPhan],['isDelete'=>true]);
             alert()->success('Deleted successful', 'Message');
             return redirect('/quan-ly/hoc-phan');
         } catch (\Throwable $th) {
             alert()->error('Error:'.$th, 'Delete failed');
             return redirect('/quan-ly/hoc-phan');
         }
     }
     //Hết đoạn PTTMai thêm
    //////////////////////////////////////////////////////////////////////////////////////////
    ////////////////////////////////////////HIỂN THỊ ĐỀ CƯƠNG MÔN HỌC//////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////////
    public function de_cuong_mon_hoc(Request $request,$maHocPhan)
    {//hàm hiển thị đề cương chi tiết
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

        $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) //biến này chạy nội dung trong bảng chuẩn đầu ra môn học
        ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
        ->join('chuan_abet',function($y){
            $y->on('chuan_abet.maChuanAbet','=','hocphan_kqht_hp.maChuanAbet')
            ->where('chuan_abet.isDelete',false);
        })
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
        ->get(); //biến này in bảng phương thức đánh giá

        //phản hồi
        return view('admin.hocphan.themdecuong',['hocPhan'=>$hocPhan,'monHoc'=>$mon,'hocphan_ctdaotao'=>$hocphan_ctdaotao,
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
    public function them_mon_tien_quyet(Request $request)//thêm môn tiên quyết
    {
        monTienQuyet::create(['maHocPhan'=>$request->maHocPhan,'maMonTienQuyet'=>$request->maMonTienQuyet]);
        //phản hồi
        alert()->success('Cập nhật môn tiên quyết thành công!!','Thông báo');
        return back();
    }
    public function them_giao_trinh(Request $request)//thêm giáo trình
    {
        //sửa tài liệu tham khảo
        tai_lieu_tham_khao::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['giaoTrinh'=>$request->giaoTrinh]);
        //phản hồi
        alert()->success('Cập nhật thành công!!','Thông báo');
        return back();
    }
    public function them_tai_lieu_tham_khao_them(Request $request)//thêm tài liệu tham khảo
    {
        //sửa tài liệu tham khảo
        tai_lieu_tham_khao::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['thamKhaoThem'=>$request->thamKhaoThem]);
        //phản hồi
        alert()->success('Cập nhật thành công!!','Thông báo');
        return back();
    }
    public function them_tai_lieu_khac(Request $request)//thêm tài liệu khác
    {
        //sửa tài liệu tham khảo
        tai_lieu_tham_khao::updateOrCreate(['maHocPhan'=>$request->maHocPhan],['taiLieuKhac'=>$request->taiLieuKhac]);
        //phản hồi
        alert()->success('Cập nhật thành công!!','Thông báo');
        return back();
    }
    public function them_yeu_cau_hoc_phan(Request $request)  //thêm yêu cầu học phần
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
    public function them_mo_ta_hoc_phan(Request $request) //thêm mô tả học phần
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
            hocPhan_kqHTHP::create(['maHocPhan'=>$request->maHocPhan,'maKQHT'=>$kqht->maKQHT,'maCDR3'=>$maCDR3,'maChuanAbet'=>$request->maChuanAbet]);
        }

        //phản hồi
        alert()->success('Thêm chuẩn đầu ra thành công!!','Thông báo');
        return back();
    }

    public function sua_chuan_dau_ra_mon_hoc(Request $request)
    {
        # 1. Sửa KQht
        //1.thêm kết quả học tập
        kqHTHP::updateOrCreate(['maKQHT'=>$request->maKQHT],['maKQHTVB'=>$request->maKQHTVB,'tenKQHT'=>$request->tenKQHT]);
        // sửa học phần kqht chuẩn đầu ra cdio và chuẩn đầu ra abet
        hocPhan_kqHTHP::updateOrCreate(['id'=>$request->id],['maHocPhan'=>$request->maHocPhan,'maKQHT'=>$request->maKQHT,'maCDR3'=>$request->maCDR3,'maChuanAbet'=>$request->maChuanAbet]);
        //phản hồi
        //alert()->success('Thêm chuẩn đầu ra thành công!!','Thông báo');
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

    public function them_muc_do_ky_nang_uti(Request $request)
    {
        # code...
        $kqht=$request->maKQHT;
        for ($i=0; $i < count($kqht); $i++) { 
            mucDoKyNangUIT::create(['id_chuong'=>$request->id_chuong,'maKQHT'=>$kqht[$i],'maCDR1'=>$request->maCDR1,'ky_nang'=>$request->ky_nang]);
        }
        //phản hồi
        alert()->success('Adding successfully!!','Message');
        return back();
    }
    public function them_muc(Request $request)//thêm mục
    {
        //thêm mục mới
        muc::create($request->all());
        //phản hồi
        alert()->success('Thêm nội dung thành công!!','Thông báo');
        return back();
    }
    public function them_phuong_phap_giang_giay(Request $request)//thêm phương pháp giảng dạy
    {
        //thêm bảng hocphan_ppGiangDay
        hocPhan_ppGiangDay::create(['maHocPhan'=>$request->maHocPhan,'maPP'=>$request->maPP,'dienGiai'=>$request->dienGiai]);
        //phản hồi
        alert()->success('Thêm phương pháp giảng dạy thành công!!','Thông báo');
        return back();
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
        alert()->success('Thêm phương thức đánh giá thành công!!','Thông báo');
        return back();
    }
    ///////////////////////////////////////////////////////////////////////////////////
    /////////////////////////////////////////////////HẾT XỬ LÝ ĐỀ CƯƠNG////////////////
    //////////////////////////////////////////////////////////////////////////////////
}
