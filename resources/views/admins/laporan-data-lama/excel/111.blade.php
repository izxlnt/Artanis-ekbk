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
                        @if ($data == 'Guna Tenaga')
                            <th colspan="3">{{ $data }}</th>
                        @elseif($data == 'Pendapatan (RM)')
                            <th colspan="3">{{ $data }}</th>
                        @elseif($data == 'Purata (RM)')
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

                </tr>
            </thead>
            <tbody>

                @php

                    $jumlah_lelaki = 0;
                    $jumlah_perempuan = 0;
                    $jumlah_guna_tenaga = 0;

                    $jumlah_gaji_lelaki = 0;
                    $jumlah_gaji_perempuan = 0;
                    $jumlah_pendapatan = 0;

                    $jumlah_purata_lelaki = 0;
                    $jumlah_purata_perempuan = 0;
                    $jumlah_purata_keseluruhan = 0;

                @endphp

                @foreach ($suku as $result)
                    <tr>
                        <td> {{ $loop->iteration }}</td>
                        <td>{{ $result->negeri_keterangan }}</td>
                        <td>
                            {{ number_format($result->gunatenaga->l, 0) }}
                        </td>
                        @php
                            $jumlah_lelaki += $result->gunatenaga->l;
                        @endphp
                        <td>
                            {{ number_format($result->gunatenaga->p, 0) }}
                        </td>
                        @php
                            $jumlah_perempuan += $result->gunatenaga->p;
                        @endphp
                        <td>
                            {{ number_format($result->gunatenaga->jumlah, 0) }}</td>
                        @php
                            $jumlah_guna_tenaga += $result->gunatenaga->jumlah;
                        @endphp


                        <td>
                            {{ number_format($result->pendapatan->l, 2) }}
                        </td>
                        @php
                            $jumlah_gaji_lelaki += $result->pendapatan->l;
                        @endphp
                        <td>
                            {{ number_format($result->pendapatan->p, 2) }}
                        </td>
                        @php
                            $jumlah_gaji_perempuan += $result->pendapatan->p;
                        @endphp
                        <td>
                            {{ number_format($result->pendapatan->jumlah, 2) }}</td>
                        @php
                            $jumlah_pendapatan += $result->pendapatan->jumlah;
                        @endphp

                        <td>{{ number_format($result->purata->l, 2) }}
                        </td>
                        @php
                            $jumlah_purata_lelaki += $result->purata->l;
                        @endphp
                        <td>{{ number_format($result->purata->p, 2) }}
                        </td>
                        @php
                            $jumlah_purata_perempuan += $result->purata->p;
                        @endphp
                        <td>
                            {{ number_format($result->purata->jumlah, 2) }}</td>
                        @php
                            $jumlah_purata_keseluruhan += $result->purata->jumlah;
                        @endphp
                    </tr>
                @endforeach
            </tbody>
            <tfoot>
                <tr style="background-color: lightgray; font-weight: bold;">
                    <td></td>
                    <td>Jumlah</td>
                    <td>{{ number_format($jumlah_lelaki, 0) }}</td>
                    <td>{{ number_format($jumlah_perempuan, 0) }}</td>
                    <td>{{ number_format($jumlah_guna_tenaga, 0) }}</td>

                    <td> {{ number_format($jumlah_gaji_lelaki, 2) }}</td>
                    <td> {{ number_format($jumlah_gaji_perempuan, 2) }}</td>
                    <td> {{ number_format($jumlah_pendapatan, 2) }}</td>


                    <td>
                        {{ number_format($jumlah_gaji_lelaki / max($jumlah_lelaki, 1), 2) }}
                    </td>
                    <td>
                        {{ number_format($jumlah_gaji_perempuan / max($jumlah_perempuan, 1), 2) }}
                    </td>
                    <td>
                        {{ number_format($jumlah_pendapatan / max($jumlah_guna_tenaga, 1), 2) }}
                    </td>

                </tr>
            </tfoot>
        </table>
    @endforeach
