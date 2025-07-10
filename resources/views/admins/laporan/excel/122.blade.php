<table>
    <thead>
        <tr>
            <th>{{ strtoupper($title) }} DARI TAHUN
                {{ $tahun_mula }} HINGGA {{ $tahun_akhir }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
        @foreach ($datas as $negeri => $data_negeri)
            @php
                $jumlah_row = 0;
            @endphp

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td> {{ $negeri }}</td>

                @foreach ($data_negeri as $tahun => $data)
                    @php
                        $jumlah_col = 0;
                        $total[$tahun] = 0;
                    @endphp
                    <td style="text-align: right">{{ number_format($data[0]->jumlah_penggunaan, 0) }}</td>
                    @php
                        $jumlah_row = $jumlah_row + $data[0]->jumlah_penggunaan;
                        $total[$tahun] = $total[$tahun] + $data[0]->jumlah_penggunaan;
                    @endphp
                @endforeach

                {{-- <td>{{ number_format($jumlah_row, 0) }}</td> --}}

            </tr>
        @endforeach

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah</td>
            @foreach ($grandtotal as $jumlah)
                {{-- <td>{{ number_format($jumlah, 0) }}</td> --}}
            @endforeach
            <td style="text-align: right">{{ number_format($jumlah, 0) }}</td>

        </tr>
    </tbody>
</table>
