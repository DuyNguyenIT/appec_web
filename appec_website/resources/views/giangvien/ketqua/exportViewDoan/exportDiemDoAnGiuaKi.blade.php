<h4>Cán bộ chấm: {{ $gv->hoGV }} {{ $gv->tenGV }}</h4>

<table >
    <thead>
        <tr>
            <th>STT</th>
            <th>Tên đề tài</th>
            <th>Sinh viên thực hiện</th>
            <th>Mã sinh viên</th>
            <th>Điểm CB</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
            $chayTenDT = 0;
            $maDe_cur = 0;
        @endphp
        @foreach ($deThi as $dt)
            @php
                $demTenDT = $deThi->where('maDe', $dt->maDe)->count();
                if ($chayTenDT > $demTenDT) {
                    $chayTenDT = 1;
                } else {
                    $chayTenDT += 1;
                }
                if ($maDe_cur !== $dt->maDe) {
                    $maDe_cur = $dt->maDe;
                    $chayTenDT = 1;
                }
            @endphp
            @if ($chayTenDT == 1)
                <tr>
                    <td rowspan={{ $demTenDT }}>{{ $i++ }}</td>
                    <td rowspan={{ $demTenDT }}>{{ $dt->tenDe }}</td>
                    <td>{{ $dt->HoSV }} {{ $dt->TenSV }}</td>
                    <td>{{ $dt->maSSV }}</td>
                    @if ($dt->trangThai == false)
                        <td>
                            {{ $dt->diemSo }}
                        </td>
                        <td>
                            {{ $dt->diemCB2 }}
                        </td>
                    @else
                        <td>{{ $dt->diemSo }}</td>
                    @endif
                </tr>
            @else
                <tr>
                    <td>{{ $dt->HoSV }} {{ $dt->TenSV }}</td>
                    <td>{{ $dt->maSSV }}</td>
                    @if ($dt->trangThai == false)
                        <td>
                        </td>
                        <td>
                        </td>
                    @else
                        <td>{{ $dt->diemSo }}</td>
                    @endif
                </tr>
            @endif
        @endforeach
    </tbody>
    <tfoot></tfoot>
</table>