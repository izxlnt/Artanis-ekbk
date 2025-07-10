<table>
    <thead style="background-color: #f3ce8f;">
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
        @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
            @php
                $jumlah_col = 0;
                $total[$x] = 0;
            @endphp
        @endfor

        @foreach ($datas as $negeri => $data_tahun)
            @php
                $jumlah_row = 0;
            @endphp

            <tr>
                <td> {{ $loop->iteration }}</td>
                <td> {{ $negeri }}</td>
                @foreach ($data_tahun as $tahun => $data)
                    <td style="text-align: right">{{ number_format($data[0]->jumlah_pengeluaran) }}</td>
                    @php
                        $jumlah_row = $jumlah_row + $data[0]->jumlah_pengeluaran;
                        $total[$tahun] = $total[$tahun] + $data[0]->jumlah_pengeluaran;
                    @endphp
                @endforeach
                {{-- <td>{{ number_format($jumlah_row) }}</td> --}}

            </tr>
        @endforeach



        @php
            $jumlah_keseluruhan = 0;
        @endphp

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah</td>
            @foreach ($grandtotal as $key => $jumlah)
                {{-- <td>{{ number_format($jumlah, 0) }}</td> --}}
            @endforeach

            <td style="text-align: right">{{ number_format($jumlah, 0) }}</td>

        </tr>
    </tbody>
</table>
