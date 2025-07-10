<table>
    <thead style="background-color: #f3ce8f;">
        <tr>
            <th>{{ $title }} Bagi Tahun
                {{ $tahun }} Hingga Tahun {{ $tahunakhir }}
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

        <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
            <td class="text-left"></td>
            <td class="text-left">Jumlah (m³)</td>
            <td class="text-left">Nipis</td>
            @foreach ($grandtotal->jumlahpengeluaran['nipis'] as $data)
                <td class="text-right">{{ number_format($data, 0) }}</td>
            @endforeach
        </tr>
        <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td class="text-left"></td>
            <td class="text-left">Tebal</td>
            @foreach ($grandtotal->jumlahpengeluaran['tebal'] as $data)
                @if (is_numeric($data))
                    <td class="text-right">{{ number_format($data, 0) }}</td>
                @endif
            @endforeach
        </tr>
    </tbody>
</table>
