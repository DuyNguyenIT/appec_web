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
    public function index()
    {
        $cdr1=CDR1::where('isDelete',false)
        ->get();
        return view('admin.chuandaura.chuanDR1',['chuandaura'=>$cdr1]);
    }
 ////-----------------chu&#7849;n &#273;&#7847;u ra 1 PTTMai c� s&#7917;a
 public function them_cdr_submit(Request $request)
 {
     try {
         $cdr=CDR1::create($request->all());
         alert()->success('Added successfully', 'Message')->persistent('Close');
         return redirect('/quan-ly/chuan-dau-ra');
     } catch (\Throwable $th) {
         alert()->error('Error:'.$th, 'Can not add this entry');
         return redirect('/quan-ly/chuan-dau-ra');
     }
 }

 public function sua_cdr_submit(Request $request)
 {
     try {
         $cdr=CDR1::where('maCDR1',$request->maCDR1)->first();
         $cdr->maCDR1VB=$request->maCDR1VB;
         $cdr->tenCDR1=$request->tenCDR1;
         $cdr->tenCDR1EN=$request->tenCDR1EN;
         $cdr->update();
         //return redirect('/quan-ly/chuan-dau-ra')->with('success','Th�m th�nh c�ng!');
         alert()->success('Updated successfully', 'Message')->persistent('Close');;
         return redirect('/quan-ly/chuan-dau-ra');
     } catch (\Throwable $th) {
         alert()->error('Error:'.$th, 'Update failed')->persistent('Close');;
         return redirect('/quan-ly/chuan-dau-ra');
         //return redirect('/quan-ly/chuan-dau-ra')->with('warning','L&#7895;i: '.$th);
     }
 }

 public function xoa_cdr_submit($maCDR1)
 {
     try {
         $cdr=CDR1::where('maCDR1',$maCDR1)->first();
         $cdr->isdelete=true;
         $cdr->update();
         alert()->success('Deleted successful', 'Message') ->persistent('Close');;
         return redirect('/quan-ly/chuan-dau-ra');
     } catch (\Throwable $th) {
         alert()->error('Error:'.$th, 'Delete failed') ->persistent('Close');;
         return redirect('/quan-ly/chuan-dau-ra');
     }
 }

//////------------------chu&#7849;n &#273;&#7847;u ra 2
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
            $cdr2->tenCDR2EN=$request->tenCDR2EN;
            $cdr2->maCDR1=Session::get('maCDR1');
            $cdr2->save();
            alert()->success('Added successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'));
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Can not add this entry');
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'));
        }
    }

    public function sua_cdr2_submit(Request $request)
    {
        try {
            $cdr2=CDR2::where('maCDR2',$request->maCDR2)->first();
            $cdr2->maCDR2VB=$request->maCDR2VB;
            $cdr2->tenCDR2=$request->tenCDR2;
            $cdr2->tenCDR2EN=$request->tenCDR2EN;
            $cdr2->maCDR1=Session::get('maCDR1');
            $cdr2->update();
            alert()->success('Updated successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'));
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Update failed')->persistent('Close');
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'));
        }
    }

    public function xoa_cdr2_submit($maCDR2)
    {
        try {
            $cdr2=CDR2::where('maCDR2',$maCDR2)->first();
            $cdr2->isdelete=true;
            $cdr2->update();
            alert()->success('Deleted successful', 'Message') ->persistent('Close');;
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'));
           
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Delete failed') ->persistent('Close');;
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-2/'.Session::get('maCDR1'));
            
        }
    }

    ////--------------chu&#7849;n &#273;&#7847;u ra 3
    public function chuanDR3($maCDR2)
    {
            Session::put('maCDR2', $maCDR2);
            $cdr3=CDR3::where('cdr_cd3.isDelete',false)
            ->where('cdr_cd3.maCDR2',$maCDR2)
            ->leftjoin('cdr_cd2',function($x){
                $x->on('cdr_cd2.maCDR2','=','cdr_cd3.maCDR2')
                ->where('cdr_cd2.isDelete',false);
            })
            ->get();
            $cdr1=CDR2::where('cdr_cd2.isDelete',false)
            ->where('cdr_cd2.maCDR2',$maCDR2)
            ->leftjoin('cdr_cd1',function($x){
                $x->on('cdr_cd1.maCDR1','=','cdr_cd2.maCDR1')
                ->where('cdr_cd1.isDelete',false);
            }) 
            ->first();

            return view('admin.chuandaura.chuanDR3',['chuandaura3'=>$cdr3,'cdr1'=>$cdr1]);
    }

    public function them_cdr3_submit(Request $request)
    {
        try {
            $cdr3=new CDR3();
            $cdr3->maCDR3VB=$request->maCDR3VB;
            $cdr3->tenCDR3=$request->tenCDR3;
            $cdr3->tenCDR3EN=$request->tenCDR3EN;
            $cdr3->maCDR2=Session::get('maCDR2');
            $cdr3->save();
            alert()->success('Added successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR2'));
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Can not add this entry');
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR2'));
        }
    }

    public function sua_cdr3_submit(Request $request)
    {
        try {
            $cdr3=CDR3::where('maCDR3',$request->maCDR3)->first();
            $cdr3->maCDR3VB=$request->maCDR3VB;
            $cdr3->tenCDR3=$request->tenCDR3;
            $cdr3->tenCDR3EN=$request->tenCDR3EN;
            $cdr3->maCDR2=Session::get('maCDR2');
            $cdr3->update();
            alert()->success('Updated successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR2'));
            
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Update failed')->persistent('Close');
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR2'));
        }
    }

    public function xoa_cdr3_submit($maCDR3)
    {
        try {
            $cdr3=CDR3::where('maCDR3',$maCDR3)->first();
            $cdr3->isdelete=true;
            $cdr3->update();
            alert()->success('Deleted successful', 'Message') ->persistent('Close');;
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR2'));
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Delete failed') ->persistent('Close');;
            return redirect('/quan-ly/chuan-dau-ra/chuan-dau-ra-3/'.Session::get('maCDR2'));
        }
    }
}
