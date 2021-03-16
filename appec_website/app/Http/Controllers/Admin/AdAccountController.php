<?php

namespace App\Http\Controllers\Admin;

use App\Models\users;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class AdAccountController extends Controller
{
    public function index()
    {
        $users=users::all();
        return view('admin.taikhoan',compact('users'));
    }

    public function them(Request $request)
    {
        $user=users::find($request->username)->first();
        if($user){
            alert()->warning('Username is used', 'Message')->persistent('Close');
            return back();
        }
        users::create(['username'=>$request->username,'email'=>$request->email,'password'=>md5($request->password),
        'permission'=>$request->permission,'isBlock'=>$request->isBlock,'isDelete'=>false]);
        alert()->success('Added successfully', 'Message')->persistent('Close');
        return back();
    }

    public function sua(Request $request)
    {
       
        users::updateOrCreate(['username'=>$request->username],['email'=>$request->email,'password'=>md5($request->password),
        'permission'=>$request->permission,'isBlock'=>$request->isBlock,'isDelete'=>false]);
        alert()->success('Edited successfully', 'Message')->persistent('Close');
        return back();
    }

    public function xoa($username)
    {
        users::updateOrCreate(['username'=>$username],['isDelete'=>true]);
        alert()->success('Edited successfully', 'Message')->persistent('Close');
        return back();

    }

    public function khoa($username)
    {
        users::updateOrCreate(['username'=>$username],['isBlock'=>true]);
        alert()->success('Locked successfully', 'Message')->persistent('Close');
        return back();
    }

    public function mo_khoa($username)
    {
        users::updateOrCreate(['username'=>$username],['isBlock'=>false]);
        alert()->success('Unlocked successfully', 'Message')->persistent('Close');
        return back();
    }
}
