<p>Unit: %</p>
<table id="" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th rowspan="2">{{ __('No.') }}</th>
            <th rowspan="2">{{ __('Subject') }}</th>
            <th colspan="6">ABET</th>
        </tr>
        <tr>
            @foreach ($chuanAbet as $abet)
            <th>{{ $abet->maChuanAbetVB }}</th>
            @endforeach
            
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($arr_thongkeKQ as $data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>
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
                <td>{{ number_format($data[1]*100,2) }}</td>
                <td>{{ number_format($data[2]*100,2) }}</td>
                <td>{{ number_format($data[3]*100,2) }}</td>
                <td>{{ number_format($data[4]*100,2) }}</td>
                <td>{{ number_format($data[5]*100,2) }}</td>
                <td>{{ number_format($data[6]*100,2) }}</td>
            </tr>
        @endforeach
       
    </tbody>
    <tfoot>
    </tfoot>
</table>