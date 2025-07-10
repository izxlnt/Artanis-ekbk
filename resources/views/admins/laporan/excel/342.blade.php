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
    <tbody>
        @php
            $jumlah_jualan_keseluruhan = 0;
        @endphp
        @foreach ($datas as $negeri => $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $negeri }}</td>
                <td style="text-align: right">
                    {{ number_format($data[0]->domestik) }}
                    @php
                        $jumlah_jualan_keseluruhan += $data[0]->domestik;
                    @endphp
                </td>
            </tr>
        @endforeach

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>JUMLAH</td>
            <td style="text-align: right">{{ number_format($jumlah_jualan_keseluruhan) }}</td>
        </tr>
    </tbody>
    <tfoot>

    </tfoot>
</table>
