<table>
    <thead>
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody style="text-align: center">
        @php
            $jumlah_jualan_keseluruhan = 0;
        @endphp
        @foreach ($bulan_senarai as $bulan)
            @php
                $month_counter = $loop->iteration;
            @endphp

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $bulan }}</td>
                <td style="text-align: right">
                    @foreach ($datas as $data)
                        @if ($data[0]->bulan == $month_counter)
                            {{ number_format($data[0]->domestik) }}
                            @php
                                $jumlah_jualan_keseluruhan += $data[0]->domestik;
                            @endphp
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>
            <td style="text-align: right">{{ number_format($jumlah_jualan_keseluruhan) }}</td>
        </tr>
    </tbody>
    <tfoot>

    </tfoot>
</table>
