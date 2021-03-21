@extends('giangvien.master')
@section('content')
     <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper">
    <!-- Content Header (Page header) -->
    <div class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1 class="m-0 text-dark">Nội dung quy hoạch<noscript></noscript><nav></nav></h1>
          </div><!-- /.col -->
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="{{ asset('giang-vien') }}">Trang chủ</a></li>
              <li class="breadcrumb-item "><a href="quyhoachKQHT.html">Đồ án</a></li>
              <li class="breadcrumb-item "><a href="noidungdanhgia_3.html">Nội dung đánh giá</a></li>
              <li class="breadcrumb-item active">Nội dung quy hoạch</li>

            </ol>
          </div><!-- /.col -->
        </div><!-- /.row -->
      </div><!-- /.container-fluid -->

      
    </div>
    <!-- /.content-header -->


    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <div class="col-12">
            <div class="card">
              <div class="card-header">
                <h3 class="">
                    <button type="button" class="btn btn-primary"  data-toggle="modal" data-target="#exampleModal">
                      <i class="fas fa-plus"></i> 
                      </button>
                    

                 <!-- Modal -->
                <div class="modal fade bd-example-modal-lg" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                  <div class="modal-dialog modal-lg" role="document">
                    <form action="{{ asset('/giang-vien/quy-hoach-danh-gia/noi-dung-quy-hoach/them-noi-dung-quy-hoach-submit') }}" method="POST">
                    @csrf
                    <div class="modal-content">
                        <div class="modal-header">
                          <h5 class="modal-title" id="exampleModalLabel">Thêm nội dung</h5>
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                          </button>
                        </div>
                        <div class="modal-body">
                          <input type="text" name="maCTBaiQH" value="{{$maCTBaiQH}}" hidden>
                          <div class="form-group">
                            <label for="">Chọn kết quả học tập</label>
                            <select name="maKQHT" id="" class="form-control">
                              @php
                                  $i=1;
                              @endphp
                              @foreach ($ketQuaHT as $kqht)
                                @if ($i==1)
                                  <option value="{{$kqht->maKQHT}}" selected >{{$kqht->maKQHTVB}}--{{$kqht->tenKQHT}}</option>
                                @else
                                  <option value="{{$kqht->maKQHT}}"> {{$kqht->maKQHTVB}}--{{$kqht->tenKQHT}}</option>
                                @endif
                                @php
                                    $i++;
                                @endphp
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="">Chọn mức độ đánh giá</label>
                            <select name="maMucDoDG" id="" class="form-control">
                              @php
                                  $i=1;
                              @endphp
                              @foreach ($mucDoDG as $md)
                                @if ($i==1)
                                  <option value="{{$md->maMucDoDG}}" selected >{{$md->tenMucDoDG}}</option>
                                @else
                                  <option value="{{$md->maMucDoDG}}">{{$md->tenMucDoDG}}</option>
                                @endif
                                @php
                                    $i++;
                                @endphp
                              @endforeach
                            </select>
                          </div>
                          <div class="form-group">
                            <label for="hocphan" style="font-size:20px">Nhập tên nội dung quy hoạch</label>
                            <!-- Button trigger modal -->
                            <input type="text" name="tenNoiDungQH" class="form-control" id="" placeholder="Nhập tên nội dung quy hoạch...">
                          </div>
                        
                        </div>
                        <div class="modal-footer">
                          <button type="submit" class="btn btn-primary">Lưu</button>
                          <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                        </div>
                      </div>
                  </form>
                    
                  </div>
                </div>
                    
                </h3>
              </div>
              <!-- /.card-header -->
              <div class="card-body">
                <table id="example2" class="table table-bordered table-hover">
                  <thead>
                  <tr>
                    <th>STT</th>
                    <th>Tên nội dung quy hoạch</th>
                    <th>Tùy chọn</th>
                  </tr>
                </thead>
                 <tbody>
                   @php
                       $i=1;
                   @endphp
                   @foreach ($noiDungQH as $nd)
                    <tr>
                      <td>{{$i++}}</td>
                      <td>{{$nd->tenNoiDungQH}}</td>
                      <td>
                      </td>
                    </tr>
                   @endforeach
                   
                  
                 </tbody>
                  <tfoot>
               
                  </tfoot>
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