<table>
    <thead style="background-color: #f3ce8f;">
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @if ($title == '233')
            @foreach ($results as $result)
                <tr>
                    <td> {{ $loop->iteration }}</td>
                    <td>{{ $result->negeri_keterangan }}</td>
                    <td>MR</td>
                    @foreach ($result->jumlahpengeluaran->mr as $data)
                        @if (is_numeric($data))
                            <td>{{ number_format($data, 0) }}</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>WBP</td>
                    @foreach ($result->jumlahpengeluaran->wbp as $data)
                        @if (is_numeric($data))
                            <td>{{ number_format($data, 0) }}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        @else
            @foreach ($results as $result)
                <tr>
                    <td> {{ $loop->iteration }}</td>
                    <td>{{ $result->negeri_keterangan }}</td>
                    <td>Muka/Face</td>
                    @foreach ($result->jumlahpengeluaran->muka as $data)
                        @if (is_numeric($data))
                            <td>{{ number_format($data, 0) }}</td>
                        @endif
                    @endforeach
                </tr>
                <tr>
                    <td></td>
                    <td></td>
                    <td>Teras/Core</td>
                    @foreach ($result->jumlahpengeluaran->teras as $data)
                        @if (is_numeric($data))
                            <td>{{ number_format($data, 0) }}</td>
                        @endif
                    @endforeach
                </tr>
            @endforeach
        @endif

        @if ($title == '233')
            <tr style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td>Jumlah (m³)</td>
                <td>MR</td>
                @foreach ($grandtotal->jumlahpengeluaran['mr'] as $data)
                    <td>{{ number_format($data, 0) }}</td>
                @endforeach
            </tr>
            <tr style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td></td>
                <td>WBP</td>
                @foreach ($grandtotal->jumlahpengeluaran['wbp'] as $data)
                    @if (is_numeric($data))
                        <td>{{ number_format($data, 0) }}</td>
                    @endif
                @endforeach
            </tr>
        @else
            <tr style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td>Jumlah (m³)</td>
                <td>Muka/Face</td>
                @foreach ($grandtotal->jumlahpengeluaran['muka'] as $data)
                    <td>{{ number_format($data, 0) }}</td>
                @endforeach
            </tr>
            <tr style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td></td>
                <td>Teras/Core</td>
                @foreach ($grandtotal->jumlahpengeluaran['teras'] as $data)
                    @if (is_numeric($data))
                        <td>{{ number_format($data, 0) }}</td>
                    @endif
                @endforeach
            </tr>
        @endif

    </tbody>
</table>
