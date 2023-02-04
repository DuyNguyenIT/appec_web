@extends('sinhvien.khaosatmaster')
  @section('content')  
  <h3  style="text-align: center">
    PHIẾU KHẢO SÁT <br>
  Môn: {{ $hocPhan->tenHocPhan }} <br>
  Mã học phần: {{ $hocPhan->maHocPhan }}
  </h3>
        <div class="content-wrapper" style="min-height: 22px;">
          <!-- Content Header (Page header) -->
          <div class="content-header">
            <div class="container-fluid">
              <div class="row mb-2">
                <div class="col-sm-6">
                  
                  <h1 class="m-0 text-dark">
                    Khao sat<noscript></noscript>
                    <nav></nav>
                    
                  </h1>
                  
                </div>
                <!-- /.col -->
                <div class="col-sm-6">
                  <ol class="breadcrumb float-sm-right">
                    <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
                    <li class="breadcrumb-item active">khao sat</li>
                  </ol>
                </div>
                <!-- /.col -->
              </div>
              <!-- /.row -->
            </div>
            <!-- /.container-fluid -->
          </div>
          <!-- /.content-header -->
      
          @if(session('success'))
              <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-check"></i> Thông báo!</h5>
                {{session('success')}}
              </div>
            @endif
            @if(session('warning'))
              <div class="alert alert-warning alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                <h5><i class="icon fas fa-exclamation-triangle"></i> Thông báo!</h5>
                {{session('warning')}}
              </div>
            @endif
          <!-- Main content -->
      
          <section class="content">
            <div class="container-fluid">
              <div class="row">
                <div class="col-12">
                  <div class="card">
                    <div class="card-header">
                    </div>
                    <!-- /.card-header -->
                    <div class="card-body">
                      <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                          </div> 
                          <form name="khaosat" id="khaosat" method="post" >
                            @csrf
                          <table class="table table-bordered">
                            <thead>
                              <tr class="table-success" style="text-align: center">               
                                  <th rowspan="2">STT</th>
                                  <th rowspan="2">KQHT</th>
                                  <th rowspan="2">Chuẩn đầu ra</th>
                                  <th rowspan="2">Chuẩn Abet</th>
                                  <th colspan="6" >Mức độ đánh giá</th>      
                              </tr> 
                            
                            <tr class="table-success">     
                              <th>Nhớ</th> 
                              <th>Hiểu</th>
                              <th>Vận dụng</th>
                              <th>Phân tích</th>
                              <th>Đánh giá</th>
                              <th>Sáng tạo</th>
                            </tr>
                        </thead>
                            <tbody>
                              @foreach ($CDR1 as $cdr1)
                                  <tr>
                                      <td colspan="10"><b>Chủ đề {{ $cdr1->maCDR1VB }}: {{ $cdr1->tenCDR1 }}:</b>                
                                  </td>
                                  </tr>
                                  @php
                                        $j=1;
                                        $cur_rs=0;
                                        $i=0;
                                  @endphp
                                  @foreach ($kqht as $x)
                                      @if ($x->maCDR1==$cdr1->maCDR1)
                                        @php
                                            $rs=$kqht->where('maCDR1',$cdr1->maCDR1)->where('maKQHT',$x->maKQHT)->count(); 
                                            
                                            if($i>=$rs || $rs>$cur_rs){
                                              $cur_rs=$rs;  
                                              $i=1;
                                            }
                                            else {
                                              $i+=1;
                                            }
                                        @endphp
                                  
                                        @if($i==1)
                                        
                                          <tr>
                                            <td>{{ $j++ }}</td>
                                            <td rowspan={{ $rs }}>{{ $x->maKQHTVB }}: {{ $x->tenKQHT }}</td>
                                            <td>{{ $x->maCDR3VB }}: {{ $x->tenCDR3 }}</td>
                                            <td>{{ $x->maChuanAbet }}: {{ $x->tenChuanAbet }}</td>
                                            <td>
                                              <input type="radio"  id="muc_1" name="muc_{{$x->id }}" value="1" title="Nho">
                                            </td>
                                            <td >
                                                <input type="radio" id="muc_2" name="muc_{{$x->id }}" value="2" title="Hieu">
                                            </td>
                                            <td >
                                              <input type="radio" id="muc_3" name="muc_{{$x->id }}" value="3" title="Van dung">
                                            </td> 
                                            <td >
                                                <input type="radio" id="muc_4" name="muc_{{$x->id }}" value="4" title="Phan tich">
                                            </td> 
                                            <td >
                                                <input type="radio" id="muc_5" name="muc_{{$x->id }}" value="5" title="Danh gia">
                                            </td> 
                                            <td >
                                                <input type="radio" id="muc_6" name="muc_{{$x->id }}" value="6" title="Sang tao">
                                            </td>
                                          </tr>   
                                        @else
                                          <tr>
                                            <td>{{ $j++ }}</td>
                                            <td>{{ $x->maCDR3VB }}: {{ $x->tenCDR3 }}</td>
                                            <td>{{ $x->maChuanAbet }}: {{ $x->tenChuanAbet }}</td>
                                            <td>
                                              <input type="radio"  id="muc_1" name="muc_{{$x->id }}" value="1" title="Nho">
                                            </td>
                                            <td >
                                                <input type="radio" id="muc_2" name="muc_{{$x->id }}" value="2" title="Hieu">
                                            </td>
                                            <td >
                                              <input type="radio" id="muc_3" name="muc_{{$x->id }}" value="3" title="Van dung">
                                            </td> 
                                            <td >
                                                <input type="radio" id="muc_4" name="muc_{{$x->id }}" value="4" title="Phan tich">
                                            </td> 
                                            <td >
                                                <input type="radio" id="muc_5" name="muc_{{$x->id }}" value="5" title="Danh gia">
                                            </td> 
                                            <td >
                                                <input type="radio" id="muc_6" name="muc_{{$x->id }}" value="6" title="Sang tao">
                                            </td>
                                          </tr>
                                        @endif
                                      @endif
                                  @endforeach
                              @endforeach
                            </tbody>
                          </table>
                          <button type="submit" style="margin-left: 90%" id="submit" class="btn btn-success" onclick="return confirm('Bạn có muốn gui khảo sát không ?')">Gui khao sat</button>
                          </form>
                      </div>
                      <!-- /.card-body -->
                    </div>
                    <!-- /.card -->
                  </div>
                  <!-- /.col -->
                </div>
                <!-- /.row -->
              </div>
              <!-- /.container-fluid -->
            </section>
            <!-- /.content -->
          </div>

  <script>
    $.ajax({
      url: "{{url('giang-vien/hoc-phan/chuan-abet')}}",
      type: "POST",
      data: $('#khaosat').serialize(),
      success: function( response ) {
        $('#submit').html('Submit');
        $("#submit"). attr("disabled", false);
        alert('Ajax form has been submitted successfully');
        document.getElementById("Khaosat").reset(); 
      }
    });
  </script>

  <!--<script>
      if ($("#khaosat").length > 0) {
      $("#khaosat").validate({
      
        submitHandler: function(form) {
          $.ajaxSetup({
          headers: {
          'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
          }
          });
          $('#submit').html('Please Wait...');
          $("#submit"). attr("disabled", true);
          $.ajax({
            url: "{{url('giang-vien/hoc-phan/chuan-abet/guiks')}}",
            type: "POST",
            data: $('#khaosat').serialize(),
            success: function( response ) {
              $('#submit').html('Submit');
              $("#submit"). attr("disabled", false);
              alert(' successfully');
              document.getElementById("khaosat").reset(); 
              }
            });
          }
        })
      }
    </script>-->
  @endsection
