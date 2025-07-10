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
    @foreach ($datas as $key => $jumlah)
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
                {{-- <tr>
                    <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
                </tr> --}}
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

                @foreach ($jumlah as $kategori => $value)
                    @if ($value)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kategori }}</td>

                            <td>
                                {{ $value[0]->jumlah_lelaki }}
                                @php
                                    $jumlah_lelaki = $jumlah_lelaki + $value[0]->jumlah_lelaki;
                                @endphp
                            </td>
                            <td>
                                {{ $value[0]->jumlah_perempuan }}
                                @php
                                    $jumlah_perempuan = $jumlah_perempuan + $value[0]->jumlah_perempuan;
                                @endphp
                            </td>
                            <td>
                                {{ $value[0]->jumlah_lelaki + $value[0]->jumlah_perempuan }}
                                @php
                                    $jumlah_guna_tenaga = $jumlah_guna_tenaga + ($value[0]->jumlah_lelaki + $value[0]->jumlah_perempuan);
                                @endphp
                            </td>

                            <td style="text-align: right">
                                {{ number_format($value[0]->jumlah_gaji_lelaki, 2) }}
                                @php
                                    $jumlah_gaji_lelaki = $jumlah_gaji_lelaki + $value[0]->jumlah_gaji_lelaki;
                                @endphp
                            </td>
                            <td style="text-align: right">
                                {{ number_format($value[0]->jumlah_gaji_perempuan, 2) }}
                                @php
                                    $jumlah_gaji_perempuan = $jumlah_gaji_perempuan + $value[0]->jumlah_gaji_perempuan;
                                @endphp
                            </td>
                            <td style="text-align: right">
                                {{ number_format($value[0]->jumlah_gaji_lelaki + $value[0]->jumlah_gaji_perempuan, 2) }}
                                @php
                                    $jumlah_pendapatan = $jumlah_pendapatan + ($value[0]->jumlah_gaji_lelaki + $value[0]->jumlah_gaji_perempuan);
                                @endphp
                            </td>



                            <td style="text-align: right">
                                @if ($value[0]->jumlah_lelaki != 0)
                                    {{ number_format($value[0]->jumlah_gaji_lelaki / $value[0]->jumlah_lelaki, 2) }}
                                    @php
                                        $jumlah_purata_lelaki = $jumlah_purata_lelaki + $value[0]->jumlah_gaji_lelaki / $value[0]->jumlah_lelaki;
                                    @endphp
                                @else
                                    0.00
                                @endif
                            </td>
                            <td style="text-align: right">
                                @if ($value[0]->jumlah_perempuan != 0)
                                    {{ number_format($value[0]->jumlah_gaji_perempuan / $value[0]->jumlah_perempuan, 2) }}
                                    @php
                                        $jumlah_purata_perempuan = $jumlah_purata_perempuan + $value[0]->jumlah_gaji_perempuan / $value[0]->jumlah_perempuan;
                                    @endphp
                                @else
                                    0.00
                                @endif
                            </td>
                            <td style="text-align: right">
                                @if ($value[0]->jumlah_lelaki == 0 && $value[0]->jumlah_perempuan == 0)
                                    0.00
                                @else
                                    @php
                                        if ($value[0]->jumlah_lelaki == 0) {
                                            $purata_lelaki = 0;
                                        } else {
                                            $purata_lelaki = $value[0]->jumlah_gaji_lelaki / $value[0]->jumlah_lelaki;
                                        }

                                        if ($value[0]->jumlah_perempuan == 0) {
                                            $purata_perempuan = 0;
                                        } else {
                                            $purata_perempuan = $value[0]->jumlah_gaji_perempuan / $value[0]->jumlah_perempuan;
                                        }

                                        $purata_keseluruhan = $purata_lelaki + $purata_perempuan;
                                    @endphp

{{ number_format(round($jumlah_purata_keseluruhan = $jumlah_pendapatan / max($jumlah_guna_tenaga, 1), 2)) }}


                                    @php
                                        $jumlah_purata_keseluruhan = $jumlah_purata_keseluruhan + $purata_keseluruhan;
                                    @endphp
                                @endif
                            </td>


                        </tr>
                    @else
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $kategori }}</td>

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
                @endforeach
                <tr style="background-color: lightgray; font-weight: bold;">
                    <td></td>
                    <td>Jumlah</td>
                    <td>{{ $jumlah_lelaki }}</td>
                    <td>{{ $jumlah_perempuan }}</td>
                    <td>{{ $jumlah_guna_tenaga }}</td>

                    <td style="text-align: right"> {{ number_format($jumlah_gaji_lelaki, 0) }}</td>
                    <td style="text-align: right"> {{ number_format($jumlah_gaji_perempuan, 0) }}</td>
                    <td style="text-align: right"> {{ number_format($jumlah_pendapatan, 0) }}</td>

                    <td style="text-align: right">{{ number_format($jumlah_purata_lelaki = ($jumlah_gaji_lelaki / max($jumlah_lelaki, 1)), 0) }}</td>
                    <td style="text-align: right">{{ number_format($jumlah_purata_perempuan = ($jumlah_gaji_perempuan / max($jumlah_perempuan, 1)), 0) }}</td>
                    <td style="text-align: right">{{ number_format($jumlah_purata_keseluruhan = ($jumlah_pendapatan / max($jumlah_guna_tenaga, 1)), 0)  }}</td>


                </tr>
            </tbody>
        </table>
    @endforeach
