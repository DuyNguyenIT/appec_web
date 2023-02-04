<table>
                  
    <thead>  
      <tr>
        <th>No.</th>
        <th>Course Name</th>
        @foreach ($chuan_abet as $x)
              <th> {{$x->maChuanAbetVB}} </th>
              @php
              $tongmon_dapung[$x->maChuanAbet]=0;
              @endphp
        @endforeach
        <th>Total</th>
      </tr>
    </thead>
   
   <tbody>
      @php
        $i=1;
        $tongcong=0;
      @endphp
      @foreach ($hp_ctdt as $y)
          @php
          $tongabet_cuamon=0;
          @endphp
          <tr>
              <td>{{$i++}} </td>
              <td>{{$y->tenHocPhan}}</td>
               @foreach ( $chuan_abet as $x)
                  <td>
                  @foreach ( $hp_kqhthp as $z)
                      
                      @if($z->maHocPhan==$y->maHocPhan && $z->maChuanAbet==$x->maChuanAbet)
                        @php
                          $tongabet_cuamon++;
                          $tongmon_dapung[$x->maChuanAbet]++;
                        @endphp
                          {{$z->maCDR3VB}} ({{$z->maKQHTVB}}), 
                      @endif
                  @endforeach
                  </td>

                @endforeach   
                <td>{{$tongabet_cuamon}}</td>
                @php
                  $tongcong=$tongcong+$tongabet_cuamon;
                @endphp 
          </tr>
      @endforeach
   </tbody>
    <tfoot>
      <tr>
        <td></td>
        <td ><b>Total</b></td>
        @foreach ($chuan_abet as $x)
          <td ><b>{{$tongmon_dapung[$x->maChuanAbet]}}</b></td>
        @endforeach
        <td ><b>{{$tongcong}}</b></td>
  
      </tr>
    </tfoot>
  </table>