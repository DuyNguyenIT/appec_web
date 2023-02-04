<table>
    <thead>
        <tr>
            <th>{{ __('No.') }}</th>
            <th>{{ __('Student ID') }}</th>
            <th>{{ __('Student Name') }}</th>
            <th>{{ __('Exame ID') }}</th>
            <th>{{ __('Mark') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($phieucham as $pc)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $pc->maSSV }}</td>
                <td>{{ $pc->HoSV }} {{ $pc->TenSV }}</td>
                <td>{{ $pc->maDeVB }}</td>
                <td>
                    @if ($pc->diemSo != 0)
                        {{ $pc->diemSo }}
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>
</table>