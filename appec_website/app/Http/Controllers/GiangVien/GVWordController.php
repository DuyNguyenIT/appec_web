<?php

namespace App\Http\Controllers\GiangVien;

use App\Models\CDR1;
use App\Models\deThi;
use App\Models\chuong;
use App\Models\kqHTHP;
use App\Models\hocPhan;
use Illuminate\Http\Request;
use App\Models\hocPhan_kqHTHP;
use App\Models\mucDoKyNangUIT;
use App\Models\dethi_cauhoituluan;
use App\Models\hocPhan_ppGiangDay;
use App\Models\phuongAnTracNghiem;
use App\Models\tai_lieu_tham_khao;
use App\Http\Controllers\Controller;
use App\Models\hocPhan_loaiHTDanhGia;

class GVWordController extends Controller
{
    public function in_de_cuong_mon_hoc($maHocPhan)
    {
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //tạo nội dung file
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
        $textrun->addText('Trường Đại học Trà Vinh',array('bold' => true,'italic'=>true, 'size' => 10,'name'=>'Times New Roman'),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT, 'spaceAfter' => 100));

        // Add header for all other pages
        $subsequent = $section->addHeader();
        $subsequent->addText('Trường Đại học Trà Vinh',array('bold' => true,'italic'=>true, 'size' => 10,'name'=>'Times New Roman'));

        // 1/ Thong tin chung
        $section->addText('Đề cương học phần',$headerForntStyle,$headerparagraphStyle);
        
        $hocPhan=hocPhan::where('maHocPhan',$maHocPhan)->first();  //truy vấn thông tin học phần
       
        $hoc_phan = $section->addTextRun($headerparagraphStyle);
        $hoc_phan->addText('Học phần: ',$boldNormalText);
        $hoc_phan->addText($hocPhan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        
        $ma_hoc_phan = $section->addTextRun($headerparagraphStyle);
        $ma_hoc_phan->addText('Mã học phần: ',$boldNormalText);
        $ma_hoc_phan->addText($hocPhan->maHocPhan,$headerForntStyle,$headerparagraphStyle);
        ////------------------------------------------1/ thông tin chung---------------------------------------------
        $section->addText('1. Thông tin chung',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        

        $table = $section->addTable($spanTableStyleName);

        $table->addRow(); //tiêu đề bảng thông tin chung

        $cell1 = $table->addCell(4000, $cellRowSpan); 
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Loại học phần',$headding1);

        $cell2 = $table->addCell(4000, $cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Số tín chỉ',$headding1);

        $cell3=$table->addCell(4000, $cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Số giờ học',$headding1);

        $table->addRow();
        $cell1 = $table->addCell(4000);
        $cell1->addListItem("Đại cương",0,$normalText);
        $cell1->addListItem("Cơ sở",0,$normalText);
        $cell1->addListItem("Chuyên ngành",0,$normalText);

        

        $cell1 = $table->addCell(4000);
        $cell1->addListItem("Lý thuyết: ".$hocPhan->tinChiLyThuyet,0,$normalText);
        $cell1->addListItem("Bài tập:",0,$normalText);
        $cell1->addListItem("Thực hành: ".$hocPhan->tinChiThucHanh,0,$normalText);

        $cell1 = $table->addCell(4000);
        $cell1->addListItem("Lý thuyết: ".($hocPhan->tinChiLyThuyet*15),0,$normalText);
        $cell1->addListItem("Bài tập:",0, $normalText);
        $cell1->addListItem("Thực hành: ".($hocPhan->tinChiThucHanh*30),0,$normalText);

        $doi_tuong_hoc=$section->addTextRun();  //đối tượng học
        $doi_tuong_hoc->addText('Đối tượng học:     ',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $doi_tuong_hoc->addText('  Bậc: Đại học',$normalText,array('tabs' => array(new \PhpOffice\PhpWord\Style\Tab('right', 9090))));
        $section->addText('Ngành:   Công nghệ thông tin ',$normalText);
        $section->addText('Hệ:         Chính quy',$normalText);
        
        $section->addText('Điều kiện tham gia môn học',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        
        //---------môn tiên quyết
        $monTQ=monTienQuyet::where('maHocPhan',$maHocPhan)->where('isDelete',false)->with('hoc_phan')->get();
        
        $table = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table->addRow();
        $cell1 = $table->addCell(4000);
        $tenmontq ='';
        foreach ($monTQ as $mtq) {
            $tenmontq=$tenmontq.$mtq->hoc_phan->tenHocPhan.';';
        }

        $cell1->addText('Học phần tiên quyết',$normalText);
        $cell1 = $table->addCell(8000);
        $cell1->addText($tenmontq,$normalText);

        $table->addRow();
        $cell1 = $table->addCell(4000);
        $cell1->addText('Các yêu cầu khác:',$normalText);
        $cell1 = $table->addCell(8000);
        $html = $hocPhan->yeuCau;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell1, $html, false, false);

        // //--------------------------------------2. Tài liệu tham khảo------------------------------------------------------------
      
        $section->addText('2. Tài liệu tham khảo',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $tailieuthamkhao=tai_lieu_tham_khao::where('maHocPhan',$maHocPhan)->first();

        $table_tailieuthamkhao = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table_tailieuthamkhao->addRow();
        $cell1 = $table_tailieuthamkhao->addCell(4000);
        $cell1->addText('Giáo trình/ Tài liệu học tập chính',$normalText);
        $cell1 = $table_tailieuthamkhao->addCell(8000);
        $html = $tailieuthamkhao->giaoTrinh;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell1, $html, false, false);

        $table_tailieuthamkhao->addRow();
        $cell2 = $table_tailieuthamkhao->addCell(4000);
        $cell2->addText('Tài liệu tham khảo thêm',$normalText);
        $cell2 = $table_tailieuthamkhao->addCell(8000);
        $html = $tailieuthamkhao->thamKhaoThem;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell2, $html, false, false);
        
        $table_tailieuthamkhao->addRow();
        $cell3 = $table_tailieuthamkhao->addCell(4000);
        $cell3->addText('Các loại học liệu khác',$normalText);
        $cell3 = $table_tailieuthamkhao->addCell(8000);
        $html = $tailieuthamkhao->taiLieuKhac;
        \PhpOffice\PhpWord\Shared\Html::addHtml($cell3, $html, false, false);

        //--------------------------------------3. Mô tả học phần------------------------------------------------------------
        
        $section->addText('3. Mô tả học phần',$headding1,array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::LEFT));
        $html = $hocPhan->moTaHocPhan;
        \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
        //--------------------------------------4. Chuẩn đầu ra học phần------------------------------------------------------------
        $CDR1=CDR1::all();//biến này để in chủ đề
        $kqht=hocPhan_kqHTHP::where('hocphan_kqht_hp.isDelete',false) //biến này chạy nội dung trong bảng chuẩn đầu ra môn học
        ->where('hocphan_kqht_hp.maHocPhan',$maHocPhan)
        ->join('kqht_hp',function($y){
            $y->on('kqht_hp.maKQHT','=','hocphan_kqht_hp.maKQHT')
            ->where('kqht_hp.isDelete',false);
        })
        ->join('cdr_cd3',function($t){
            $t->on('cdr_cd3.maCDR3','=','hocphan_kqht_hp.maCDR3')
            ->where('cdr_cd3.isDelete',false);
        })
        ->join('cdr_cd2',function($t){
            $t->on('cdr_cd2.maCDR2','=','cdr_cd3.maCDR2')
            ->where('cdr_cd2.isDelete',false);
        })
        ->join('cdr_cd1',function($t){
            $t->on('cdr_cd1.maCDR1','=','cdr_cd2.maCDR1')
            ->where('cdr_cd1.isDelete',false);
        })
        ->get();

        $section->addText('4. Chuẩn đầu ra học phần:',$headding1);
        $section->addText('Sau khi hoàn thành học phần, sinh viên có thể:',$normalText);
        
        $table_chuandaura = $section->addTable(array('borderSize' => 6, 'borderColor' => '000000'));
        $table_chuandaura->addRow();
        $table_chuandaura->addCell(1000);
        $table_chuandaura->addCell(7000);
        $cell = $table_chuandaura->addCell(4000,$cellRowSpan);
        $cell->addText('Đáp ứng CĐR của CTĐR');

    
        foreach ($CDR1 as $cdr) {
            $table_chuandaura->addRow();
            $table_chuandaura->addCell(1000);
            $cell=$table_chuandaura->addCell(7000);
            $cell->addText('Chủ đề:'.$cdr->tenCDR1, $boldNormalText);
            $table_chuandaura->addCell(4000);
            foreach ($kqht as $x){
                if($x->maCDR1==$cdr->maCDR1){
                    $table_chuandaura->addRow();
                    $cell1=$table_chuandaura->addCell(1000);
                    $cell1->addText($x->maKQHTVB, $normalText);
                    $cell2=$table_chuandaura->addCell(7000);
                    $cell2->addText($x->tenKQHT, $normalText);
                    $cell3=$table_chuandaura->addCell(4000);
                    $cell3->addText($x->maCDR3VB, $normalText);
                }
            }
            
        }
        //--------------------------------------5. Nội dung học phần----------------------------------------------------------------
        $section->addText('5. Nội dung học phần:',$headding1);
        #bảng
        $table_noidunghp = $section->addTable($spanTableStyleName);
        #tieu de ban
        $table_noidunghp->addRow();
        $cell1 = $table_noidunghp->addCell(7000, $cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Nội dung học phần');

        $cell2 = $table_noidunghp->addCell(2000, $cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('CLOs');

        $cell3 = $table_noidunghp->addCell(3000, array('gridSpan' => 3, 'valign' => 'center','vMerge' => 'restart', 'valign' => 'center', 'bgColor' => '14c447'));
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Số tiết');

        $table_noidunghp->addRow();
        $table_noidunghp->addCell(null, $cellRowContinue);
        $table_noidunghp->addCell(null, $cellRowContinue);
        $table_noidunghp->addCell(1000, $cellVCentered)->addText('Lý thuyết', null, $cellHCentered);
        $table_noidunghp->addCell(1000, $cellVCentered)->addText('Thực hành', null, $cellHCentered);
        $table_noidunghp->addCell(1000, $cellVCentered)->addText('Khác', null, $cellHCentered);
        #dong noi dung
        $noidung=chuong::where('chuong.isdelete',false)->where('chuong.maHocPhan',$maHocPhan)
        ->orderBy('chuong.id','asc')
        ->with('muc')
        ->with('chuong_kqht')
        ->get();
        $chuong_array=chuong::where('chuong.isdelete',false)->where('chuong.maHocPhan',$maHocPhan)
        ->orderBy('chuong.id','asc')
        ->pluck('id');
        
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
               
               $kqht=$kqht.$item->maKQHTVB.';';
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
                $cell1->addText($m->maMucVB.$m->tenMuc,$normalText);
                $table_noidunghp->addCell(2000);
                $table_noidunghp->addCell(1000);
                $table_noidunghp->addCell(1000);
                $table_noidunghp->addCell(1000);
            }
        }



        //--------------------------------------6. Phương pháp giảng dạy:-----------------------------------------------------------
        $section->addText('6. Phương pháp giảng dạy:',$headding1);
        $hp_ppgd=hocPhan_ppGiangDay::where('isDelete',false)->where('maHocPhan',$maHocPhan)->with('ppGiangDay')->get(); //biển hiển thị phương pháp giảng dạy 

        $table_giangday = $section->addTable($spanTableStyleName);


        $table_giangday->addRow(); //tiêu đề bảng thông tin chung
        $cell1 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Mã số',$headding1);
        
        $cell2 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Phương pháp giảng dạy',$headding1);

        
        $cell3 = $table_giangday->addCell(4000,$cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Diễn giải',$headding1);

        $i=1;
        foreach ($hp_ppgd as $x) {
            $table_giangday->addRow(); //nội dung bảng giảng dạy
            $cell1 = $table_giangday->addCell(4000);
            $textrun1 = $cell1->addTextRun($cellHCentered);
            $textrun1->addText($i);
            
            $cell2 = $table_giangday->addCell(4000);
            $textrun2 = $cell2->addTextRun($cellHCentered);
            $textrun2->addText($x->ppGiangDay->tenPP);
    
            
            $cell3 = $table_giangday->addCell(4000);
            $textrun3 = $cell3->addTextRun($cellHCentered);
            $textrun3->addText($x->dienGiai);
            $i++;
        }

        //--------------------------------------7. Phương thức đánh giá:-----------------------------------------------------------
        $section->addText('7. Phương thức đánh giá:',$headding1);

        $table_phuongthucdanhgia= $section->addTable($spanTableStyleName);

        $table_phuongthucdanhgia->addRow(); //tiêu đề bảng thông tin chung
        $cell1 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun1 = $cell1->addTextRun($cellHCentered);
        $textrun1->addText('Hình thức đánh giá',$headding1);
        
        $cell2 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun2 = $cell2->addTextRun($cellHCentered);
        $textrun2->addText('Loại hình thức đánh giá',$headding1);

        
        $cell3 = $table_phuongthucdanhgia->addCell(4000,$cellRowSpan);
        $textrun3 = $cell3->addTextRun($cellHCentered);
        $textrun3->addText('Tỉ lệ',$headding1);

        $hocPhan_loaiHTDG=hocPhan_loaiHTDanhGia::where('isDelete',false)->where('maHocPhan',$maHocPhan)
        ->with('loai_danh_gia')
        ->with('loaiHTDanhGia')
        ->get();
        foreach ($hocPhan_loaiHTDG as $data){
            $table_phuongthucdanhgia->addRow();
            $cell1 = $table_phuongthucdanhgia->addCell(4000);
            $textrun1 = $cell1->addTextRun($cellHCentered);
            $textrun1->addText($data->loai_danh_gia['tenLoaiDG'],$normalText);

            $cell2 = $table_phuongthucdanhgia->addCell(4000);
            $textrun2 = $cell2->addTextRun($cellHCentered);
            $textrun2->addText($data->loaiHTDanhGia['maLoaiHTDG'].$data->loaiHTDanhGia['tenLoaiHTDG'],$normalText);

            $cell3 = $table_phuongthucdanhgia->addCell(4000);
            $textrun3 = $cell3->addTextRun($cellHCentered);
            $textrun3->addText($data->trongSo.'%',$normalText);
        }
        $table_phuongthucdanhgia->addRow();
        $cell1=$table_phuongthucdanhgia->addCell(4000);
        $cell1->addText('Công thức tính điểm');
        $table_phuongthucdanhgia->addCell(8000, array('gridSpan' => 3, 'valign' => 'center'));



        //--------------------------------------8. Các quy định chung:-----------------------------------------------------------
        $section->addPageBreak();
        $section->addText('8. Các quy định chung:',$headding1);
        $section->addText('Các quy định về tham dự lớp học',$headding1);
        $section->addListItem('Sinh viên có trách nhiệm tham dự đầy đủ các buổi học. Trong trường hợp phải nghỉ học vì lý do bất khả kháng thì phải có giấy tờ chứng minh đầy đủ và hợp lý.',0,$normalText);
        $section->addListItem('Sinh viên vắng quá 20% số tiết của học phần, dù có lý do hay không có lý do, đều bị coi như không hoàn thành học phần và phải đăng ký học lại vào học kỳ sau.',0,$normalText);
        $section->addText('Quy định về hành vi trong lớp học',$headding1);
        $section->addListItem('Học phần được thực hiện trên nguyên tắc tôn trọng người học và người dạy. Mọi hành vi làm ảnh hưởng đến quá trình dạy và học đều bị nghiêm cấm.',0,$normalText);
        $section->addListItem('Sinh viên phải đi học đúng giờ qui định. Sinh viên đi trễ quá 5 phút sau khi giờ học bắt đầu sẽ không được tham dự buổi học.',0,$normalText);
        $section->addListItem('Tuyệt đối không làm ồn, gây ảnh hưởng đến người khác trong quá trình học.',0,$normalText);
        $section->addListItem('Tuyệt đối không được ăn, nhai kẹo cao su, sử dụng các thiết bị như điện thoại, máy nghe nhạc trong giờ học.',0,$normalText);
        $section->addListItem('Máy tính xách tay, máy tính bảng chỉ được sử dụng trên lớp với mục đích ghi chép bài giảng, tính toán phục vụ bài giảng, bài tập. Tuyệt đối không dùng vào việc khác.',0,$normalText);
        $section->addListItem('Sinh viên vi phạm các nguyên tắc trên sẽ bị mời ra khỏi lớp và bị coi là vắng buổi học đó.',0,$normalText);
        $section->addText('Quy định về học vụ',$headding1);
        $section->addListItem('Các vấn đề liên quan đến xin bảo lưu điểm, khiếu nại điểm, chấm phúc tra, kỷ luật thi cử được thực hiện theo quy chế học vụ của trường Đại học Trà Vinh.',0,$normalText);
        $filename=$hocPhan->maHocPhan.'_'.$hocPhan->tenHocPhan.'.docx';
        //xuất fileE
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }

    ####---------------------in đề thi tự luận
    public function in_de_thi_tu_luan($maDe,$maHocPhan)
    {
        //tạo file word
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //format font and paragraph
        $headerForntStyle = 'rStyle';
        $phpWord->addFontStyle($headerForntStyle, array('bold' => true, 'size' => 12,'name'=>'Times New Roman', 'allCaps' => true));
        $headerparagraphStyle = 'pStyle';
        $phpWord->addParagraphStyle($headerparagraphStyle, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $normalText='normalText';
        $phpWord->addFontStyle($normalText, array( 'size' => 12,'name'=>'Times New Roman'));
        $headding1='headding1';
        $phpWord->addFontStyle($headding1, array( 'size' => 12,'name'=>'Times New Roman','bold' => true));

        $section = $phpWord->addSection();
        $deThi=deThi::where('maDe',$maDe)->first(); 
        $hocphan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        $table_title = $section->addTable();
        $table_title->addRow();
        $cell1 = $table_title->addCell(6000);
        $cell1->addText('Trường: Đại học Trà Vinh',$normalText);
        $cell1->addText('Lớp:.................................',$normalText);
        $cell1->addText('Tên:.................................',$normalText);
        $cell2 = $table_title->addCell(6000);
        $cell2->addText('KHOA KỸ THUẬT VÀ CÔNG NGHỆ',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('HỌC PHẦN: '.$hocphan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText($deThi->tenDe,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Thời gian thi: '.$deThi->thoiGian.' phút',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Mã đề: '.$deThi->maDeVB ,$headerForntStyle,$headerparagraphStyle);

        $section->addText('(Ghi chú: '.$deThi->ghiChu.')',array('italic'=>true),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));   
        $section->addText('--NỘI DUNG ĐỀ THI--',$headerForntStyle,$headerparagraphStyle);
        
        //chèn nội dung đề thi
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->join('de_thi_cauhoi_tuluan','de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
        $i=1;
        //tính điểm câu hỏi
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->sum('phuong_an_tu_luan.diemPA');
            $noidung[$i]->diem=$diem;  
        }

        foreach ($noidung as $x) {
            $section->addText('Câu '.$i.': ('.$x->diem.' điểm)',array('bold'=>true,'name'=>'Times New Roman'));
            $html = $x->noiDungCauHoi;
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            $i++;
        }
        $section->addText('--HẾT--',$headerForntStyle,$headerparagraphStyle);

        //save file
        $filename='dethi.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }

    ##----------------------in đề thi thực hành
    public function in_de_thi_thuc_hanh($maDe,$maHocPhan)
    {
        //tạo file word
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //format font and paragraph
        $headerForntStyle = 'rStyle';
        $phpWord->addFontStyle($headerForntStyle, array('bold' => true, 'size' => 12,'name'=>'Times New Roman', 'allCaps' => true));
        $headerparagraphStyle = 'pStyle';
        $phpWord->addParagraphStyle($headerparagraphStyle, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $normalText='normalText';
        $phpWord->addFontStyle($normalText, array( 'size' => 12,'name'=>'Times New Roman'));
        $headding1='headding1';
        $phpWord->addFontStyle($headding1, array( 'size' => 12,'name'=>'Times New Roman','bold' => true));

        $section = $phpWord->addSection();
        $deThi=deThi::where('maDe',$maDe)->first(); 
        $hocphan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        $table_title = $section->addTable();
        $table_title->addRow();
        $cell1 = $table_title->addCell(6000);
        $cell1->addText('Trường: Đại học Trà Vinh',$normalText);
        $cell1->addText('Lớp:.................................',$normalText);
        $cell1->addText('Tên:.................................',$normalText);
        $cell2 = $table_title->addCell(6000);
        $cell2->addText('KHOA KỸ THUẬT VÀ CÔNG NGHỆ',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('HỌC PHẦN: '.$hocphan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText($deThi->tenDe,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Thời gian thi: '.$deThi->thoiGian.' phút',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Mã đề: '.$deThi->maDeVB ,$headerForntStyle,$headerparagraphStyle);

        $section->addText('(Ghi chú: '.$deThi->ghiChu.')',array('italic'=>true),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));   
        $section->addText('--NỘI DUNG ĐỀ THI--',$headerForntStyle,$headerparagraphStyle);
        
        //chèn nội dung đề thi
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->join('de_thi_cauhoi_tuluan','de_thi_cauhoi_tuluan.maDe','=','de_thi.maDe')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cauhoi_tuluan.maCauHoi')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
        $i=1;
        //tính điểm câu hỏi
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=dethi_cauhoituluan::where('maCauHoi',$noidung[$i]->maCauHoi)
            ->join('phuong_an_tu_luan','phuong_an_tu_luan.id','=','de_thi_cauhoi_tuluan.maPATL')
            ->sum('phuong_an_tu_luan.diemPA');
            $noidung[$i]->diem=$diem;  
        }

        $i=1;
        foreach ($noidung as $x) {
            $section->addText('Câu '.$i.': ('.$x->diem.' điểm)',array('bold'=>true,'name'=>'Times New Roman'));
            $html = $x->noiDungCauHoi;
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            $i++;
        }
        $section->addText('--HẾT--',$headerForntStyle,$headerparagraphStyle);

        //save file
        $filename='dethi.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }

    ##----------------------in đề thi trắc nghiệm
    public function in_de_thi_trac_nghiem($maDe,$maHocPhan)
    {
        //tạo file word
        $phpWord = new \PhpOffice\PhpWord\PhpWord();

        //format font and paragraph
        $headerForntStyle = 'rStyle';
        $phpWord->addFontStyle($headerForntStyle, array('bold' => true, 'size' => 12,'name'=>'Times New Roman', 'allCaps' => true));
        $headerparagraphStyle = 'pStyle';
        $phpWord->addParagraphStyle($headerparagraphStyle, array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER, 'spaceAfter' => 100));
        $normalText='normalText';
        $phpWord->addFontStyle($normalText, array( 'size' => 12,'name'=>'Times New Roman'));
        $headding1='headding1';
        $phpWord->addFontStyle($headding1, array( 'size' => 12,'name'=>'Times New Roman','bold' => true));

        $section = $phpWord->addSection();
        $deThi=deThi::where('maDe',$maDe)->first(); 
        $hocphan=hocPhan::where('maHocPhan',$maHocPhan)->first();
        $table_title = $section->addTable();
        $table_title->addRow();
        $cell1 = $table_title->addCell(6000);
        $cell1->addText('Trường: Đại học Trà Vinh',$normalText);
        $cell1->addText('Lớp:.................................',$normalText);
        $cell1->addText('Tên:.................................',$normalText);
        $cell2 = $table_title->addCell(6000);
        $cell2->addText('KHOA KỸ THUẬT VÀ CÔNG NGHỆ',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('HỌC PHẦN: '.$hocphan->tenHocPhan,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText($deThi->tenDe,$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Thời gian thi: '.$deThi->thoiGian.' phút',$headerForntStyle,$headerparagraphStyle);
        $cell2->addText('Mã đề: '.$deThi->maDeVB ,$headerForntStyle,$headerparagraphStyle);

        $section->addText('(Ghi chú: '.$deThi->ghiChu.')',array('italic'=>true),array('alignment' => \PhpOffice\PhpWord\SimpleType\Jc::CENTER));   
        $section->addText('--NỘI DUNG ĐỀ THI--',$headerForntStyle,$headerparagraphStyle);
        
        //chèn nội dung đề thi
        $noidung=deThi::where('de_thi.isDelete',false)->where('de_thi.maDe',$maDe)
        ->join('de_thi_cau_hoi','de_thi_cau_hoi.maDe','=','de_thi.maDe')
        ->join('cau_hoi','cau_hoi.maCauHoi','=','de_thi_cau_hoi.maCauHoi')
        ->distinct('cau_hoi.maCauHoi')
        ->get(['cau_hoi.maCauHoi','cau_hoi.noiDungCauHoi']);
       
        $i=1;
        //tính điểm câu hỏi
        for ($i=0; $i < count($noidung); $i++) { 
            $diem=phuongAnTracNghiem::where('maCauHoi',$noidung[$i]->maCauHoi)->sum('diemPA');
            $noidung[$i]->diem=$diem;  
            $noidung[$i]->phuong_an=phuongAnTracNghiem::where('maCauHoi',$noidung[$i]->maCauHoi)->get();
        }   


        $letter=['A','B','C','D'];
        for ($i=0; $i <count($noidung) ; $i++) { 
            $section->addText('Câu '.($i+1).': ('.$noidung[$i]->diem.' điểm)',array('bold'=>true,'name'=>'Times New Roman'));
            $html = $noidung[$i]->noiDungCauHoi;
            \PhpOffice\PhpWord\Shared\Html::addHtml($section, $html, false, false);
            for ($j=0; $j < count($noidung[$i]->phuong_an); $j++) { 
                # code...            
                $pa = $noidung[$i]->phuong_an[$j]->noiDungPA;
                $pa=substr_replace($pa, $letter[$j].'. ', 3, 0);
                \PhpOffice\PhpWord\Shared\Html::addHtml($section, $pa, false, false);
            }
        }
     
        
        $section->addText('--HẾT--',$headerForntStyle,$headerparagraphStyle);

        //save file
        $filename='dethi.docx';
        $objWriter = \PhpOffice\PhpWord\IOFactory::createWriter($phpWord, 'Word2007');
        try {
            $objWriter->save(storage_path($filename));
        } catch (Exception $e) {
        }
        return response()->download(storage_path($filename));
    }

}
