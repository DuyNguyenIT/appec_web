<?php

namespace App\Http\Controllers\Admin;

use App\Models\he;
use App\Models\CDR1;
use App\Models\nganh;
use App\Models\cNganh;
use App\Models\hocPhan;
use App\Models\ctDaoTao;
use App\Models\bacDaoTao;
use App\Models\ppGiangDay;
use App\Models\loaiHocPhan;
use App\Models\khoiKienThuc;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class homeController extends Controller
{
    public function index()
    {
        $education_level=bacDaoTao::where('isDelete',false)->count();
        $majors=nganh::where('isDelete',false)->count();
        $specialized=cNganh::where('isDelete',false)->count();
        $forms_of_planning=he::where('isDelete',false)->count();
        $curriculums=ctDaoTao::where('isDelete',false)->count();
        $lv1_students_outcomes=CDR1::where('isDelete',false)->count();
        $course_type=loaiHocPhan::where('isDelete',false)->count();
        $course=hocPhan::where('isDelete',false)->count();
        $knowledge_block=khoiKienThuc::where('isDelete',false)->count();
        $teaching_method=ppGiangDay::where('isDelete',false)->count();
        return view('admin.home', compact('education_level','majors','specialized',
        'forms_of_planning','curriculums','lv1_students_outcomes',
        'course_type','course','knowledge_block','teaching_method'));

    }
}