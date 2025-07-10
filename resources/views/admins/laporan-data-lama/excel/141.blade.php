<table>
    <thead style="background-color: #f3ce8f">
        <tr>
            <th>
                {{ $title }} Bagi Tahun
                {{ $tahun }}
            </th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

        @foreach ($results as $result)
            @if ($shuttle == 'shuttle4')
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $result->kayugergaji->bulan }}</td>
                    <td>{{ number_format($result->papanlapis->jualantempatan, 0) }}</td>
                    <td>{{ number_format($result->venier->jualantempatan, 0) }}</td>
                </tr>
            @elseif ($shuttle == 'shuttle5')
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $result->kayukumai->bulan }}</td>
                    <td>{{ number_format($result->kayukumai->jualantempatan, 0) }}</td>
                </tr>
            @else
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $result->kayugergaji->bulan }}</td>
                    <td>{{ number_format($result->kayugergaji->jualantempatan, 0) }}</td>
                </tr>
            @endif
        @endforeach

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>
            @if ($shuttle == 'shuttle4')
                @foreach ($grandtotal->jualantempatan as $total)
                    <td>{{ number_format($total, 0) }}</td>
                @endforeach
            @elseif ($shuttle == 'shuttle5')
                @foreach ($grandtotal->jualantempatan as $total)
                    <td>{{ number_format($total, 0) }}</td>
                    @break
                @endforeach
            @else
                @foreach ($grandtotal->jualantempatan as $total)
                    @if (is_numeric($total))
                        <td>{{ number_format($total, 0) }}</td>
                    @endif
                    @break
                @endforeach
            @endif
        </tr>
</tbody>
</table>
