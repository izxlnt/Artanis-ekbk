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
@foreach ($jumlah as $key => $jumlahdata)
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
        <thead style="background-color: #f3ce8f; font-weight: bold;">
            {{-- <tr>
                <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
            </tr> --}}
            <tr>
                @foreach ($columns as $data)
                    @if ($data == 'Bumiputera' || $data == 'Bukan Bumiputera' || $data == 'Bukan Warganegara' || $data == 'Jumlah')
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

            @endphp

            @foreach ($jumlahdata as $kategori => $value)
                @if ($value)
                    <tr >
                        <td>{{ $loop->iteration }}</td>
                        <td >{{ $value[0]->kategori }}</td>

                        {{-- bumiputera --}}
                        <td style="text-align: right">
                            {{ number_format($value[0]->jumlah_bumiputera_lelaki) }}
                            @php
                                $jumlah_bumi_lelaki = $jumlah_bumi_lelaki + $value[0]->jumlah_bumiputera_lelaki;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ number_format($value[0]->jumlah_bumiputera_perempuan) }}
                            @php
                                $jumlah_bumi_perempuan = $jumlah_bumi_perempuan + $value[0]->jumlah_bumiputera_perempuan;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ number_format($value[0]->jumlah_bumiputera_lelaki + $value[0]->jumlah_bumiputera_perempuan) }}
                            @php
                                $jumlah_bumiputera = $jumlah_bumiputera + ($value[0]->jumlah_bumiputera_lelaki + $value[0]->jumlah_bumiputera_perempuan);
                            @endphp
                        </td>

                        {{-- bukan bumiputera --}}
                        <td style="text-align: right">
                            {{ number_format($value[0]->jumlah_bukan_bumiputera_lelaki) }}
                            @php
                                $jumlah_bukan_bumi_lelaki = $jumlah_bukan_bumi_lelaki + $value[0]->jumlah_bukan_bumiputera_lelaki;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ number_format($value[0]->jumlah_bukan_bumiputera_perempuan) }}
                            @php
                                $jumlah_bukan_bumi_perempuan = $jumlah_bukan_bumi_perempuan + $value[0]->jumlah_bukan_bumiputera_perempuan;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ number_format($value[0]->jumlah_bukan_bumiputera_lelaki + $value[0]->jumlah_bukan_bumiputera_perempuan) }}
                            @php
                                $jumlah_bukan_bumiputera = $jumlah_bukan_bumiputera + ($value[0]->jumlah_bukan_bumiputera_lelaki + $value[0]->jumlah_bukan_bumiputera_perempuan);
                            @endphp
                        </td>

                        {{-- bukan warganegara --}}
                        <td style="text-align: right">
                            {{ number_format($value[0]->jumlah_bukan_warganegara_lelaki) }}
                            @php
                                $jumlah_bukan_warga_lelaki = $jumlah_bukan_warga_lelaki + $value[0]->jumlah_bukan_warganegara_lelaki;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ number_format($value[0]->jumlah_bukan_warganegara_perempuan) }}
                            @php
                                $jumlah_bukan_warga_perempuan = $jumlah_bukan_warga_perempuan + $value[0]->jumlah_bukan_warganegara_perempuan;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            {{ number_format($value[0]->jumlah_bukan_warganegara_lelaki + $value[0]->jumlah_bukan_warganegara_perempuan) }}
                            @php
                                $jumlah_bukan_warganegara = $jumlah_bukan_warganegara + ($value[0]->jumlah_bukan_warganegara_lelaki + $value[0]->jumlah_bukan_warganegara_perempuan);
                            @endphp
                        </td>

                        {{-- JUMLAH KESELURUHAN --}}
                        <td style="text-align: right">
                            @php
                                $papar_jumlah_jumlah_lelaki = $value[0]->jumlah_bumiputera_lelaki + $value[0]->jumlah_bukan_bumiputera_lelaki + $value[0]->jumlah_bukan_warganegara_lelaki;
                            @endphp
                            {{ number_format($papar_jumlah_jumlah_lelaki) }}
                            @php
                                $jumlah_jumlah_lelaki = $jumlah_jumlah_lelaki + $papar_jumlah_jumlah_lelaki;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $papar_jumlah_jumlah_perempuan = $value[0]->jumlah_bumiputera_perempuan + $value[0]->jumlah_bukan_bumiputera_perempuan + $value[0]->jumlah_bukan_warganegara_perempuan;
                            @endphp
                            {{ number_format($papar_jumlah_jumlah_perempuan) }}
                            @php
                                $jumlah_jumlah_perempuan = $jumlah_jumlah_perempuan + $papar_jumlah_jumlah_perempuan;
                            @endphp
                        </td>
                        <td style="text-align: right">
                            @php
                                $papar_jumlah_jumlah_jumlah = $papar_jumlah_jumlah_lelaki + $papar_jumlah_jumlah_perempuan;
                            @endphp
                            {{ number_format($papar_jumlah_jumlah_jumlah) }}
                            @php
                                $jumlah_jumlah_jumlah = $jumlah_jumlah_jumlah + $papar_jumlah_jumlah_jumlah;
                            @endphp
                        </td>
                    </tr>
                @else
                    <tr >
                        <td >{{ $loop->iteration }}</td>
                        <td >{{ $kategori }}</td>

                        <td>0</td>
                        <td>0</td>
                        <td>0</td>

                        <td>0</td>
                        <td>0</td>
                        <td>0</td>

                        <td>0</td>
                        <td>0</td>
                        <td>0</td>

                        <td>0</td>
                        <td>0</td>
                        <td>0</td>
                    </tr>
                @endif
            @endforeach

            <tr  style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td >Jumlah</td>

                <td style="text-align: right">{{ number_format($jumlah_bumi_lelaki) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_bumi_perempuan) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_bumiputera) }}</td>

                <td style="text-align: right">{{ number_format($jumlah_bukan_bumi_lelaki) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_bukan_bumi_perempuan) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_bukan_bumiputera) }}</td>

                <td style="text-align: right">{{ number_format($jumlah_bukan_warga_lelaki) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_bukan_warga_perempuan) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_bukan_warganegara) }}</td>

                <td style="text-align: right">{{ number_format($jumlah_jumlah_lelaki) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_jumlah_perempuan) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_jumlah_jumlah) }}</td>

            </tr>
        </tbody>
    </table>
@endforeach
