<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\he;
use Illuminate\Http\Request;
use SweetAlert;

class heController extends Controller
{
    public function index(Type $var = null)
    {
        $he=he::where('isDelete',false)->orderBy('maHe','desc')->get();
        return view('admin.he',['he'=>$he]);
    }

    public function them(Request $request)
    {
        try {
            $he=he::updateOrCreate(['maHe'=>$request->maHe],['tenHe'=>$request->tenHe,'isdelete'=>false]);
            alert()->success('Added successfully', 'Message')->persistent('Close');
            return redirect('/quan-ly/he');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Can not add this entry');
            return redirect('/quan-ly/he');
        }
    }

    public function sua(Request $request)
    {
        try {
            $he=he::updateOrCreate(['maHe'=>$request->maHe],['tenHe'=>$request->tenHe,'isdelete'=>false]);
            alert()->success('Updated successfully', 'Message');
            return redirect('/quan-ly/he');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Update failed');
            return redirect('/quan-ly/he');
        }
    }
    
    
    public function xoa_he($maHe)
    {
        try {
            $he=he::updateOrCreate(['maHe'=>$maHe],['isDelete'=>true]);
            alert()->success('Deleted successful', 'Message');
            return redirect('/quan-ly/he');
        } catch (\Throwable $th) {
            alert()->error('Error:'.$th, 'Delete failed');
            return redirect('/quan-ly/he');
        }
    }
}
