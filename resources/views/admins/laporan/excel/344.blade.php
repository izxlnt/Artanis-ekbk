<table>
    @php
        $jumlah_keseluruhan = 0;
    @endphp
    <thead style="background-color: #f3ce8f; font-weight: bold;">
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
        @foreach ($bulan_senarai as $key => $bulan)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $bulan }}</td>
                <td style="text-align: right">
                    @foreach ($datas as $index_bulan => $data)
                        @if ($index_bulan == $key + 1)
                            {{ number_format($data[0]->export ?? 0) }}
                            @php
                                $jumlah_keseluruhan += $data[0]->export ?? 0;
                            @endphp
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>
            <td style="text-align: right">{{ number_format($jumlah_keseluruhan) }}</td>
        </tr>
    </tbody>
</table>
