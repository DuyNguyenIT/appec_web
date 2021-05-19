<?php

namespace App\Http\Controllers;

use App\Models\giangVien;
use App\Models\users;
use Illuminate\Http\Request;
use Session;

class loginController extends Controller
{
    public function index()
    {
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
            if($Users->permission == 1)	 //quản trị
                return redirect('/quan-ly'); 
            if($Users->permission == 2){  //giảng viên
                $gv=giangVien::where('username',$request->username)->first();
                Session::put('maGV',$gv->maGV);
                Session::put('hoGV',$gv->hoGV);
                Session::put('tenGV',$gv->tenGV);
                return redirect('/giang-vien');
            }    
            if($Users->permission== 3){   //giáo vụ
                return redirect('/giao-vu');
            }
            if($Users->permission==4){//bộ môn
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
