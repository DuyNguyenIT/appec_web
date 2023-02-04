<?php

namespace App\Http\Controllers\giangvien;

use Session;
use App\Models\raDe;
use App\Models\deThi;
use App\Models\cauHoi;
use App\Models\chuong;
use App\Models\hocPhan;
use App\Models\phieu_cham;
use App\Models\deThi_cauHoi;
use Illuminate\Http\Request;
use App\Models\phuongAnTracNghiem;
use App\Http\Controllers\Controller;
use App\Http\Controllers\CommonController;

class GVDeThiTracNghiemController extends Controller
{    
    //-------OK
    public function them_de_thi_trac_nghiem_submit (Request $request)//thêm tiêu đèn, ngày thi, giờ thi,...
    {
        //thay viet code
        $madevb1= deThi::where('maDeVB',$request->maDeVB)->where('maCTBaiQH',Session::get('maCTBaiQH'))->first();
        // return $madevb1;
         if($madevb1)
         {
             CommonController::warning_notify('Mã đề bị trùng!!!!','Duplicate exam code!!!!');
             return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
         }
         //--thay viet code
        deThi::create(['maDeVB'=>$request->maDeVB,'soCauHoi'=>$request->soCauHoi,'tenDe'=>$request->tenDe,'thoiGian'=>$request->thoiGian,'ghiChu'=>$request->ghiChu,'maCTBaiQH'=>Session::get('maCTBaiQH')]);
        $dethi=deThi::orderBy('maDe','desc')->first();
        raDe::create(['maDe'=>$dethi->maDe,'maGV'=>session::get('maGV'),'maHocPhan'=>session::get('maHocPhan'),'maLop'=>session::get('maLop')]);
        CommonController::success_notify('Thêm thành công!!','Added successfully');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
    }

    //--------------OK
    public function chinh_sua_thong_tin_de(Request $request)
    {
        if($request==null){
            CommonController::warning_notify('Không tìm thấy đề thi!!','Do not found the examination');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }
        else{
            $soCauHoi=deThi_cauHoi::where('maDe',$request->maDe)->count('maCauHoi');
            if ($soCauHoi>$request->soCauHoi) {
                CommonController::warning_notify('Đề thi hiện có '.$soCauHoi.', không thể ít hơn!!','The examination must be at least '.$soCauHoi.' questions!');
                return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
            } else {
                deThi::updateOrCreate(['maDe'=>$request->maDe],['maDeVB'=>$request->maDeVB,'soCauHoi'=>$request->soCauHoi,
                'thoiGian'=>$request->thoiGian,'ghiChu'=>$request->ghiChu]);
                CommonController::success_notify('Sửa thành công!!','Edited successfully');
                return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
            }
        }
    }

    //---------------OK
    public function xoa_de_thi($maDe)
    {
        //neu co noi dung, khong the xoa
        if(phieu_cham::where('maDe',$maDe)->count('maDe')>0)
        {
            CommonController::warning_notify('Đề thi đã được sử dụng, không thể xóa!!','The examination is used, can not delete');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }
        else
        {
            deThi_cauHoi::where('maDe',$maDe)->delete();
            deThi::where('maDe',$maDe)->delete();
            CommonController::success_notify('Xóa thành công!!','Deleted successfully');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/'.Session::get('maCTBaiQH'));
        }
        
    }

    //them de thi trac nghiem moi----OK
    public function them_de_thi_trac_nghiem()
    {
        return view('giangvien.quyhoach.quyhoach2');
    }
   
    //--------OK
    public function cau_truc_de_trac_nghiem(Request $request,$maDe) //dẫn đến view cấu trúc đề thi----OK
    {
        Session::put('maDe',$maDe);
        #thông tin học phần
        $hocphan=hocPhan::where('maHocPhan',Session::get('maHocPhan'))->first();

        #thong tin chuong
        $chuong=chuong::get_chuong_by_maHocPhan($hocphan->maHocPhan);
          
        #thông tin mục
        $muc=hocPhan::get_muc_by_maHocPhan(Session::get('maHocPhan'));
         
        #thông tin đề thi
        $dethi=deThi::where('isDelete',false)->where('maDe',$maDe)->first();
        #thông tin chuẩn đầu ra  
        $cdr3=hocPhan::get_cdr_by_maHocPhan(Session::get('maHocPhan'));
          #nội dung đề thi tự luận
          $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
          ->join('de_thi_cau_hoi','de_thi_cau_hoi.maDe','=','de_thi.maDe')
          ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
          ->distinct('cau_hoi.maCauHoi')

          ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
          #tính điểm câu hỏi
          $letter=['A','B','C','D'];
          for ($i=0; $i <count($noidung) ; $i++) { 
              # code...
              $diem=deThi_cauHoi::where('maCauHoi',$noidung[$i]->maCauHoi)->where('maDe',$maDe)->get('diem');
              $noidung[$i]->diem=$diem[0]['diem'];
              $noidung[$i]->phuong_an=phuongAnTracNghiem::where('maCauHoi',$noidung[$i]->maCauHoi)->get();
              for ($j=0; $j <count($noidung[$i]->phuong_an) ; $j++) { 
                if(substr($noidung[$i]->phuong_an[$j]->noiDungPA, 0, 3) === '<p>'){
                    $noidung[$i]->phuong_an[$j]->noiDungPA=substr_replace($noidung[$i]->phuong_an[$j]->noiDungPA, $letter[$j].'. ', 3, 0);
                }else{
                    $noidung[$i]->phuong_an[$j]->noiDungPA = $letter[$j].'. '.$noidung[$i]->phuong_an[$j]->noiDungPA;
                }            
              }
          }
          #dem so cau hoi hien co
          $dem_cau_hoi=deThi_cauHoi::where('maDe',$maDe)->count('maCauHoi');
          ##tạo mảng các câu hỏi đã chọn->chỉ duyệt những câu hỏi chưa được chọn
        $cauhoidachon=deThi_cauHoi::where('maDe',$maDe)->distinct('maCauHoi')->pluck('maCauHoi');
        #thông tin câu hỏi
        $cauhoi=[];
        foreach ($muc as  $value) {
            $temp=cauHoi::where('isdelete',false)->where('maGV',session::get('maGV'))->where('id_muc',$value->id)
            ->where('maLoaiHTDG','T2')->whereNotIn('maCauHoi',$cauhoidachon)->with('phuong_an_trac_nghiem')->get();
            for ($i=0; $i < count($temp) ; $i++) { 
                for ($j=0; $j < count($temp[$i]->phuong_an_trac_nghiem); $j++) { 
                    $temp[$i]->phuong_an_trac_nghiem[$j]->noiDungPA=substr_replace($temp[$i]->phuong_an_trac_nghiem[$j]->noiDungPA, $letter[$j].'. ', 3, 0);
                }
            }
           
            foreach ($temp as $ch) {
                array_push($cauhoi,$ch);
            }
        }
       
        #phản hồi kết quả
        return view('giangvien.quyhoach.noidungdanhgia.tracnghiem.cautrucde',
        compact('dethi','hocphan','cauhoi','cdr3','noidung','chuong','muc','dem_cau_hoi'));
    }

   
    public function them_cau_hoi_de_trac_nghiem(Request $request) //nhấn nút thêm câu hỏi vào đề thi
    {
        $maDe=Session::get('maDe');
        if($request==null){  //chua chon cau hoi
            CommonController::warning_notify('Chưa chọn câu hỏi!','Please choice a questions');
            return '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.Session::get('maDe');
        }
       
        $dethi=deThi::where('maDe',Session::get('maDe'))->first();
        
        if($dethi){
            //kiem tra cau hoi da duoc su dung trong de thi
            $diem=number_format(10/$dethi->soCauHoi,2);
           
            $dem_cau_hoi=deThi_cauHoi::where('maDe',Session::get('maDe'))->count();
           
            if($dem_cau_hoi==$dethi->soCauHoi){//de thi da du so cau hoi
                CommonController::warning_notify('Đề thi đã đủ số câu hỏi!','The examination is enough question!');
                return '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.Session::get('maDe');
            }else{
                $demCauHoiDaThem=0;
               
                foreach ($request->array as  $value) {
                    //neu cau hoi da duoc su dung thi khong them
                    $check_ques=deThi_cauHoi::where('maDe',Session::get('maDe'))->where('maCauHoi',$value['id'])->count();
                  
                    if($check_ques>0){
                        continue;
                    }
                    deThi_cauHoi::create(['maDe'=>Session::get('maDe'),'maCauHoi'=>$value['id'],'diem'=>$diem]);
                    $demCauHoiDaThem+=1;
                    $dem_cau_hoi=deThi_cauHoi::where('maDe',Session::get('maDe'))->count();
                    if($dem_cau_hoi==$dethi->soCauHoi){
                        break;
                    }
                }
                CommonController::success_notify('Đã thêm '.$demCauHoiDaThem.' câu hỏi!','Added '.$demCauHoiDaThem.' questions!');
                return '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.Session::get('maDe');
            }
        }else{
            CommonController::warning_notify('Không tìm thấy đề thi!','There are not examination!');
        }
        return '/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.Session::get('maDe');
    }

    public function xoa_cau_hoi_de_trac_nghiem($maCauHoi) //oK
    {
        $maDe=Session::get('maDe');
        if(phieu_cham::where('maDe',$maDe)->count('maDe')>0){
            CommonController::warning_notify('Đề thi đã được sử dụng, không thể xóa câu hỏi!','The examination is used, can not delete!');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.Session::get('maDe'));

        }
        $ch=deThi_cauHoi::where('maCauHoi',$maCauHoi)->where('maDe',$maDe)->delete();
        CommonController::success_notify('Xóa thành công!','Delete successfully!');
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.Session::get('maDe'));

    }

    public function xoa_nhieu_cau_hoi_de_trac_nghiem(Request $request)
    {
        if(phieu_cham::where('maDe',Session::get('maDe'))->count('maDe')>0){
            CommonController::warning_notify('Đề thi đã được sử dụng, không thể xóa câu hỏi!','The examination is used, can not delete!');
            return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.Session::get('maDe'));
        }

        if($request->select_all){
            foreach ($request->select_all as $maCauHoi) {
                deThi_cauHoi::where('maCauHoi',$maCauHoi)->where('maDe',Session::get('maDe'))->delete();
            }
            CommonController::success_notify('Xóa thành công!','Delete successfully!');
        }
       
        return redirect('/giang-vien/quy-hoach-danh-gia/noi-dung-danh-gia/xem-noi-dung-danh-gia/cau-truc-de-trac-nghiem/'.Session::get('maDe'));

    }
    
}
