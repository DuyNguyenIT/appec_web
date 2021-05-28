<?php

namespace App\Http\Controllers\giangvien;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class GVDeCuongController extends Controller
{
    public function index($maHocPhan)
    {   
        //luu phien lam viec
        Session::put('maHocPhan',$maHocPhan);
        //kiem tra giang vien co quyen kiem tra de cuong

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
        ->get(); //biến này in bảng phương thức đánh giá
        //phản hồi
        return view('giangvien.decuong.index',['hocPhan'=>$hocPhan,'monHoc'=>$mon,'hocphan_ctdaotao'=>$hocphan_ctdaotao,
        'monTQ'=>$monTQ,'tailieu'=>$tailieu,
        'he'=>$he,'bac'=>$bac,'CNganh'=>$CNganh,'nganh'=>$nganh,
        'CDR1'=>$cdr1,'cdr'=>$cdr,'kqht'=>$kqht,'getKQHT'=>$getKQHT,'mudokynangUIT'=>$mudokynangUIT,'chuan_abet'=>$chuan_abet,
        'ppGiangDay'=>$ppgd,'hocPhan_ppGiangDay'=>$hp_ppgd,
        'noidung'=>$noidung,'loaiDG'=>$loaiDG, 'mucDoDG'=>$mucDoDG,
        'loaiHTDG'=>$loaiHTDG,'hocPhan_loaiHTDG'=>$hocPhan_loaiHTDG]);
    }
}
