<table>
    <thead style="background-color: #f3ce8f;">
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
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td>{{ $result->negeri_keterangan }}</td>
                <td>Nipis</td>
                @foreach ($result->jumlahpengeluaran->nipis as $data)
                    @if (is_numeric($data))
                        <td>{{ number_format($data, 0) }}</td>
                    @endif
                @endforeach
            </tr>
            <tr>
                <td></td>
                <td></td>
                <td>Tebal</td>
                @foreach ($result->jumlahpengeluaran->tebal as $data)
                    @if (is_numeric($data))
                        <td>{{ number_format($data, 0) }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>
            <td>Nipis</td>
            @foreach ($grandtotal->jumlahpengeluaran['nipis'] as $data)
                <td>{{ number_format($data, 0) }}</td>
            @endforeach
        </tr>
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td></td>
            <td>Tebal</td>
            @foreach ($grandtotal->jumlahpengeluaran['tebal'] as $data)
                @if (is_numeric($data))
                    <td>{{ number_format($data, 0) }}</td>
                @endif
            @endforeach
        </tr>

    </tbody>
</table>
