@foreach ($results as $key => $suku)
<table>
    <thead>
        @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
            <tr>
                <th>
                    {{ $title }} : Suku
                    Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi
                    Tahun
                    {{ $tahun }}
                </th>
            </tr>
        @else
            <tr>
                <th>
                    {{ $title }} : Suku
                    Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun
                    {{ $tahun }}
                </th>
            </tr>
        @endif

        @if ($key == 1)
            <tr>
                <th>
                    Suku
                    Tahun Pertama
                </th>
            </tr>
        @elseif($key == 2)
            <tr>
                <th>
                    Suku
                    Tahun Kedua
                </th>
            </tr>
        @elseif($key == 3)
            <tr>
                <th>
                    Suku
                    Tahun Ketiga
                </th>
            </tr>
        @else
            <tr>
                <th>
                    Suku
                    Tahun Keempat
                </th>
            </tr>
        @endif
        <tr>
            @foreach ($columns as $data)
                @if ($data == 'Bumiputera')
                    <th colspan="3">{{ $data }}</th>
                @elseif($data == 'Bukan Bumiputera')
                    <th colspan="3">{{ $data }}</th>
                @elseif($data == 'Bukan Warganegara')
                    <th colspan="3">{{ $data }}</th>
                @elseif($data == 'Bukan Warganegara')
                    <th colspan="3">{{ $data }}</th>
                @elseif($data == 'Jumlah Guna Tenaga')
                    <th colspan="3">{{ $data }}</th>
                @elseif($data == 'Pendapatan (RM)')
                    <th colspan="3">{{ $data }}</th>
                @elseif($data == 'Purata Pendapatan (RM)')
                    <th colspan="3">{{ $data }}</th>
                @else
                    <th rowspan="2">{{ $data }}</th>
                @endif
            @endforeach
        </tr>
        <tr>
            <th>L</th>
            <th>P</th>
            <th>Jumlah (L+P)</th>

            <th>L</th>
            <th>P</th>
            <th>Jumlah (L+P)</th>

            <th>L</th>
            <th>P</th>
            <th>Jumlah (L+P)</th>

            <th>L</th>
            <th>P</th>
            <th>Jumlah (L+P)</th>

            <th>L</th>
            <th>P</th>
            <th>Jumlah (L+P)</th>

            <th>L</th>
            <th>P</th>
            <th>Jumlah (L+P)</th>
        </tr>
    </thead>
    <tbody>
        @php

            $jumlah_bumi_lelaki = 0;
            $jumlah_bumi_perempuan = 0;
            $jumlah_bumiputera = 0;

            $jumlah_bukan_bumi_lelaki = 0;
            $jumlah_bukan_bumi_perempuan = 0;
            $jumlah_bukan_bumiputera = 0;

            $jumlah_bukan_warga_lelaki = 0;
            $jumlah_bukan_warga_perempuan = 0;
            $jumlah_bukan_warganegara = 0;

            $jumlah_jumlah_lelaki = 0;
            $jumlah_jumlah_perempuan = 0;
            $jumlah_jumlah_jumlah = 0;

            $jumlah_gaji_lelaki = 0;
            $jumlah_gaji_perempuan = 0;
            $jumlah_pendapatan = 0;

            $jumlah_purata_lelaki = 0;
            $jumlah_purata_perempuan = 0;
            $jumlah_purata_keseluruhan = 0;

        @endphp

        @foreach ($suku as $result)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $result->kod_keterangan }}</td>

                <td>{{ number_format($result->wargabumi->l, 0) }}</td>
                <td>{{ number_format($result->wargabumi->p, 0) }}</td>
                <td>{{ number_format($result->wargabumi->jumlah, 0) }}</td>

                <td>{{ number_format($result->wargabukanbumi->l, 0) }}</td>
                <td>{{ number_format($result->wargabukanbumi->p, 0) }}</td>
                <td>{{ number_format($result->wargabukanbumi->jumlah, 0) }}</td>

                <td>{{ number_format($result->bukanwarga->l, 0) }}</td>
                <td>{{ number_format($result->bukanwarga->p, 0) }}</td>
                <td>{{ number_format($result->bukanwarga->jumlah, 0) }}</td>

                <td>{{ number_format($result->keseluruhan->l, 0) }}</td>
                <td>{{ number_format($result->keseluruhan->p, 0) }}</td>
                <td>{{ number_format($result->keseluruhan->jumlah, 0) }}</td>

                <td>{{ number_format($result->pendapatan->l, 2) }}</td>
                <td>{{ number_format($result->pendapatan->p, 2) }}</td>
                <td>{{ number_format($result->pendapatan->jumlah, 2) }}</td>

                <td>{{ number_format($result->purata->l, 2) }}</td>
                <td>{{ number_format($result->purata->p, 2) }}</td>
                <td>{{ number_format($result->purata->jumlah, 2) }}</td>
            </tr>

            @php

                $jumlah_bumi_lelaki += $result->wargabumi->l;
                $jumlah_bumi_perempuan += $result->wargabumi->p;
                $jumlah_bumiputera += $result->wargabumi->jumlah;

                $jumlah_bukan_bumi_lelaki += $result->wargabukanbumi->l;
                $jumlah_bukan_bumi_perempuan += $result->wargabukanbumi->p;
                $jumlah_bukan_bumiputera += $result->wargabukanbumi->jumlah;

                $jumlah_bukan_warga_lelaki += $result->bukanwarga->l;
                $jumlah_bukan_warga_perempuan += $result->bukanwarga->p;
                $jumlah_bukan_warganegara += $result->bukanwarga->jumlah;

                $jumlah_jumlah_lelaki += $result->keseluruhan->l;
                $jumlah_jumlah_perempuan += $result->keseluruhan->p;
                $jumlah_jumlah_jumlah += $result->keseluruhan->jumlah;

                $jumlah_gaji_lelaki += $result->pendapatan->l;
                $jumlah_gaji_perempuan += $result->pendapatan->p;
                $jumlah_pendapatan += $result->pendapatan->jumlah;

                $jumlah_purata_lelaki += $result->purata->l;
                $jumlah_purata_perempuan += $result->purata->p;
                $jumlah_purata_keseluruhan += $result->purata->jumlah;

            @endphp
        @endforeach


    </tbody>
    <tfoot>

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah</td>

            <td>{{ number_format($jumlah_bumi_lelaki, 0) }}</td>
            <td>{{ number_format($jumlah_bumi_perempuan, 0) }}</td>
            <td>{{ number_format($jumlah_bumiputera, 0) }}</td>

            <td>{{ number_format($jumlah_bukan_bumi_lelaki, 0) }}</td>
            <td>{{ number_format($jumlah_bukan_bumi_perempuan, 0) }}</td>
            <td>{{ number_format($jumlah_bukan_bumiputera, 0) }}</td>

            <td>{{ number_format($jumlah_bukan_warga_lelaki, 0) }}</td>
            <td>{{ number_format($jumlah_bukan_warga_perempuan, 0) }}</td>
            <td>{{ number_format($jumlah_bukan_warganegara, 0) }}</td>

            <td>{{ number_format($jumlah_jumlah_lelaki, 0) }}</td>
            <td>{{ number_format($jumlah_jumlah_perempuan, 0) }}</td>
            <td>{{ number_format($jumlah_jumlah_jumlah, 0) }}</td>

            <td> {{ number_format($jumlah_gaji_lelaki, 2) }}</td>
            <td> {{ number_format($jumlah_gaji_perempuan, 2) }}</td>
            <td> {{ number_format($jumlah_pendapatan, 2) }}</td>

            <td> {{ number_format(($jumlah_gaji_lelaki / max($jumlah_jumlah_lelaki, 1)), 2) }}</td>
            <td> {{ number_format(($jumlah_gaji_perempuan / max($jumlah_jumlah_perempuan, 1)), 2) }}</td>
            <td> {{ number_format(($jumlah_pendapatan / max($jumlah_jumlah_jumlah, 1)), 2) }}</td>

        </tr>
    </tfoot>
</table>
@endforeach
