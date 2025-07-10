<table id="example" class="table-bordered">
    <thead>
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>

            <th>Bil</th>
            <th>Negeri</th>
            <th>Harta Tetap</th>

        </tr>
    </thead>
    <tbody>

        @foreach ($negeri_list as $key => $negeri)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
                    {{ $negeri->negeri }}
                </td>
                @php
                    $jumlah_by_negeri = 0;
                    foreach ($datas as $jumlah) {
                        if ($jumlah->negeri == $negeri->negeri) {
                            $jumlah_by_negeri = $jumlah->jumlah;
                        }
                    }
                @endphp
                <td style="text-align: right">
                    RM {{ number_format($jumlah_by_negeri, 2) }}
                </td>
            </tr>
        @endforeach

        <tr style="background-color: lightgray;">

            @php
                $jumlah_setiap_negeri = 0;

                foreach ($datas as $data) {
                    $jumlah_setiap_negeri = $jumlah_setiap_negeri + $data->jumlah;
                }
            @endphp
            <td></td>
            <td><b>JUMLAH</b></td>
            <td style="text-align: right"><b>RM
                    {{ number_format($jumlah_setiap_negeri, 2) }}</b>
            </td>
        </tr>
    </tbody>

</table>
