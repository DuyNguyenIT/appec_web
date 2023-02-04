<h3>Statistics of CDIO's SOs by year</h3>
<span>(Unit:%; X: do not valuating)</span>
<table id="" class="tatable table-bordered table-hover table-responsive table-striped">
    <thead>
        <tr>
            <th class="first" >{{ __('No.') }}</th>
            <th class="second" >{{ __('Year') }}</th>
            <th class="second" >{{ __('Semester') }}</th>
            <th class="second" >{{ __('Class') }}</th>
            <th class="second" >{{ __('Course') }}</th>
            {{-- <th class="fourth" colspan="{{ count($arr_thongkeKQ[0]) }}">SO</th> --}}
            @foreach ($CDR3 as $cdr3)
                <th class="fourth">{{ $cdr3->maCDR3VB }}</th>
            @endforeach
        </tr>
        {{-- <tr>
           
            
        </tr> --}}
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($arr_thongkeKQ as $data)
            <tr>
                <td class="first">{{ $i++ }}</td>
                <td>{{ $data[0] }}</td>
                 <td>{{ $data[1] }}</td>
                  <td>{{ $data[2] }}</td>
                <td class="second">
                    ({{ $data[3] }})
                    @foreach ($hocPhan as $hp)
                        @if ($hp->maHocPhan==$data[3])
                            @if (Session::has('language') && Session::get('language')=='en')
                            {{ $hp->tenHocPhanEN }}
                            @else
                            {{ $hp->tenHocPhan }}
                            @endif
                            
                        @endif
                    @endforeach
                </td>
                @for ($j = 4; $j < count($data); $j++)
                    <td class="fourth">
                        @if ($data[$j]!=0)
                            <b>{{ number_format($data[$j]*100,2) }}</b>
                        @else
                            X
                        @endif
                        
                    </td>
                @endfor
                
            </tr>
        @endforeach
       
    </tbody>
    <tfoot>
    </tfoot>
</table>