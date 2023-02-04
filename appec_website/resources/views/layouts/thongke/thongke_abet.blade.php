<table id="" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th rowspan="2">{{ __('No.') }}</th>
            <th rowspan="2">ABET's SOs ID</th>
            <th rowspan="2">ABET's SOs title</th>
            <th colspan="4">Achieve</th>
            <th rowspan="2" title="">Fail</th>
            <th rowspan="2">Total</th>
        </tr>
        <tr>
            <th>A</th>
            <th>B</th>
            <th>C</th>
            <th>D</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($bieuDo as $bd)
            @php
                $sum = 0;
                for ($t = 1; $t < 7; $t++) {
                    # code...
                    $sum += intval($bd[$t]);
                }
            @endphp
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $bd[0] }}</td>
                <td>{{ $bd[1] }}</td>
                <td>{{ $bd[2] }}</td>
                <td>{{ $bd[3] }}</td>
                <td>{{ $bd[4] }}</td>
                <td>{{ $bd[5] }}</td>
                <td>{{ $bd[6] }}</td>
                <td>{{ $sum }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
    </tfoot>
</table>