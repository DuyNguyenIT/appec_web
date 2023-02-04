<table>   
    <thead>  
  <tr>
    <th>No.</th>
    <th>Course Name</th>
    @php
        $tongmon_dapung=[];//biến lưu tổng theo cột CDR3
      @endphp
    @foreach ($ctdt_cdr as $x)
          <th> {{$x->maCDR3VB}} </th>
          @php
          $tongmon_dapung[$x->maCDR3]=0;
          @endphp
    @endforeach
    <th>Total</th>
  </tr>
  </thead>
   
   <tbody>
      @php
        $i=1;
        $tongcong=0;//biến lưu tổng của cột tổng
      @endphp
      @foreach ($hp_ctdt as $y)
          <tr>
              <th>{{$i++}} </th>
              <th>{{$y->tenHocPhan}}</th>
              @php
              $tongcdr_cuamon=0;
              $ktra=0;//kiểm tra xem môn học có được nhập CDR3 chưa
              @endphp
              @foreach ($hp_cdr3 as $z)
                
                @if ($y->maHocPhan==$z->maHocPhan )
                  @php //Nếu học phần đang xét mà có trong bảng học phần-chuẩn đầu ra 3
                  $ktra=1; // môn học đã có chuẩn đầu ra
                  break;
                  @endphp
                @endif
              @endforeach
              @if ($ktra==1)
                @foreach ($ctdt_cdr as $x)
                  @php //nếu học phần có đáp ứng chuẩn đầu ra thì kiểm tra xem đáp ứng CDR3 nào
                  $dapung=0;
                  @endphp
                  @foreach ( $hp_cdr3 as $z)
                    @if($z->maCDR3==$x->maCDR3 && $y->maHocPhan==$z->maHocPhan)
                      @php
                      $dapung=1; // môn học đáp ứng chuẩn đầu ra 3 tương ứng với cột CDR3
                      $tongcdr_cuamon++;
                      $tongmon_dapung[$x->maCDR3]++;
                      break;
                      @endphp 
                    @endif
                  @endforeach
                  @if ($dapung==1)
                    <td>x</td>
                  @else
                    <td>&nbsp;</td>
                  @endif
                @endforeach  
              @else
                @foreach ($ctdt_cdr as $x)
                  
                  <td>&nbsp;</td>
                @endforeach
              @endif
            <td>{{$tongcdr_cuamon}}</td>
            @php
              $tongcong=$tongcong+$tongcdr_cuamon;
            @endphp  
          </tr>
      @endforeach
    </tbody>
    <tfoot>
        <tr>
          <td ></td> 
          <td >Total</td>
          @foreach ($ctdt_cdr as $x)
            <td >{{$tongmon_dapung[$x->maCDR3]}}</td>
            @endforeach
          <td >{{$tongcong}}</td>
        </tr>
      </tfoot>
  </table>