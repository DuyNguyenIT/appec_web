<?php

namespace App\Http\Controllers\Admin;

use App\Models\CDR1;
use App\Models\CDR2;
use App\Models\CDR3;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Session;

class chuanDauRaController extends Controller
{
    public function index(Type $var = null)
    {
        $cdr1=CDR1::where('isDelete',false)
        ->get();
        return view('admin.chuandaura.chuanDR1',['chuandaura'=>$cdr1]);
    }
 ////-----------------chuẩn đầu ra 1
    public function them_cdr_submit(Request $request)
    {
        try {
            $cdr=CDR1::create($request->all());
            return redirect('/quan-ly/chuan-dau-ra')->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/chuan-dau-ra')->with('warning','Lỗi: '.$th);
        }
    }

    public function sua_cdr_submit(Request $request)
    {
        try {
            $cdr=CDR1::where('maCDR1',$request->maCDR1)->first();
            $cdr->maCDR1VB=$request->maCDR1VB;
            $cdr->tenCDR1=$request->tenCDR1;
            $cdr->update();
            return redirect('/quan-ly/chuan-dau-ra')->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/chuan-dau-ra')->with('warning','Lỗi: '.$th);
        }
    }

    public function xoa_cdr_submit($maCDR1)
    {
        try {
            $cdr=CDR1::where('maCDR1',$maCDR1)->first();
            $cdr->isdelete=false;
            $cdr->update();
            return redirect('/quan-ly/chuan-dau-ra')->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/chuan-dau-ra')->with('warning','Lỗi: '.$th);
        }
    }

//////------------------chuẩn đầu ra 2
    public function chuanDR2($maCDR1)
    {
        Session::put('maCDR1', $maCDR1);
        $cdr2=CDR2::where('cdr_cd2.isDelete',false)
        ->where('cdr_cd2.maCDR1',$maCDR1)
        ->leftjoin('cdr_cd1',function($x){
            $x->on('cdr_cd1.maCDR1','=','cdr_cd2.maCDR1')
            ->where('cdr_cd1.isDelete',false);
        })
        ->get();
        return view('admin.chuandaura.chuanDR2',['chuandaura2'=>$cdr2]);
    }

    public function them_cdr2_submit(Request $request)
    {
        try {
            //code...
            $cdr2=new CDR2();
            $cdr2->maCDR2VB=$request->maCDR2VB;
            $cdr2->tenCDR2=$request->tenCDR2;
            $cdr2->maCDR1=$request->maCDR1;
            $cdr2->save();
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'))->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'))->with('warning','Lỗi: '.$th);
        }
    }

    public function sua_cdr2_submit(Request $request)
    {
        try {
            $cdr2=CDR2::where('maCDR2',$request->maCDR2)->first();
            $cdr2->maCDR2VB=$request->maCDR2VB;
            $cdr2->tenCDR2=$request->tenCDR2;
            $cdr2->maCDR1=$request->maCDR1;
            $cdr2->update();
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'))->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'))->with('warning','Lỗi: '.$th);
        }
    }

    public function xoa_cdr2_submit($maCDR2)
    {
        try {
            $cdr2=CDR2::where('maCDR2',$maCDR2)->first();
            $cdr2->isdelete=false;
            $cdr2->update();
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'))->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'))->with('warning','Lỗi: '.$th);
        }
    }

    ////--------------chuẩn đầu ra 3
    public function chuanDR3($maCDR2)
    {
        try {
            Session::put('maCDR2', $maCDR2);
            $cdr3=CDR3::where('cdr_cd3.isDelete',false)
            ->where('cdr_cd3.maCDR2',$maCDR2)
            ->leftjoin('cdr_cd2',function($x){
                $x->on('cdr_cd2.maCDR2','=','cdr_cd3.maCDR2')
                ->where('cdr_cd2.isDelete',false);
            })
            ->get();
            return view('admin.chuandaura.chuanDR3',['chuandaura3'=>$cdr3]);
        } catch (\Throwable $th) {
            return redirect('/quan-ly/chuan-dau-ra')->with('warning','Lỗi: '.$th);
        }
    }

    public function them_cdr3_submit(Request $request)
    {
        try {
            $cdr3=new CDR3();
            $cdr3->maCDR3VB=$request->maCDR3VB;
            $cdr3->tenCDR3=$request->tenCDR3;
            $cdr3->maCDR2=$request->maCDR2;
            $cdr3->save();
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR3'))->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR3'))->with('warning','Lỗi: '.$th);
        }
    }

    public function sua_cdr3_submit(Request $request)
    {
        try {
            $cdr3=CDR3::where('maCDR3',$request->maCDR3)->first();
            $cdr3->maCDR3VB=$request->maCDR3VB;
            $cdr3->tenCDR3=$request->tenCDR3;
            $cdr3->maCDR2=$request->maCDR2;
            $cdr3->update();
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR3'))->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR3'))->with('warning','Lỗi: '.$th);
        }
    }

    public function xoa_cdr3_submit($maCDR3)
    {
        try {
            $cdr3=CDR3::where('maCDR3',$maCDR3)->first();
            $cdr3->isdelete=false;
            $cdr3->update();
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR3'))->with('success','Thêm thành công!');
        } catch (\Throwable $th) {
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR3'))->with('warning','Lỗi: '.$th);
        }
    }
}
