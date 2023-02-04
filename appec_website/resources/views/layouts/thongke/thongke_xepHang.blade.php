<table id="" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>STT</th>
            <th>Grand</th>
            <th>Quantity</th>
            <th>Ration (%)</th>
            <th>Accumulative ration</th>
        </tr>
    </thead>
    <tbody>
        @php
            $tongXepHang=0;
            $tongTiLe=0;
        @endphp
        @for ($i = 0; $i < count($xepHang); $i++)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    @switch($i+1)
                        @case(1)
                            Excellent
                        @break
                        @case(2)
                            Good
                        @break
                        @case(3)
                            Average
                        @break
                        @case(4)
                            Below average
                        @break
                        @case(5)
                            Weak
                        @break
                        @default
                    @endswitch
                </td>
                <td>{{ $xepHang[$i] }}</td>
                <td>{{ $tiLe[$i] }}%</td>
                <td></td>
            </tr>
            @php
                $tongXepHang+=$xepHang[$i];
                $tongTiLe+=$tiLe[$i];
            @endphp
        @endfor
            <tr>
                <td colspan="2"><b>Total</b></td>
                <td>
                    {{ $tongXepHang }}
                </td>
                <td>
                    {{ $tongTiLe }}%
                </td>
                <td></td>
            </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>