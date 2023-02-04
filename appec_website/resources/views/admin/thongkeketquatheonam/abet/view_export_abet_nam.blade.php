<p>Unit: %</p>
<table id="" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th rowspan="2">{{ __('No.') }}</th>
            <th rowspan="2">{{ __('Year') }}</th>
            <th rowspan="2">{{ __('Semester') }}</th>
            <th rowspan="2">{{ __('Class') }}</th>
            <th rowspan="2">{{ __('Course') }}</th>
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
                <td>{{ $data[0] }}</td>
                <td>{{ $data[1] }}</td>
                <td>{{ $data[2] }}</td>
                <td>
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
                <td>{{ number_format($data[4]*100,2) }}</td>
                <td>{{ number_format($data[5]*100,2) }}</td>
                <td>{{ number_format($data[6]*100,2) }}</td>
                <td>{{ number_format($data[7]*100,2) }}</td>
                <td>{{ number_format($data[8]*100,2) }}</td>
                <td>{{ number_format($data[9]*100,2) }}</td>
            </tr>
        @endforeach
       
    </tbody>
    <tfoot>
    </tfoot>
</table>