<?php

namespace App\Http\Controllers\GiaoVu;

use Illuminate\Http\Request;
use App\Imports\dsSinhVienImport;
use App\Http\Controllers\Controller;

class dsSinhVienImportController extends Controller
{
    public function import(Request $request)
    {
        if($request->has('file')){
          
            $file=$request->file('file')->store('import');
            $import=new dsSinhVienImport();
            $import->import($file);
        }
        return back();
    }

    public function download_template()
    {
        return response()->download(storage_path('template_list_students.xlsx'));
    }
}
