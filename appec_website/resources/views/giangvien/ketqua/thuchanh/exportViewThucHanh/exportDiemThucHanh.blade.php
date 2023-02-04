<table>
    <thead>
        <tr>
            <th>{{ __('No.') }}</th>
            <th>{{ __('Student name') }}</th>
            <th>{{ __('Student Name') }}</th>
            <th>{{ __('Exame ID') }}</th>
            <th>{{ __('Mark') }}</th>
        </tr>
    </thead>
    <tbody>
        @php
            $i = 1;
        @endphp
        @foreach ($phieucham as $data)
            <tr>
                <td>{{ $i++ }}</td>
                <td>{{ $data->maSSV }}</td>
                <td>{{ $data->HoSV }} {{ $data->TenSV }}</td>
                <td>{{ $data->maDeVB }}</td>
                <td>{{ $data->diemSo }}</td>
            </tr>
        @endforeach
    </tbody>
    <tfoot></tfoot>
</table>