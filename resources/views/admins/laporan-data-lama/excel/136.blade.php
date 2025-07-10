<table>
    <thead>
        <tr><th>{{ $title }} Bagi Tahun {{ $tahun }}</th></tr>
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
                @foreach ($result->jumlahpengeluaran as $data)
                    @if (is_numeric($data))
                        <td>{{ number_format($data, 0) }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach

    </tbody>
    <tfoot>
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>

            @foreach ($grandtotal->jumlahpengeluaran as $total)
                @if (is_numeric($total))
                    <td>{{ number_format($total, 0) }}</td>
                @endif
            @endforeach

        </tr>
    </tfoot>
</table>
