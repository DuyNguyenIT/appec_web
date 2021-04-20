@extends('giangvien.master')

@section('content')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">
              Quy hoạch đánh giá KQHT<noscript></noscript>
              <nav></nav>
            </h1>
          </div>
          <!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Trang chủ</a></li>
              <li class="breadcrumb-item active">
                Quy hoạch đánh giá KQHT
              </li>
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
                  <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/loc') }}" method="post">
                    @csrf
                      <div class="from-group">
                        <label for="">{{ __('Semester') }}:</label>
                        <select name="maHK" id="" class="form-control custom-select">
                          <option value="all">{{ __('All') }}</option>
                          <option value="HK1">{{ __('Semester') }} 1</option>
                          <option value="HK2">{{ __('Semester') }} 2</option>
                        </select>
                      </div>
                      <div class="form-group">
                        <label for="">{{ __('Academic year') }}:</label>
                        <select name="namHoc" id="" class="form-control">
                          <option value="all">{{ __('All') }}</option>
                            @foreach ($years_array as $data)
                                <option value="{{$data}}">{{$data}}</option>
                            @endforeach
                        </select>
                      </div>
                      <button class="btn btn-success" type="submit">
                        <i class="fas fa-filter"></i> {{ __('Filter') }}
                      </button>
                  </form>
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table
                  id="example2"
                  class="table table-bordered table-hover">
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
               
                  @php
                      $i=1;
                  @endphp
                  @foreach ($gd as $item)
                  <tr >
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
                      
                        <a href="{{ asset('giang-vien/quy-hoach-danh-gia/quy-hoach-ket-qua/'.$item->maHocPhan.'/'.$item->maBaiQH.'/'.$item->maHK.'/'.$item->namHoc.'/'.$item->maLop) }}" class="btn btn-success">
                            <i class="fas fa-align-justify"></i> Quy hoạch KQHT                  
                        </a>
                      </td>
                    </tr>
                  @endforeach
                  
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