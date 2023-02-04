@extends('sinhvien.master')

@section('content')
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script>
    <script src="http://cdnjs.cloudflare.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<div class="content-wrapper" style="min-height: 22px;">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Học phần<noscript></noscript>
              <nav></nav>
              
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ asset('/sinh-vien') }}">Trang chủ</a></li>
              <li class="breadcrumb-item active">Học phần</li>
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
    <input type="text" id="pks_kqht" value="{{ $pks_kqht }}" hidden>
    <input type="text" id="pks_cdr" value="{{ $pks_cdr }}" hidden>
    <input type="text" id="pks_cabet" value="{{ $pks_cabet }}" hidden>
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="card-title">
                  
                  
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                     
                    </div><table id="example2" class="table table-bordered table-hover">
                  <thead>
                    <tr>
                      <th>STT</th>
                      <th>Mã học phần </th>
                      <th>Tên học phần </th>
                      <th>Năm học</th>
                      <th>Học kì</th>
                      <th>Tên giảng viên</th>
                      <th>Khảo sát</th>
                      {{-- <th>Tùy chọn</th> --}}
                    </tr>
                  </thead>
                  <tbody>
                    @php
                        $i=1;
                    @endphp
                    @foreach ($giangday as $data)
                      <tr>
                        <td>{{ $i++ }}</td>
                        <td>{{ $data->maHocPhan }}</td>
                        <td>{{ $data->tenHocPhan }}</td>
                        <td>{{ $data->namHoc }}</td>
                        <td>{{ $data->maHK }}</td>
                        <td>
                            {{ $data->hoGV }} {{ $data->tenGV }}</td>
                        
                        <td>
                            <a id="status1" href="" class="btn btn-primary" data-status="true" >
                                 Khảo sát kết quả học tập 
                            </a>

                            <a id="status2" href="" class="btn btn-success" data-status="true" >
                                 Khảo sát chuẩn đầu ra 3 
                            </a>
                              <a id="status3" href="" class="btn btn-info"  data-status="true" >
                                Khảo sát chuẩn abet 
                             </a>
                            
                        </td>
 
                        
                       
                      </tr>
                    @endforeach
                  </tbody>
                  <tfoot></tfoot>
                </table>
                <script>
                  ///////////////////////////////kqht////////////////////////////////
                   $(document).ready(function() {

                    $('#status1').click(function(e) { //khi bam gui

                        e.preventDefault();
                        $.ajaxSetup({
                            headers: {
                                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                            }
                        });
                        $('#status1').html('Khảo sát..');
                        console.log('Hello');
                        ////kiem tra da check
                      
                        var $pks_kqht = $("#pks_kqht").val(); //lay mang gia tri kqhht tu input text
                        console.log($pks_kqht);
                        var data = $.parseJSON($pks_kqht); //chuyen tu mang string sang json
                        console.log(data);

                        // if($pks_kqht = "[]"){
                        //   var href = $('#status1').attr('href');
                        // }
                        
                        let demFalse = 0;
                        $.each(data, function(i, v) //chay tung phan tu trong mang json
                            {
                                //kiem tra radio button da duoc chon 
                                if ( data!=[]) {
                                    demFalse += 1; 
                                    console.log(demFalse);
                                }
                            });

                            if (demFalse > 0) {
                                alert('Bạn đã khảo sát rồi');
                                $('#status1').html('Đã Khảo sát');
                                $("#status1").removeAttr('href');
                                e.preventDefault();
                                $(this).off("click").attr('a', "javascript: void(0);");
                                return false;
                            } else {
                              //var href = $('#status1').attr('href');
                              location.href = "{{ asset('sinh-vien/hoc-phan/pks-kqht/' . $data->maHocPhan . '/' . $data->maLop) }}" 
                            }
                      });
                    //-----end document
                    });
///////////////////////////////////////////////////////////////cdr//////////////////////////
                    $(document).ready(function() {

                  $('#status2').click(function(e) { //khi bam gui

                      e.preventDefault();
                      $.ajaxSetup({
                          headers: {
                              'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                          }
                      });
                      $('#status2').html('Khảo sát..');
                      console.log('Hello');
                      ////kiem tra da check
                    
                      var $pks_cdr = $("#pks_cdr").val(); //lay mang gia tri kqhht tu input text
                      console.log($pks_cdr);
                      var data = $.parseJSON($pks_cdr); //chuyen tu mang string sang json
                      console.log(data);

                      // if($pks_kqht = "[]"){
                      //   var href = $('#status1').attr('href');
                      // }
                      
                      let demFalse = 0;
                      $.each(data, function(i, v) //chay tung phan tu trong mang json
                          {
                              //kiem tra radio button da duoc chon 
                              if ( data!=[]) {
                                  demFalse += 1; 
                                  console.log(demFalse);
                              }
                          });

                          if (demFalse > 0) {
                              alert('Bạn đã khảo sát rồi');
                              $('#status2').html('Đã Khảo sát');
                              $("#status2").removeAttr('href');
                              e.preventDefault();
                              $(this).off("click").attr('a', "javascript: void(0);");
                              return false;
                          } else {
                            //var href = $('#status1').attr('href');
                            location.href = "{{ asset('sinh-vien/hoc-phan/pks-cdr3/' . $data->maHocPhan . '/' . $data->maLop) }}" 
                          }
                    });
                  //-----end document
                  });
                    /////////////////////////////////////chuan abet///////////////////////////////////
                    $(document).ready(function() {

                        $('#status3').click(function(e) { //khi bam gui

                            e.preventDefault();
                            $.ajaxSetup({
                                headers: {
                                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                                }
                            });
                            $('#status3').html('Khảo sát..');
                            console.log('Hello');
                            ////kiem tra da check
                          
                            var $pks_cabet = $("#pks_cabet").val(); //lay mang gia tri kqhht tu input text
                            console.log($pks_cabet);
                            var data = $.parseJSON($pks_cabet); //chuyen tu mang string sang json
                            console.log(data);

                            // if($pks_kqht = "[]"){
                            //   var href = $('#status1').attr('href');
                            // }
                            
                            let demFalse = 0;
                            $.each(data, function(i, v) //chay tung phan tu trong mang json
                                {
                                    //kiem tra radio button da duoc chon 
                                    if ( data!=[]) {
                                        demFalse += 1; 
                                        console.log(demFalse);
                                    }
                                });

                                if (demFalse > 0) {
                                    alert('Bạn đã khảo sát rồi');
                                    $('#status3').html('Đã Khảo sát');
                                    $("#status3").removeAttr('href');
                                    e.preventDefault();
                                    $(this).off("click").attr('a', "javascript: void(0);");
                                    return false;
                                } else {
                                  //var href = $('#status1').attr('href');
                                  location.href = "{{ asset('sinh-vien/hoc-phan/pks-chuanabet/' . $data->maHocPhan . '/' . $data->maLop) }}" 
                                }
                          });
                        //-----end document
                        });
                </script>
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
@endsection