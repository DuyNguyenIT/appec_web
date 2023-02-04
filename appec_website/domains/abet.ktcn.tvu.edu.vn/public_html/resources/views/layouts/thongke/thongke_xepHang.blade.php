<table id="" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>STT</th>
            <th>Xếp loại</th>
            <th>Số lượng</th>
            <th>Tỉ lệ (%)</th>
            <th>Tỉ lệ tích lũy</th>
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
                            Giỏi
                        @break
                        @case(2)
                            Khá
                        @break
                        @case(3)
                            Trung bình
                        @break
                        @case(4)
                            Yếu
                        @break
                        @case(5)
                            Kém
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
                <td colspan="2"><b>Tổng</b></td>
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