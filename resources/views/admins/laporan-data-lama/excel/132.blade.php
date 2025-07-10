<table>
    <thead>
        <tr>
            <th>
                {{ $title }} Bagi Tahun
                        {{ $tahun }} Hingga Tahun {{ $tahunakhir }}
            </th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th >{{ $data }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

        @foreach ($results as $result)
            <tr >
                <td> {{ $loop->iteration }}</td>
                <td >{{ $result->negeri_keterangan }}</td>
                @foreach ($result->jumlahpengeluaran as $data)
                    @if (is_numeric($data))
                        <td >{{ number_format($data, 0) }}</td>
                    @endif
                @endforeach
            </tr>
        @endforeach
        <tr>
            <td><b>Jumlah (m³)</b></td>
            <td></td>
            @foreach ($grandtotal->jumlahpengeluaran as $total)
                @if (is_numeric($total))
                    <td >{{ number_format($total, 0) }}</td>
                @endif
            @endforeach
        </tr>

    </tbody>
</table>
