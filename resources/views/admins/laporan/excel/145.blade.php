<table id="example" class="text-center table-bordered" style="width: 100%">
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
    <tbody style="text-align: center">

        @php
            foreach ($negeri_list as $negeri_name) {
                $jumlah_negeri[$negeri_name->negeri] = 0;
            }

            $jumlah_keseluruhan = 0;
        @endphp

        @foreach ($datas as $pembeli => $data_pembeli)
            @php
                $jumlah_row = 0;
            @endphp

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $pembeli }}</td>
                @foreach ($data_pembeli as $negeri => $data)
                    <td style="text-align: right">{{ number_format($data[0]->jumlah_jualan) }}</td>
                    @php
                        $jumlah_row += $data[0]->jumlah_jualan;
                        $jumlah_negeri[$negeri] += $data[0]->jumlah_jualan;
                        $jumlah_keseluruhan += $data[0]->jumlah_jualan;
                    @endphp
                @endforeach

                <td style="text-align: right">{{ number_format($jumlah_row) }}</td>
            </tr>
        @endforeach
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>

            @foreach ($negeri_list as $nama_negeri)
                <td style="text-align: right">{{ number_format($jumlah_negeri[$nama_negeri->negeri]) }}</td>
            @endforeach

            <td style="text-align: right">{{ number_format($jumlah_keseluruhan) }}</td>
        </tr>
    </tbody>

</table>
