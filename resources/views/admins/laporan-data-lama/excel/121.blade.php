<table>
    <thead>
        <tr>
            <th>{{ $title }} Bagi Tahun {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
            for ($bulan_counter = 1; $bulan_counter <= 12; $bulan_counter++) {
                $jumlah_column[$bulan_counter] = 0;
            }
            $jumlah_keseluruhan = 0;
        @endphp

        @foreach ($results as $result)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $result->negeri_keterangan }}</td>
                @foreach ($result->jumlahpenggunaan as $data)
                    <td>{{ number_format($data, 0) }}</td>
                @endforeach
            </tr>
        @endforeach


    </tbody>
    <tfoot>
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>

            @foreach ($grandtotal->jumlahpenggunaan as $total)
                <td>{{ number_format($total, 0) }}</td>
            @endforeach
        </tr>
    </tfoot>
</table>
