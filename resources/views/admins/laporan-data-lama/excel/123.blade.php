<table>
    <thead>
        <tr>
            <th>{{ $title }} Bagi Tahun
                {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody style="text-align: center">
        @php
            $keseluruhan_johor = 0;
            $keseluruhan_kedah = 0;
            $keseluruhan_kelantan = 0;
            $keseluruhan_melaka = 0;
            $keseluruhan_n9 = 0;
            $keseluruhan_pahang = 0;
            $keseluruhan_perak = 0;
            $keseluruhan_perlis = 0;
            $keseluruhan_penang = 0;
            $keseluruhan_selangor = 0;
            $keseluruhan_tganu = 0;
            $keseluruhan_kl = 0;
            $keseluruhan_kumpulan = 0;
        @endphp
        @foreach ($kumpulan_kayu as $kayu)
            <tr style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td>{{ $kayu->singkatan }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                $jumlah_johor = 0;
                $jumlah_kedah = 0;
                $jumlah_kelantan = 0;
                $jumlah_melaka = 0;

                $jumlah_n9 = 0;
                $jumlah_pahang = 0;
                $jumlah_perak = 0;
                $jumlah_perlis = 0;

                $jumlah_penang = 0;
                $jumlah_selangor = 0;
                $jumlah_tganu = 0;
                $jumlah_kl = 0;

                $jumlah_kumpulan = 0;
            @endphp

            @foreach ($results as $data)
                @if (strtolower($data->spesies_kumpulankayu) == strtolower($kayu->singkatan))
                    @php
                        $jumlah_row = 0;
                    @endphp

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $data->spesies_namatempatan }}</td>

                        <td>{{ number_format($data->jumlahpenggunaan[0], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[0];
                            $jumlah_johor += $data->jumlahpenggunaan[0];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[0];

                            $keseluruhan_johor += $data->jumlahpenggunaan[0];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[0];
                        @endphp
                        <td>{{ number_format($data->jumlahpenggunaan[1], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[1];
                            $jumlah_kedah += $data->jumlahpenggunaan[1];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[1];

                            $keseluruhan_kedah += $data->jumlahpenggunaan[1];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[1];
                        @endphp
                        <td>{{ number_format($data->jumlahpenggunaan[2], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[2];
                            $jumlah_kelantan += $data->jumlahpenggunaan[2];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[2];

                            $keseluruhan_kelantan += $data->jumlahpenggunaan[2];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[2];
                        @endphp
                        <td>{{ number_format($data->jumlahpenggunaan[3], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[3];
                            $jumlah_melaka += $data->jumlahpenggunaan[3];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[3];

                            $keseluruhan_melaka += $data->jumlahpenggunaan[3];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[3];
                        @endphp

                        <td>{{ number_format($data->jumlahpenggunaan[4], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[4];
                            $jumlah_n9 += $data->jumlahpenggunaan[4];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[4];

                            $keseluruhan_n9 += $data->jumlahpenggunaan[4];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[4];
                        @endphp
                        <td>{{ number_format($data->jumlahpenggunaan[5], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[5];
                            $jumlah_pahang += $data->jumlahpenggunaan[5];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[5];

                            $keseluruhan_pahang += $data->jumlahpenggunaan[5];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[5];
                        @endphp
                        <td>{{ number_format($data->jumlahpenggunaan[6], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[6];
                            $jumlah_perak += $data->jumlahpenggunaan[6];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[6];

                            $keseluruhan_perak += $data->jumlahpenggunaan[6];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[6];
                        @endphp
                        <td>{{ number_format($data->jumlahpenggunaan[7], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[7];
                            $jumlah_perlis += $data->jumlahpenggunaan[7];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[7];

                            $keseluruhan_perlis += $data->jumlahpenggunaan[7];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[7];
                        @endphp

                        <td>{{ number_format($data->jumlahpenggunaan[8], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[8];
                            $jumlah_penang += $data->jumlahpenggunaan[8];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[8];

                            $keseluruhan_penang += $data->jumlahpenggunaan[8];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[8];
                        @endphp
                        <td>{{ number_format($data->jumlahpenggunaan[9], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[9];
                            $jumlah_selangor += $data->jumlahpenggunaan[9];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[9];

                            $keseluruhan_selangor += $data->jumlahpenggunaan[9];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[9];
                        @endphp
                        <td>{{ number_format($data->jumlahpenggunaan[10], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[10];
                            $jumlah_tganu += $data->jumlahpenggunaan[10];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[10];

                            $keseluruhan_tganu += $data->jumlahpenggunaan[10];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[10];
                        @endphp
                        <td>{{ number_format($data->jumlahpenggunaan[11], 0) }}</td>
                        @php
                            $jumlah_row += $data->jumlahpenggunaan[11];
                            $jumlah_kl += $data->jumlahpenggunaan[11];
                            $jumlah_kumpulan += $data->jumlahpenggunaan[11];

                            $keseluruhan_kl += $data->jumlahpenggunaan[11];
                            $keseluruhan_kumpulan += $data->jumlahpenggunaan[11];
                        @endphp

                        <td>{{ number_format($jumlah_row, 0) }}</td>

                    </tr>
                @endif
            @endforeach




            <tr class="text-bold" style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td>Jumlah {{ $kayu->singkatan }}</td>
                <td>{{ number_format($jumlah_johor, 0) }}</td>
                <td>{{ number_format($jumlah_kedah, 0) }}</td>
                <td>{{ number_format($jumlah_kelantan, 0) }}</td>
                <td>{{ number_format($jumlah_melaka, 0) }}</td>
                <td>{{ number_format($jumlah_n9, 0) }}</td>
                <td>{{ number_format($jumlah_pahang, 0) }}</td>
                <td>{{ number_format($jumlah_perak, 0) }}</td>
                <td>{{ number_format($jumlah_perlis, 0) }}</td>
                <td>{{ number_format($jumlah_penang, 0) }}</td>
                <td>{{ number_format($jumlah_selangor, 0) }}</td>
                <td>{{ number_format($jumlah_tganu, 0) }}</td>
                <td>{{ number_format($jumlah_kl, 0) }}</td>
                <td>{{ number_format($jumlah_kumpulan, 0) }}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach
    </tbody>
    <tfoot>
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>JUMLAH BESAR (m³)</td>

            <td>{{ number_format($keseluruhan_johor, 0) }}</td>
            <td>{{ number_format($keseluruhan_kedah, 0) }}</td>
            <td>{{ number_format($keseluruhan_kelantan, 0) }}</td>
            <td>{{ number_format($keseluruhan_melaka, 0) }}</td>

            <td>{{ number_format($keseluruhan_n9, 0) }}</td>
            <td>{{ number_format($keseluruhan_pahang, 0) }}</td>
            <td>{{ number_format($keseluruhan_perak, 0) }}</td>
            <td>{{ number_format($keseluruhan_perlis, 0) }}</td>

            <td>{{ number_format($keseluruhan_penang, 0) }}</td>
            <td>{{ number_format($keseluruhan_selangor, 0) }}</td>
            <td>{{ number_format($keseluruhan_tganu, 0) }}</td>
            <td>{{ number_format($keseluruhan_kl, 0) }}</td>

            <td>{{ number_format($keseluruhan_kumpulan, 0) }}</td>
        </tr>
    </tfoot>
</table>
