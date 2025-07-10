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
    @foreach ($datas as $key => $data_jumlah)
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
        <table>
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

            <thead style="background-color: #f3ce8f; font-weight: bold;">
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
                    {{-- <th colspan="2"></th> --}}
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

                @forelse ($data_jumlah as $negeri => $data)
                    @if ($data)
                        <tr class="text-right">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $negeri }}</td>
                            @php
                                $data_total_pekerja_lelaki = 0;
                                $data_total_pekerja_perempuan = 0;
                                $data_jumlah_guna_tenaga = 0;

                                $data_jumlah_gaji_lelaki = 0;
                                $data_jumlah_gaji_perempuan = 0;
                                $data_jumlah_pendapatan = 0;

                                $data_total_pekerja_lelaki = 0;
                                $data_total_pekerja_perempuan = 0;
                            @endphp
                            @foreach ($data as $value)
                                @php
                                    $data_total_pekerja_lelaki += $value->total_pekerja_lelaki;

                                    $data_total_pekerja_perempuan += $value->total_pekerja_perempuan;

                                    $data_jumlah_guna_tenaga += $value->total_pekerja_lelaki + $value->total_pekerja_perempuan;

                                    $data_jumlah_gaji_lelaki += $value->jumlah_gaji_lelaki;

                                    $data_jumlah_gaji_perempuan += $value->jumlah_gaji_perempuan;

                                    $data_jumlah_pendapatan = $data_jumlah_gaji_lelaki + $data_jumlah_gaji_perempuan;

                                    $purata_lelaki = $data_jumlah_gaji_lelaki / $data_total_pekerja_lelaki;
                                    $purata_perempuan = $data_jumlah_gaji_perempuan / $data_total_pekerja_perempuan;
                                    $purata_keseluruhan = $data_jumlah_pendapatan / $data_jumlah_guna_tenaga;

                                    $jumlah_lelaki += $value->total_pekerja_lelaki;
                                    $jumlah_perempuan += $value->total_pekerja_perempuan;
                                    $jumlah_guna_tenaga = $data_jumlah_guna_tenaga;

                                    $jumlah_gaji_lelaki += $value->jumlah_gaji_lelaki;
                                    $jumlah_gaji_perempuan += $value->jumlah_gaji_perempuan;
                                    $jumlah_pendapatan = $data_jumlah_pendapatan;

                                    $jumlah_purata_lelaki += $purata_lelaki;
                                    $jumlah_purata_perempuan += $purata_perempuan;
                                    $jumlah_purata_keseluruhan = $purata_keseluruhan;
                                @endphp
                            @endforeach

                            <td style="text-align: right">
                                {{ number_format($data_total_pekerja_lelaki, 0) }}
                            </td>
                            <td style="text-align: right">
                                {{ number_format($data_total_pekerja_perempuan, 0) }}
                            </td>
                            <td style="text-align: right">
                                {{ number_format($data_jumlah_guna_tenaga, 0) }}
                            </td>
                            <td style="text-align: right">
                                {{ number_format(round($data_jumlah_gaji_lelaki, 2)) }}
                            </td>
                            <td style="text-align: right">
                                {{ number_format(round($data_jumlah_gaji_perempuan, 2)) }}
                            </td>
                            <td style="text-align: right">
                                {{ number_format(round($data_jumlah_pendapatan, 2)) }}
                            </td>

                            <td style="text-align: right">
                                {{ number_format(round($purata_lelaki, 2)) }}
                            </td>
                            <td class="text-right">
                                {{ number_format(round($purata_perempuan, 2)) }}
                            </td>
                            <td class="text-right">
                                {{ number_format(round($purata_keseluruhan, 2)) }}
                            </td>


                        </tr>
                    @else
                        <tr class="text-right">
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left">{{ $negeri }}</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                            <td>0.00</td>
                        </tr>
                    @endif
                @empty
                    <tr class="text-right">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $negeri }}</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                        <td>0.00</td>
                    </tr>
                @endforelse


            </tbody>
            <tr style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td>Jumlah</td>
                <td style="text-align: right">{{ number_format($jumlah_lelaki, 0) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_perempuan, 0) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_guna_tenaga, 0) }}</td>

                <td style="text-align: right">{{ number_format(round($jumlah_gaji_lelaki, 2)) }}</td>
                <td style="text-align: right">{{ number_format(round($jumlah_gaji_perempuan, 2)) }}</td>
                <td style="text-align: right">{{ number_format(round($jumlah_pendapatan, 2)) }}</td>

                <td style="text-align: right">{{ number_format(round($jumlah_purata_lelaki = ($jumlah_gaji_lelaki / max($jumlah_lelaki, 1)), 2)) }}</td>
                <td style="text-align: right">{{ number_format(round($jumlah_purata_perempuan = ($jumlah_gaji_perempuan / max($jumlah_perempuan, 1)), 2)) }}</td>
                <td style="text-align: right">{{ number_format(round($jumlah_purata_keseluruhan = ($jumlah_pendapatan / max($jumlah_guna_tenaga, 1)), 2))  }}</td>


            </tr>
        </table>
    @endforeach
