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

    @php
        $jumlah_setiap_negeri = 0;
    @endphp

    <tbody>

        @foreach ($results as $result)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td>{{ $result->negeri_keterangan }}</td>
                <td>
                    {{ number_format($result->rekod_nilaiharta, 2) }}
                    @php
                        $jumlah_setiap_negeri += $result->rekod_nilaiharta;
                    @endphp
                </td>
            </tr>
        @endforeach


    </tbody>
    <tfoot>
        <tr style="background-color: lightgray;">
            <td></td>
            <td><b>JUMLAH</b></td>
            <td><b>{{ number_format($jumlah_setiap_negeri, 2) }}</b></td>
        </tr>
    </tfoot>
</table>
