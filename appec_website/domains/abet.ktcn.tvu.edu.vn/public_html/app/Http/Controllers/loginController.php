<?php

namespace App\Http\Controllers;

use Session;
use App\Models\users;
use App\Models\hocPhan;
use App\Models\cdr3_abet;
use App\Models\giangVien;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\phuongAnTuLuan;
use App\Models\tieuChiChamDiem;
use App\Models\phuongAnTracNghiem;
use App\Http\Controllers\CommonController;

class loginController extends Controller
{
    public function index()
    {
        //    $hocPhan=hocPhan::pluck('maHocPhan');
        //    $hp_kqht=tieuChiChamDiem::all();
        //    foreach ($hp_kqht as $key => $value) {
        //        $cdr3_abet=cdr3_abet::where('maCDR3',$value->maCDR3)->first();
        //        if($cdr3_abet){
        //             $value->maChuanAbet=$cdr3_abet->maChuanAbet;
        //             $value->update();
        //        }
        //    }
        // foreach ($hp_kqht as $key => $value) {
        //     if(hocPhan_kqHTHP::where('maHocPhan',$value->maHocPhan)
        //     ->where('maKQHT',$value->maKQHT)->where('maCDR3',$value->maCDR3)
        //     ->where('maChuanAbet',$value->maChuanAbet)
        //     ->count(['maHocPhan'])>1)
        //     {
        //          $value->delete();
        //     }
        // }
        //return $hp_kqht;

        //duyet qua bang
        // $pa_tn=phuongAnTuLuan::all();
        // foreach ($pa_tn as $pa) {
        //     if($pa->maCDR3!=null){
        //         $cdr3_abet=cdr3_abet::where('maCDR3',$pa->maCDR3)->first();
        //         if($cdr3_abet){
        //             $pa->maChuanAbet=$cdr3_abet->maChuanAbet;
        //             $pa->update();
        //         }
        //     }
        // }
        
        Session::put('language','vi');
        if(Session::get('user_permission') == 1)	
            return redirect('/quan-ly');
        if(Session::get('user_permission') == 2)
            return redirect('/giang-vien');
        if(Session::get('user_permission') == 3){
            return redirect('/giao-vu');
        }
        if(Session::get('user_permission') == 4){
            return redirect('/bo-mon');
        }
        return view('login');
    }

    public function login_submit(Request $request)
    {
      
        $Users=users::where('username',$request->username)->where('password',md5($request->password))
        ->first();
        
        if($Users){
            if ($Users->isBlock) {
                return back()->with('warning','Tài khoản đã bị khóa!!!');
            }
            Session::put('user_permission',$Users->permission);
            Session::put('user_name',$Users->username);
            if($Users->permission == 1)	 //quan tri
                return redirect('/quan-ly'); 
            if($Users->permission == 2){  //giang vien
                $gv=giangVien::where('username',$request->username)->first();
                Session::put('maGV',$gv->maGV);
                Session::put('hoGV',$gv->hoGV);
                Session::put('tenGV',$gv->tenGV);
                return redirect('/giang-vien');
            }    
            if($Users->permission== 3){   //giao vu
                return redirect('/giao-vu');
            }
            if($Users->permission==4){//bo mon
                return redirect('/bo-mon');
            }
       }
       return back()->with('warning','Đăng nhập không thành công!!!');

    }

    public function logout()
    {
        $lang=Session::get('language');
        Session::flush();
        Session::put('language', $lang);
        return redirect('/dang-nhap');
    }
}
