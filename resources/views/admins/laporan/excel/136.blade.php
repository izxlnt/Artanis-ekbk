<table id="example" class="text-center table-bordered">
    <thead style="background-color: #f3ce8f;">
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
            for ($x = 1; $x <= 12; $x++) {
                $jumlah_bulan[$x] = 0;
            }

            $jumlah_besar = 0;
        @endphp
        @foreach ($negeri_list as $negeri)
            @php
                $jumlah_row = 0;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $negeri->negeri }}</td>

                @foreach ($datas as $key => $data)
                    @if ($key == $negeri->negeri)
                        @foreach ($data as $bulan => $value)
                            <td style="text-align: right">{{ number_format($value[0]->jumlah_pengeluaran ?? 0) }}</td>

                            @php
                                $jumlah_row += $value[0]->jumlah_pengeluaran ?? 0;
                                $jumlah_bulan[$bulan] += $value[0]->jumlah_pengeluaran ?? 0;
                                $jumlah_besar += $value[0]->jumlah_pengeluaran ?? 0;
                            @endphp
                        @endforeach
                    @endif
                @endforeach



                <td style="text-align: right">{{ number_format($jumlah_row) }}</td>

            </tr>
        @endforeach

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>
            @for ($x = 1; $x <= 12; $x++)
                <td style="text-align: right">{{ number_format($jumlah_bulan[$x]) }}</td>
            @endfor
            <td style="text-align: right">{{ number_format($jumlah_besar) }}</td>
        </tr>
    </tbody>
</table>
