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
        @endfor
    </tbody>
    <tfoot>
    </tfoot>
</table>