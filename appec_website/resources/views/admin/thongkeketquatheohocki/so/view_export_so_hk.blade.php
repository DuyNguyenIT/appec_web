<table id="" class="tatable table-bordered table-hover table-responsive table-striped">
    <thead>
        <tr>
            <th class="first" >{{ __('No.') }}</th>
            <th class="second" >{{ __('Subject') }}</th>
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
                <td class="second">
                    ({{ $data[0] }})
                    @foreach ($hocPhan as $hp)
                        @if ($hp->maHocPhan==$data[0])
                            @if (Session::has('language') && Session::get('language')=='en')
                            {{ $hp->tenHocPhanEN }}
                            @else
                            {{ $hp->tenHocPhan }}
                            @endif
                            
                        @endif
                    @endforeach
                </td>
                @for ($i = 1; $i < count($data); $i++)
                    <td class="fourth">
                        @if ($data[$i]!=0)
                            <b>{{ number_format($data[$i]*100,2) }}</b>
                        @else
                            0
                        @endif
                        
                    </td>
                @endfor
                
            </tr>
        @endforeach
       
    </tbody>
    <tfoot>
    </tfoot>
</table>