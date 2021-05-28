<?php

namespace App\Http\Controllers;

use App\Models\CDR1;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use App\Models\monTienQuyet;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\mucDoKyNangUIT;
use App\Models\hocPhan_ppGiangDay;
use App\Models\tai_lieu_tham_khao;
use App\Http\Controllers\Controller;
use App\Models\hocPhan_loaiHTDanhGia;

class WordController extends Controller
{
    public static function in_de_cuong_mon_hoc($maHocPhan)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //t&#7841;o n&#7897;i dung file
        //format font and paragraph
        $headerForntStyle = 'rStyle';
        $phpWord->addFontStyle($headerForntStyle, array('bold' => true, 'size' => 12,'name'=>'Times New Roman', 'allCaps' => true));
        $headerparagraphStyle = 'pStyle';   

        $phpWord->addParagraphStyle($headerparagraphStyle, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $normalText='normalText';
        $phpWord->addFontStyle($normalText, array( 'size' => 12,'name'=>'Times New Roman'));
        $boldNormalText='blodNormalText';
        $phpWord->addFontStyle($boldNormalText,array('bold' => true, 'size' => 13,'name'=>'Times New Roman'));
        $headding1='headding1';
        $phpWord->addFontStyle($headding1, array( 'size' => 12,'name'=>'Times New Roman','bold' => true));

        //format table
        $fancyTableStyle = array('borderSize' => 6, 'borderColor' => '000000');
        $cellRowSpan = array('vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '14c447');
        $cellRowContinue = array('vMerge' => 'continue');
        $cellColSpan = array('gridSpan' => 2, 'valign' => 'center');
        $cellHCentered = array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER);
        $cellVCentered = array('valign' => 'center');
        
        $spanTableStyleName = 'Colspan Rowspan';
        $phpWord->addTableStyle($spanTableStyleName, $fancyTableStyle);
        
        $section = $phpWord->addSection();
        // Add first page header
        $header = $section->addHeader();
        $header->firstPage();
        $table = $header->addTable();
        $table->addRow();
        $cell = $table->addCell(4500);
        $textrun = $cell->addTextRun();
        $textrun->addText('Tra Vinh University',array('bold' => true,'italic'=>true, 'size' => 10,'name'=>'Times New Roman'),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spaceAfter' => 100));

        // Add header for all other pages
        $subsequent = $section->addHeader();
        $subsequent->addText('Tra Vinh University',array('bold' => true,'italic'=>true, 'size' => 10,'name'=>'Times New Roman'));

        // 1/ Thong tin chung
        $section->addText('COURSE SYLLABUS',$headerForntStyle,$headerparagraphStyle);
        
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)->first();  //thong tin hoc phan
        
        $hoc_phan = $section->addTextRun($headerparagraphStyle);
        $hoc_phan->addText('COURSE SYLLABUS: ',$boldNormalText);
        $hoc_phan->addText($hocPhan->tenHocPhanEN,$headerForntStyle,$headerparagraphStyle);
        
        $ma_hoc_phan = $section->addTextRun($headerparagraphStyle);
        $ma_hoc_phan->addText('COURSE ID: ',$boldNormalText);
        $ma_hoc_phan->addText($hocPhan->maHocPhan,$headerForntStyle,$headerparagraphStyle);
        ////------------------------------------------1/ thong tin chung---------------------------------------------
        $section->addText('1. General information',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));

        

        $table = $section->addTable($spanTableStyleName);

        $table->addRow(); //tieu de

        $cell1 = $table->addCell(4000, $cellRowSpan); 
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Course type',$headding1);

        $cell2 = $table->addCell(4000, $cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Number of credits ',$headding1);

        $cell3=$table->addCell(4000, $cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Number of learning periods',$headding1);

        $table->addRow();
        $cell1 = $table->addCell(4000);
        $cell1->addListItem("General ",0,$normalText);
        $cell1->addListItem("Basic",0,$normalText);
        $cell1->addListItem("Specialized",0,$normalText);

        

        $cell1 = $table->addCell(4000);
        $cell1->addListItem("Theory: ".$hocPhan->tinChiLyThuyet,0,$normalText);
        $cell1->addListItem("Exercise:",0,$normalText);
        $cell1->addListItem("Practice: ".$hocPhan->tinChiThucHanh,0,$normalText);

        $cell1 = $table->addCell(4000);
        $cell1->addListItem("Theory: ".($hocPhan->tinChiLyThuyet*15),0,$normalText);
        $cell1->addListItem("Exercise:",0, $normalText);
        $cell1->addListItem("Practice: ".($hocPhan->tinChiThucHanh*30),0,$normalText);

        $doi_tuong_hoc=$section->addTextRun();  //đối tượng học
        $doi_tuong_hoc->addText('Learners:     ',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $doi_tuong_hoc->addText('  Level: Bachelor',$normalText,array('tabs' => array(new \PhpOffice\PhpWord\Style\Tab('right', 9090))));
        //select chuyen nganh va he tu csdl
        //maHocPhan=>hocphan_ctdaotao->maCT=>ct_dao_tao->(chuyen nganh + he)
        
        $section->addText('Major:   ................ ',$normalText);
        $section->addText('Form of training:  ..............',$normalText);
        
        $section->addText('Course requirements',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $monTQ=monTienQuyet::where('maHocPhan',$maHocPhan)->where('isDelete',false)->with('hoc_phan')->get();
        $table = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table->addRow();
        $cell1 = $table->addCell(4000);
        $tenmontq ='';
        foreach ($monTQ as $mtq) {
            $tenmontq=$tenmontq.$mtq->hoc_phan->tenHocPhanEN.';';
        }

        $cell1->addText('Prerequisites',$normalText);
        $cell1 = $table->addCell(8000);
        $cell1->addText($tenmontq,$normalText);

        $table->addRow();
        $cell1 = $table->addCell(4000);
        $cell1->addText('Prerequisites:',$normalText);
        $cell1 = $table->addCell(8000);
        $html = $hocPhan->yeuCau;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell1, $html, false, false);

        // //--------------------------------------2. Taii lieu tham khao------------------------------------------------------------
      
        $section->addText('2. Learning resources',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));

        $tailieuthamkhao=tai_lieu_tham_khao::where('maHocPhan',$maHocPhan)->first();

        $table_tailieuthamkhao = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table_tailieuthamkhao->addRow();
        $cell1 = $table_tailieuthamkhao->addCell(4000);
        $cell1->addText('Prescribed textbooks',$normalText);
        $cell1 = $table_tailieuthamkhao->addCell(8000);
        $html = ($tailieuthamkhao) ? $tailieuthamkhao->giaoTrinh : "" ;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell1, $html, false, false);

        $table_tailieuthamkhao->addRow();
        $cell2 = $table_tailieuthamkhao->addCell(4000);
        $cell2->addText('Recommended textbooks',$normalText);
        $cell2 = $table_tailieuthamkhao->addCell(8000);
        $html = ($tailieuthamkhao) ? $tailieuthamkhao->thamKhaoThem : "" ;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell2, $html, false, false);
        
        $table_tailieuthamkhao->addRow();
        $cell3 = $table_tailieuthamkhao->addCell(4000);
        $cell3->addText('Other learning materials ',$normalText);
        $cell3 = $table_tailieuthamkhao->addCell(8000);
        $html = ($tailieuthamkhao) ? $tailieuthamkhao->taiLieuKhac : "" ;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell3, $html, false, false);

        //--------------------------------------3. Mo ta hoc phan------------------------------------------------------------
        
        $section->addText('3. Course description',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $html = $hocPhan->moTaHocPhan;
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        //--------------------------------------4. Chuan dau ra hoc phan------------------------------------------------------------
        $CDR1=CDR1::all();//danh sach chu de
        $kqht=hocPhan_kqHTHP::get_kqht_cdr3_abet($maHocPhan);

        $section->addText('4. Course learning outcomes (CLOs):',$headding1);
        $section->addText('After finishing the course, students will be able to:',$normalText);
        
        $table_chuandaura = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table_chuandaura->addRow();
        $table_chuandaura->addCell(1000);
        $table_chuandaura->addCell(7000);
        $cell = $table_chuandaura->addCell(2000,$cellRowSpan);
        $cell->addText('Satisfy LOs of the program');
        $cell = $table_chuandaura->addCell(2000,$cellRowSpan);
        $cell->addText('Satisfy LOs of the ABET');
       
        $index=1;
        foreach ($CDR1 as $cdr) {
            $table_chuandaura->addRow();
            $cell=$table_chuandaura->addCell(12000,array('gridSpan' => 4));
            $cell->addText('Topic '.$index.': '.$cdr->tenCDR1EN, $boldNormalText);
            foreach ($kqht as $x){
                if($x->maCDR1==$cdr->maCDR1){
                    $table_chuandaura->addRow();
                    $cell1=$table_chuandaura->addCell(1000);
                    $cell1->addText($x->maKQHTVB, $normalText);
                    $cell2=$table_chuandaura->addCell(7000);
                    $cell2->addText($x->tenKQHT, $normalText);
                    $cell3=$table_chuandaura->addCell(2000);
                    $cell3->addText($x->maCDR3VB, $normalText);
                    $cell3=$table_chuandaura->addCell(2000);
                    $cell3->addText($x->maChuanAbetVB, $normalText);
                }
            }
            $index++;
        }

        //--------------------------------------5. Noi dung hoc phan----------------------------------------------------------------
        $section->addText('5. Course content:',$headding1);
        
        #b&#7843;ng
        $table_noidunghp = $section->addTable($spanTableStyleName);
        #tieu de ban
        $table_noidunghp->addRow();
        $cell1 = $table_noidunghp->addCell(7000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Course content');

        $cell2 = $table_noidunghp->addCell(2000, $cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('CLOs');

        $cell3 = $table_noidunghp->addCell(3000, array('gridSpan' => 3, 'valign' => 'center','vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '14c447'));
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Number of learning periods');

        $table_noidunghp->addRow();
        $table_noidunghp->addCell(null, $cellRowContinue);
        $table_noidunghp->addCell(null, $cellRowContinue);
        $table_noidunghp->addCell(1000, $cellVCentered)->addText('Theory', null, $cellHCentered);
        $table_noidunghp->addCell(1000, $cellVCentered)->addText('Practice', null, $cellHCentered);
        $table_noidunghp->addCell(1000, $cellVCentered)->addText('Others', null, $cellHCentered);
        #dong noi dung
        $CDR1=CDR1::all();
        $noidung=chuong::where('chuong.isdelete',false)->where('chuong.maHocPhan',$maHocPhan)->orderBy('chuong.id','asc')
        ->with('muc')->with('chuong_kqht')->get();

        $chuong_array=chuong::where('chuong.isdelete',false)->where('chuong.maHocPhan',$maHocPhan)
        ->orderBy('chuong.id','asc')->pluck('id');
        
        $mudokynangUIT=mucDoKyNangUIT::whereIn('muc_do_ky_nang_itu.id_chuong',$chuong_array)
        ->orderBy('muc_do_ky_nang_itu.maCDR1')
        ->join('cdr_cd1','cdr_cd1.maCDR1','=','muc_do_ky_nang_itu.maCDR1')
        ->join('kqht_hp','kqht_hp.maKQHT','=','muc_do_ky_nang_itu.maKQHT')
        ->get();

        foreach ($noidung as $nd) {
            foreach ($nd->chuong_kqht as $x) {
                $temp=kqHTHP::where('maKQHT',$x->maKQHT)->first();
                $x->maKQHTVB=$temp->maKQHTVB;
                $x->tenKQHT=$temp->tenKQHT;
            }
        }

        foreach ($noidung as $data){
            $table_noidunghp->addRow();
            $cell1=$table_noidunghp->addCell(7000);
            $cell1->addText($data->tenchuong,$boldNormalText);
            $kqht='';
            foreach ($data->chuong_kqht as $item){
               $kqht=$kqht.$item->maKQHTVB.'; ';
            }

            $cell2=$table_noidunghp->addCell(2000);
            $cell2->addText($kqht,$boldNormalText);


            $cell3=$table_noidunghp->addCell(1000);
            $cell3->addText($data->soTietLT,$boldNormalText);


            $cell4=$table_noidunghp->addCell(1000);
            $cell4->addText($data->soTietTH,$boldNormalText);


            $cell5=$table_noidunghp->addCell(1000);
            $cell5->addText($data->soTietKhac,$boldNormalText);
            

            foreach ($data->muc as $m){
                $table_noidunghp->addRow();
                $cell1=$table_noidunghp->addCell(7000);
                $cell1->addText($m->maMucVB.' '.$m->tenMuc,$normalText);
                $table_noidunghp->addCell(2000);
                $table_noidunghp->addCell(1000);
                $table_noidunghp->addCell(1000);
                $table_noidunghp->addCell(1000);
            }

            // chen them muc do ky nang uit
            foreach($CDR1 as $x){ 
                $table_noidunghp->addRow();
                $cell1=$table_noidunghp->addCell(7000);
                $cell1->addText(''.$x->tenCDR1EN,$boldNormalText);
                $cell2=$table_noidunghp->addCell(5000,array('gridSpan' => 4));
                foreach($mudokynangUIT as $uit){
                    if($uit->maCDR1 == $x->maCDR1 && $uit->id_chuong == $data->id){
                        $cell2->addText($uit->maKQHTVB.'('.$uit->ky_nang.'); ',$normalText);
                    }
                }
            }
        }


        //--------------------------------------6. Phuong phap giang day:-----------------------------------------------------------
        $section->addText('6. Teaching and learning method:',$headding1);
        $hp_ppgd=hocPhan_ppGiangDay::where('isDelete',false)->where('maHocPhan',$maHocPhan)->with('ppGiangDay')->get(); //bi&#7875;n hi&#7875;n th&#7883; ph&#432;&#417;ng ph�p gi&#7843;ng d&#7841;y 

        $table_giangday = $section->addTable($spanTableStyleName);

        $table_giangday->addRow(); //tiêu đề bảng thông tin chung
        $cell1 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('ID',$headding1);
        
        $cell2 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Teaching and learning method',$headding1);

        
        $cell3 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Description',$headding1);

        $i=1;
        foreach ($hp_ppgd as $x) {
            $table_giangday->addRow(); //n&#7897;i dung b&#7843;ng gi&#7843;ng d&#7841;y
            $cell1 = $table_giangday->addCell(4000);
            $textrun1 = $cell1->addTextRun($cellHCentered);
            $textrun1->addText($i);
            
            $cell2 = $table_giangday->addCell(4000);
            $textrun2 = $cell2->addTextRun($cellHCentered);
            $textrun2->addText($x->ppGiangDay->tenPP_EN);
    
            
            $cell3 = $table_giangday->addCell(4000);
            $textrun3 = $cell3->addTextRun($cellHCentered);
            $textrun3->addText($x->dienGiai);
            $i++;
        }

        //--------------------------------------7. Phương thức đánh giá:-----------------------------------------------------------
        $section->addText('7. Course assessment:',$headding1);

        $table_phuongthucdanhgia= $section->addTable($spanTableStyleName);

        $table_phuongthucdanhgia->addRow(); //tiêu đề bảng thông tin chung
        $cell1 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('ID',$headding1);
        
        $cell2 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Assessment activity',$headding1);

        
        $cell3 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Weight',$headding1);

        $hocPhan_loaiHTDG=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('maHocPhan',$maHocPhan)
        ->with('loai_danh_gia')
        ->with('loaiHTDanhGia')
        ->get();
        foreach ($hocPhan_loaiHTDG as $data){
            $table_phuongthucdanhgia->addRow();
            $cell1 = $table_phuongthucdanhgia->addCell(4000);
            $textrun1 = $cell1->addTextRun($cellHCentered);
            $textrun1->addText($data->loai_danh_gia['tenLoaiDG_EN'],$normalText);

            $cell2 = $table_phuongthucdanhgia->addCell(4000);
            $textrun2 = $cell2->addTextRun($cellHCentered);
            $textrun2->addText($data->loaiHTDanhGia['maLoaiHTDG'].' '.$data->loaiHTDanhGia['tenLoaiHTDG_EN'],$normalText);

            $cell3 = $table_phuongthucdanhgia->addCell(4000);
            $textrun3 = $cell3->addTextRun($cellHCentered);
            $textrun3->addText($data->trongSo.'%',$normalText);
        }
        $table_phuongthucdanhgia->addRow();
        $cell1 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Formula for Overall score');

        //tinh cong thuc
        $CT="";
        $n = $hocPhan_loaiHTDG->where('groupCT', 1)->count();
        $cr = 0;

        foreach($hocPhan_loaiHTDG as $data){
            if ($cr != 0 && $cr < $n && $data->groupCT == 1){
                $CT=$CT."+";
                $cr++;
                $CT=$CT.$data->loaiHTDanhGia['maLoaiHTDG'].'*'.$data->trongSo.'%';
            }
            else{
                if($data->groupCT==1){
                    $cr++;
                    $CT=$CT.$data->loaiHTDanhGia['maLoaiHTDG'].'*'.$data->trongSo.'%';
                }
            }
            
         
       
        }
        $n = $hocPhan_loaiHTDG->where('groupCT', 2)->count();
        $cr = 0;
        
        if($n>0){
            $CT=$CT.' or ';
            foreach($hocPhan_loaiHTDG as $data){
                if ($cr != 0 && $cr < $n && $data->groupCT == 2){
                    $CT=$CT."+";
                    $cr++;
                    $CT=$CT.$data->loaiHTDanhGia['maLoaiHTDG'].'*'.$data->trongSo.'%';
                }
                else{
                    if($data->groupCT==2){
                        $cr++;
                        $CT=$CT.$data->loaiHTDanhGia['maLoaiHTDG'].'*'.$data->trongSo.'%';
                    }
                }
            }
        }
        $cell2 = $table_phuongthucdanhgia->addCell(8000,$cellColSpan );
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText($CT);

        //--------------------------------------8. C�c quy &#273;&#7883;nh chung:-----------------------------------------------------------
        $section->addPageBreak();
        $section->addText('8. Course requirements and expectations:',$headding1);
        $section->addText('Requirements on attendance',$headding1);
        $section->addListItem('Students are responsible for attending all classes. In case of absence due to force majeure circumstances, there must be sufficient and reasonable evidence.',0,$normalText);
        $section->addListItem('Students who do not attend more than 20% of the class sections, whether for reason or not, are deemed not to have completed the course and must re-enroll in the following semester.',0,$normalText);
        $section->addText('Requirements and expectations on student behaviors ',$headding1);
        $section->addListItem('Students must show their respects for teachers and other learners.',0,$normalText);
        $section->addListItem('Students must be on time. Students who are late more than five minutes will not be allowed to attend the class.',0,$normalText);
        $section->addListItem('Students should not make noises and interfere with others in the learning process.',0,$normalText);
        $section->addListItem('Students should not eat, chew gum, and use devices such as cell phones, music players during class hours.',0,$normalText);
        $section->addListItem('Laptops and tablets can only be used in class for the purpose of learning. ',0,$normalText);
        $section->addListItem('Laptops and tablets can only be used in class for the purpose of learning. ',0,$normalText);
        $section->addText('Requirements on learning issues',$headding1);
        $section->addListItem('Issues related to applying for score reservation, scoring complaints, scoring, exam disciplines are done according to the Learning Regulation of Tra Vinh University.',0,$normalText);
        $filename=$hocPhan->maHocPhan.'_'.$hocPhan->tenHocPhanEN.'.docx';
        //xu&#7845;t fileE
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }
}