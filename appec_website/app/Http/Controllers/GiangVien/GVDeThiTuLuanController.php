<?php

namespace App\Http\Controllers\giangvien;

use Session;
use App\Models\raDe;
use App\Models\deThi;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\hocPhan;
use App\Models\cdr3_abet;
use App\Models\chuan_abet;
use App\Models\phieu_cham;
use Illuminate\Http\Request;
use App\Models\danhgia_tuluan;
use App\Models\phuongAnTuLuan;
use App\Models\dethi_cauhoituluan;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

class GVDeThiTuLuanController extends Controller
{
    //////////////////////////////////////////////////////////////////////////////////////
    ///////////////////////////////KHU VỰC HÀM CHO TỰ LUẬN////////////////////////////////
    //////////////////////////////////////////////////////////////////////////////////////

    public function them_de_thi_tu_luan_submit(Request $request)  //thêm tiêu đèn, ngày thi, giờ thi,...
    {   
        //thay viet code
        $madevb1= deThi::where('maDeVB',$request->maDeVB)->where('maCTBaiQH',Session::get('maCTBaiQH'))->first();
       // return $madevb1;
        if($madevb1)
        {
            CommonController::warning_notify('Mã đề bị trùng!!!!','Duplicate exam code!!!!');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }
        //thay viet code
        deThi::create(['maDeVB'=>$request->maDeVB,'soCauHoi'=>$request->soCauHoi,'tenDe'=>$request->tenDe,'thoiGian'=>$request->thoiGian,'ghiChu'=>$request->ghiChu,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
        $dethi=deThi::orderBy('maDe','desc')->first();
        raDe::create(['maDe'=>$dethi->maDe,'maGV'=>session::get('maGV'),'maHocPhan'=>session::get('maHocPhan'),'maLop'=>session::get('maLop')]);
        CommonController::success_notify('Thêm thành công!!','Added successfully');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
    }

    public function cau_truc_de_luan(Request $request,$maDe) //hàm  này hiển thị đề thi dưới dạng cấu hình
    {
        Session::put('maDe',$maDe);
        #thông tin học phần
        $hocphan=hocPhan::where('maHocPhan',Session::get('maHocPhan'))->first();
        #thông tin đề thi
        $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)->first();
        #thông tin mục
        $muc=hocPhan::get_muc_by_maHocPhan(Session::get('maHocPhan'));
       
        #thông tin chuẩn đầu ra  
        $cdr3=hocPhan::get_cdr_by_maHocPhan(Session::get('maHocPhan'));

        #nội dung đề thi tự luận
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->Leftjoin('de_thi_cauhoi_tuluan','de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe')
        ->Leftjoin('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        //->Leftjoin('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
        

        ##tính điểm câu hỏi
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
            ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->sum('phuong_an_tu_luan.diemPA');

            $phuongAnTL=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
            ->where('de_thi_cauhoi_tuluan.maDe',$maDe)
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->join('cdr_cd3','phuong_an_tu_luan.maCDR3','=','cdr_cd3.maCDR3')
            ->join('chuan_abet','phuong_an_tu_luan.maChuanAbet','=','chuan_abet.maChuanAbet')
            ->get();
            $noidung[$i]->diem=$diem;  
            $noidung[$i]->phuongAn=$phuongAnTL;
        }

        ##tạo mảng các câu hỏi đã chọn->chỉ duyệt những câu hỏi chưa được chọn
        $cauhoidachon=dethi_cauhoituluan::where('maDe',$maDe)->distinct('maCauHoi')->pluck('maCauHoi');
         #thông tin câu hỏi
         
         $cauhoi=[];
         foreach ($muc as  $value) {
             $temp=cauHoi::where('isdelete',false)->where('maGV',session::get('maGV'))->where('id_muc',$value->id)
             ->where('maLoaiHTDG','T1')->whereNotIn('maCauHoi',$cauhoidachon)->get();
             foreach ($temp as $ch) {
                 array_push($cauhoi,$ch);
             }
         }
        #combobox abet
        $abet=chuan_abet::all();
        
        //dem cau hoi
        $dem_cau_hoi=dethi_cauhoituluan::where('maDe',$maDe)->distinct('maCauHoi')->count('maCauHoi');
          #thong tin chuong
        $chuong=chuong::get_chuong_by_maHocPhan($hocphan->maHocPhan);
          
        #thông tin mục
        $muc=hocPhan::get_muc_by_maHocPhan(Session::get('maHocPhan'));
         #phản hồi kết quả
        return view('giangvien.quyhoach.noidungdanhgia.tuluan.cautrucde',
        compact('dethi','hocphan','cauhoi','cdr3','noidung','abet','dem_cau_hoi','chuong','muc'));
    }

    public function them_cau_hoi_de_luan(Request $request) //hàm này thêm câu hỏi vào đề thi tự luận
    {
        $maDe=Session::get('maDe');
        if($request->maCauHoi==null){
            CommonController::warning_notify('Không tìm thấy câu hỏi!','Question ID is null');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$maDe);
        }
        $index=0;
        $maDe=$request->maDe;
        //kiem tra cau hoi da them roi
        if(dethi_cauhoituluan::where('maDe',$maDe)->where('maCauHoi',$request->maCauHoi)->count('maCauHoi')>0){
            CommonController::warning_notify('Câu hỏi đã tồn tại!','The question is exist');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$maDe);
        }
        //kiem tra neu de thi du so cau hoi thi khong them
        if(deThi::where('maDe',$maDe)->first()->soCauHoi==dethi_cauhoituluan::where('maDe',$maDe)->distinct(['maDe','maCauHoi'])->count('maCauHoi')){
            CommonController::warning_notify('Đề thi đã đủ số câu hỏi!','The examination is enough question');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$maDe);
        }
        //kiem tra neu da du diem thi khong cho them
        
        //duyêt mảng phương án
        for ($i=0; $i < count($request->phuongAn); $i++) { 
            //tim su tuong quan cdr3 va abet
            $cdr3_abet=cdr3_abet::where('maCDR3',$request->maCDR3)->first();
            $maChuanAbet = ($cdr3_abet) ? $cdr3_abet->maChuanAbet : 1 ;
            phuongAnTuLuan::create(['noiDungPA'=>$request->phuongAn[$i],'diemPA'=>$request->diem[$i],'maCDR3'=>$request->maCDR3,'maChuanAbet'=>$maChuanAbet]);
            # lưu maCauHoi, maDe, maPhuongAn vào nội dung đề thi
            $pa=phuongAnTuLuan::orderBy('id','desc')->first();
            dethi_cauhoituluan::create(['maDe'=>$maDe,'maCauHoi'=>$request->maCauHoi,'maPATL'=>$pa->id]);
          
        }
        CommonController::success_notify('Thêm thành công!','Adding successfully');
        return back();
    }

    public function xoa_cau_hoi_de_tu_luan(Request $request,$maDe,$maCauHoi)
    {
      
        //kiem tra neu cau hoi da duoc su dung trong phieu cham thi khong the xoa
        //maDe->maPhieuCham?
        if(count(phieu_cham::where('maDe',$maDe)->get())>0){
            CommonController::warning_notify('Đề thi đã được sử dụng, không thể xóa câu hỏi!','The examination is being used, you can not delete question');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$maDe);
        }
        $cauhoi=dethi_cauhoituluan::where('maDe',$maDe)->where('maCauHoi',$maCauHoi)->get();
        if($cauhoi){
            foreach ($cauhoi as $ch) {
                # code...
                 //kiem tra neu co phuong an duoc su dung trong phieu cham thi khong cho xoa
                if($ch){
                    $phuong_an=phuongAnTuLuan::where('id',$ch->maPATL)->get();
                    foreach($phuong_an as $pa){
                        if(danhgia_tuluan::where('maPATL',$pa->id)->count()>0){
                            CommonController::warning_notify('Có tồn tại phương án trong phiếu chấm!',"There are answers of the question in a answer sheet!");
                            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$maDe);
                        }
                    }
                }
                 
            }
           
            //dong for de xoa
            foreach ($cauhoi as $key => $ch) {
                $phuong_an=phuongAnTuLuan::where('id',$ch->maPATL)->get();
                //tien hanh xoa phuong an
                foreach($phuong_an as $pa){
                    if($pa){
                        dethi_cauhoituluan::where('maCauHoi',$ch->maCauHoi)->where('maDe',$maDe)->where('maPATL',$pa->id)->delete();
                        $pa->delete();
                    }
                }
            }
           
           
            alert()->success("Deleting successfully",'Message');
            CommonController::success_notify('Đã xóa câu hỏi!',"Deleting successfully");
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$maDe);

        }
        CommonController::warning_notify('Không tìm thấy câu hỏi!',"Can't found question");
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-tu-luan/'.$maDe);
    }

    public function chinh_sua_phuong_an_tu_luan(Request $request)
    {
        $patl=phuongAnTuLuan::find($request->id);
        if($patl){
            $patl->noiDungPA=$request->noiDungPA;
            $patl->diemPA=$request->diemPA;
            $patl->maCDR3=$request->maCDR3;
            $cdr3_abet=cdr3_abet::where('maCDR3',$request->maCDR3)->first();
            $maChuanAbet = ($cdr3_abet) ? $cdr3_abet->maChuanAbet : 1 ;
            $patl->maChuanAbet=$maChuanAbet;
            $patl->update();
        }
        return back();
    }
    

    public function cau_truc_noi_dung_de_luan(Request $request,$maDe) //hàm này tạm không dùng
    {
        $md=deThi::findOrFail($maDe);
        return view('GiangVien.quyhoach.noidungdanhgia.tuluan.cautrucnoidungdeluan');
    }

    public function sua_thong_tin_de_luan(Request $request)  //---OK
    {
        if($request==null){
            CommonController::warning_notify('Không tìm thấy đề thi!!','Do not found the examination');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }else{
            $soCauHoi=dethi_cauhoituluan::where('maDe',$request->maDe)->distinct(['maDe','maCauHoi'])->count('maCauHoi');
            if ($soCauHoi>$request->soCauHoi) {
                CommonController::warning_notify('Đề thi hiện có '.$soCauHoi.' câu hỏi, không thể ít hơn!!','The examination must be at least '.$soCauHoi.' questions!');
                return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
            } else {
                deThi::updateOrCreate(['maDe'=>$request->maDe],['maDeVB'=>$request->maDeVB,'soCauHoi'=>$request->soCauHoi,
                'thoiGian'=>$request->thoiGian,'ghiChu'=>$request->ghiChu,'tenDe'=>$request->tenDe]);

                

                CommonController::success_notify('Sửa thành công!!','Edited successfully');
                return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
            }
        }
    }

    public function xoa_de_tu_luan($maDe){    //-OK
        if($maDe){
          //kiem tra de thi da duoc su dung hay chua
          if(phieu_cham::where('maDe',$maDe)->count('maDe')>0)
          {
              CommonController::warning_notify('Đề thi đã được sử dụng, không thể xóa!!','The examination is used, can not delete');
              return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
          }else{
              dethi_cauhoituluan::where('maDe',$maDe)->delete();
              deThi::where('maDe',$maDe)->delete();
              CommonController::success_notify('Xóa thành công!!','Deleted successfully');
              return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
          }
      }else{
          CommonController::warning_notify('Không tìm thấy mã đề','Can not found id examination!');
      }
      return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
    }
}
