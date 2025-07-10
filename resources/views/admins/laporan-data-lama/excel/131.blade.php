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
                <td>{{ $loop->iteration }}</td>
                <td>{{ $result->negeri_keterangan }}</td>
                @if ($title == "36. Pengeluaran Venir Mengikut Negeri Dan Bulan")
                    @foreach ($result->jumlahpengeluaran->venier as $data)
                        @if (is_numeric($data))
                            <td>{{ number_format($data, 0) }}</td>
                        @endif
                    @endforeach
                @else
                    @foreach ($result->jumlahpengeluaran as $data)
                        @if (is_numeric($data))
                            <td>{{ number_format($data, 0) }}</td>
                        @endif
                    @endforeach
                @endif
            </tr>
        @endforeach
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>
            @foreach ($grandtotal->jumlahpengeluaran as $total)
                @if (is_numeric($total))
                    <td>{{ number_format($total, 0) }}</td>
                @endif
            @endforeach

        </tr>

    </tbody>

</table>
