<?php

namespace App\Http\Controllers;

use App\Models\giangVien;
use App\Models\users;
use Illuminate\Http\Request;
use Session;

class loginController extends Controller
{
    public function index(Type $var = null)
    {
        if(Session::get('user_permission') == 1)	
            return redirect('/quan-ly');
        if(Session::get('user_permission') == 2)
            return redirect('/giang-vien');
        if(Session::get('user_permission') == 3){
            return redirect('/giao-vu');
        }
        
        return view('login');
    }

    public function login_submit(Request $request)
    {
      
        $Users=users::where('username',$request->username)
        ->where('password',md5($request->password))
        ->first();
        
        if($Users){
            Session::put('user_permission',$Users->permission);
            Session::put('user_name',$Users->username);
            if(Session::get('user_permission') == 1)	 
                return redirect('/quan-ly'); 
            if(Session::get('user_permission') == 2){
                $gv=giangVien::where('username',$request->username)->first();
                Session::put('maGV',$gv->maGV);
                Session::put('hoGV',$gv->hoGV);
                Session::put('tenGV',$gv->tenGV);

                return redirect('/giang-vien');
            }    
            if(Session::get('user_permission') == 3){  
                return redirect('/giao-vu');
            }
       }
            return back()->with('warning','Đăng nhập không thành công!!!');;

    }

    public function logout(Type $var = null)
    {
        Session::flush();
        return redirect('/dang-nhap');
    }
}
