<table id="" class="table table-bordered table-hover">
    <thead>
        <tr>
            <th>STT</th>
            <th>Điểm chữ</th>
            <th>Số lượng</th>
            <th>Tỉ lệ (%)</th>
            <th>Tỉ lệ tích lũy</th>
        </tr>
    </thead>
    <tbody>
        @php
            $tongSL=$tongTiLe=0;
        @endphp
        @for ($i = 0; $i < 8; $i++)
            <tr>
                <td>{{ $i + 1 }}</td>
                <td>
                    {{ $chu[$i] }}
                </td>
                <td>{{ $diemChu[$i] }}</td>
                <td>{{ $tiLe[$i] }}%</td>
                <td></td>
            </tr>
            @php
                $tongSL+=$diemChu[$i];
                $tongTiLe+=$tiLe[$i];
            @endphp
        @endfor
        <tr>
            <td colspan="2"><b>Tổng</b></td>
            <td>{{ $tongSL }}</td>
            <td>{{ $tongTiLe }}</td>
            <td></td>
        </tr>
    </tbody>
    <tfoot>
    </tfoot>
</table>