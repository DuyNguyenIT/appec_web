@extends('giangvien.master')
@section('content')
<div class="content-wrapper" style="min-height: 58px;">
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
            <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
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

  <section class="content">
    <div class="container-fluid">
      <div class="row">
        <div class="col-12">
          <div class="card">
            <div class="card-header">
              <h3 class="card-title">
                {{-- <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                  <i class="fas fa-plus"></i> Thêm
                </button> --}}

                <!-- Modal -->
               {{-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog" role="document">
                    <div class="modal-content">
                      <div class="modal-header">
                         <h5 class="modal-title" id="exampleModalLabel">
                          Thêm học phần
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                          <span aria-hidden="true">×</span>
                        </button> 
                      </div> 
                      <div class="modal-body">
                        <div class="form-group">
                          <label for="hocphan">Chọn chương trình đào tạo</label>
                          <!-- Button trigger modal -->
                          <select name="maCT" id="maCT" class="form-control custom-select" onchange="GetSelectCTDT(this)">
                            @foreach ($ctdt as $ct)
                                <option value="{{$ct->maCT}}" selected="">
                                  {{$ct->tenCT}}
                                </option>
                            @endforeach
                          </select>
                        </div>
                        <script>
                          
                          function GetSelectCTDT(maCT) {
                            $.ajax({
                              type:'GET',
                              url:'/giang-vien/hoc-phan/hoc-phan-ctdt/'+maCT.value,
                              success:function(data) {
                                  console.log(data.length);
                                  var select = document.getElementById("maHocPhan");
                                  removeOptions(select);
                                  for (var i = 0; i < data.length; i++) {
                                      var option = document.createElement("option");
                                      option.text = data[i].tenHocPhan;
                                      option.value = data[i].maHocPhan;
                                      select.add(option);
                                  }
                              }
                            });
                          }
                          function removeOptions(selectElement) {
                            var i, L = selectElement.options.length - 1;
                            for(i = L; i >= 0; i--) {
                                selectElement.remove(i);
                            }
                          }

                        </script>
                        <div class="form-group">
                          <label for="hocphan">Chọn học phần</label>
                          <!-- Button trigger modal -->
                          <select name="maHocPhan" id="maHocPhan" class="form-control custom-select"> </select>
                        </div>

                        <div class="from-group">
                          <label for="">Chọn học kì</label>
                          <select name="maHK" id="maHK" class="form-control custom-select">
                            <option value="HK1">Học kì 1</option>
                            <option value="HK2">Học kì 2</option>
                          </select>
                        </div>

                        <div class="from-group">
                          <label for="">Chọn học năm học</label>
                          <select name="namHoc" id="namHoc" class="form-control custom-select">
                            <option value="2020-2021">2020-2012</option>
                            <option value="2019-2020">2019-2020</option>
                          </select>
                        </div>
                       
                      </div>
                      <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">
                          Lưu
                        </button>
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">
                          Hủy
                        </button>
                      </div>
                    </div>
                  </div>
                </div> --}}
              </h3>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
              <table id="example2" class="table table-bordered table-hover">
                <thead>
                  <tr>
                    <th >STT</th>
                    <th >Tên học phần</th>
                    
                    <th >Học kì</th>
                    <th >Năm học</th>
                    <th >Mã lớp</th>
                    <th >Tùy chọn</th></tr>

                </thead>
                <tbody>
                  
                <tr >

                  @php
                      $i=1;
                  @endphp
                  @foreach ($gd as $item)
                    <td>{{$i++}}</td>
                    <td>{{$item->tenHocPhan}}</td>
                    
                    <td>{{$item->maHK}}</td>
                    <td>{{$item->namHoc}}</td>
                    <td>
                      <a href="{{ asset('giang-vien/hoc-phan/xem-ds-sv/'.$item->maLop) }}">
                        {{$item->maLop}}
                      </a>
                    </td>
                      <td>
                        <a href="{{ asset('giang-vien/hoc-phan/xem-ket-qua-hoc-tap/'.$item->maHocPhan) }}" class="btn btn-success">
                            <i class="fas fa-align-justify"></i> Kết quả học tập                    
                        </a>
                        
                        <button class="btn btn-primary">
                          <i class="fas fa-print"></i>
                          Đề cương chi tiết
                        </button>
                      </td>
                    
                  @endforeach
                    
                  </tr>
                </tbody>
                <tfoot></tfoot>
              </table>
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