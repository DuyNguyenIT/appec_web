<p>THỐNG KÊ ABET THEO NĂM HỌC<p>
<p>Unit: %</p>
<table id="" class="table table-bordered table-hover" style="border-collapse: collapse;">
    <thead>
        <tr>
            <th rowspan="3">{{ __('No.') }}</th>
            <th rowspan="3">{{ __('Year') }}</th>
            <th rowspan="3">{{ __('Semester') }}</th>
            <th rowspan="3">{{ __('Class') }}</th>
            <th rowspan="3">{{ __('Course') }}</th>
            <th colspan="30">ABET</th>
        </tr>
        <tr>
            @foreach ($chuanAbet as $abet)
                <th colspan="5">{{ $abet->maChuanAbetVB }}</th>
            @endforeach
        </tr>
        <tr>
            @foreach ($chuanAbet as $abet)
                <th>A</th>
                <th>B</th>
                <th>C</th>
                <th>D</th>
                <th>Fail</th>
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
                <td>{{ number_format($data[10]*100,2) }}</td>
                <td>{{ number_format($data[11]*100,2) }}</td>
                <td>{{ number_format($data[12]*100,2) }}</td>
                <td>{{ number_format($data[13]*100,2) }}</td>
                <td>{{ number_format($data[14]*100,2) }}</td>
                <td>{{ number_format($data[15]*100,2) }}</td>
                <td>{{ number_format($data[16]*100,2) }}</td>
                <td>{{ number_format($data[17]*100,2) }}</td>
                <td>{{ number_format($data[18]*100,2) }}</td>
                <td>{{ number_format($data[19]*100,2) }}</td>
                <td>{{ number_format($data[20]*100,2) }}</td>
                <td>{{ number_format($data[21]*100,2) }}</td>
                <td>{{ number_format($data[22]*100,2) }}</td>
                <td>{{ number_format($data[23]*100,2) }}</td>
                <td>{{ number_format($data[24]*100,2) }}</td>
                <td>{{ number_format($data[25]*100,2) }}</td>
                <td>{{ number_format($data[26]*100,2) }}</td>
                <td>{{ number_format($data[27]*100,2) }}</td>
                <td>{{ number_format($data[28]*100,2) }}</td>
                <td>{{ number_format($data[29]*100,2) }}</td>
                <td>{{ number_format($data[30]*100,2) }}</td>
                <td>{{ number_format($data[31]*100,2) }}</td>
                <td>{{ number_format($data[32]*100,2) }}</td>
                <td>{{ number_format($data[33]*100,2) }}</td>

            </tr>
        @endforeach
       
    </tbody>
    <tfoot>
    </tfoot>
</table>