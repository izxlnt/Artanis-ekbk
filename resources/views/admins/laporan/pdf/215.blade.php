<style>
    table {
        border-collapse: collapse;
        font-size: 14px;
    }

    td,
    th {
        border: 1px solid black;
        padding: 5px;
    }

    th {
        background-color: lightgrey;
    }

    .page-break {
        page-break-after: always;
    }
</style>

@php
$nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
$nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
$title = $results['title_laporan'] ?? [];
$columns = $results['columns'] ?? [];
$kategori = $results['kategori'] ?? [];
$tahun = $results['tahun'] ?? [];
$jumlah = $results['jumlah'] ?? [];
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">



            <div class="card">
                {{-- <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title }} : Suku Tahun {{ $nama_suku_tahun }} ({{ $tahun }})</div> --}}

                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                    <div class="text-center card-header" style="text-align: center;">{{ $title }} : Suku
                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                        {{ $tahun }}</div>
                @else
                    <div class="text-center card-header" style="text-align: center;">{{ $title }} : Suku
                        Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                @endif

                <div class="card-body">
                    <div class="table-responsive" style="padding-top: 15px;">
                        @foreach ($jumlah as $key => $data_jumlah)
                            @if (!$loop->first)
                                <div class="page-break"></div>
                                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                                    <div class="text-center card-header"
                                        style="text-align: center; padding-bottom: 15px;">{{ $title }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi
                                        Tahun
                                        {{ $tahun }}</div>
                                @else
                                    <div class="text-center card-header"
                                        style="text-align: center; padding-bottom: 15px;">{{ $title }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                                @endif
                            @endif

                            @if ($key == 1)
                                <div class="text-center" style="font-weight: bold; text-align:center;">Suku
                                    Tahun Pertama</div>
                            @elseif($key == 2)
                                <div class="text-center" style="font-weight: bold; text-align:center;">Suku
                                    Tahun Kedua</div>
                            @elseif($key == 3)
                                <div class="text-center" style="font-weight: bold; text-align:center;">Suku
                                    Tahun Ketiga</div>
                            @else
                                <div class="text-center" style="font-weight: bold; text-align:center;">Suku
                                    Tahun Keempat</div>
                            @endif
                            <table id="example_{{ $key }}" class="text-center table-bordered"
                                style="width: 100%; padding-top: 10px;">

                                <thead>
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Bumiputera' ||
                                                $data == 'Bukan Bumiputera' ||
                                                $data == 'Bukan Warganegara' ||
                                                $data == 'Jumlah Guna Tenaga' ||
                                                $data == 'Pendapatan (RM)' ||
                                                $data == 'Purata Pendapatan (RM)')
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
                                <tbody style="text-align: center">
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
                                    @if ($data_jumlah[$key] != null)
                                        @foreach ($data_jumlah as $key => $value)
                                            <tr class="text-right">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $value[0]->kategori }}</td>

                                                {{-- bumiputera --}}
                                                <td>
                                                    {{ $value[0]->jumlah_bumiputera_lelaki }}
                                                    @php
                                                        $jumlah_bumi_lelaki = $jumlah_bumi_lelaki + $value[0]->jumlah_bumiputera_lelaki;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $value[0]->jumlah_bumiputera_perempuan }}
                                                    @php
                                                        $jumlah_bumi_perempuan = $jumlah_bumi_perempuan + $value[0]->jumlah_bumiputera_perempuan;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $value[0]->jumlah_bumiputera_lelaki + $value[0]->jumlah_bumiputera_perempuan }}
                                                    @php
                                                        $jumlah_bumiputera = $jumlah_bumiputera + ($value[0]->jumlah_bumiputera_lelaki + $value[0]->jumlah_bumiputera_perempuan);
                                                    @endphp
                                                </td>

                                                {{-- bukan bumiputera --}}
                                                <td>
                                                    {{ $value[0]->jumlah_bukan_bumiputera_lelaki }}
                                                    @php
                                                        $jumlah_bukan_bumi_lelaki = $jumlah_bukan_bumi_lelaki + $value[0]->jumlah_bukan_bumiputera_lelaki;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $value[0]->jumlah_bukan_bumiputera_perempuan }}
                                                    @php
                                                        $jumlah_bukan_bumi_perempuan = $jumlah_bukan_bumi_perempuan + $value[0]->jumlah_bukan_bumiputera_perempuan;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $value[0]->jumlah_bukan_bumiputera_lelaki + $value[0]->jumlah_bukan_bumiputera_perempuan }}
                                                    @php
                                                        $jumlah_bukan_bumiputera = $jumlah_bukan_bumiputera + ($value[0]->jumlah_bukan_bumiputera_lelaki + $value[0]->jumlah_bukan_bumiputera_perempuan);
                                                    @endphp
                                                </td>

                                                {{-- bukan warganegara --}}
                                                <td>
                                                    {{ $value[0]->jumlah_bukan_warganegara_lelaki }}
                                                    @php
                                                        $jumlah_bukan_warga_lelaki = $jumlah_bukan_warga_lelaki + $value[0]->jumlah_bukan_warganegara_lelaki;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $value[0]->jumlah_bukan_warganegara_perempuan }}
                                                    @php
                                                        $jumlah_bukan_warga_perempuan = $jumlah_bukan_warga_perempuan + $value[0]->jumlah_bukan_warganegara_perempuan;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ $value[0]->jumlah_bukan_warganegara_lelaki + $value[0]->jumlah_bukan_warganegara_perempuan }}
                                                    @php
                                                        $jumlah_bukan_warganegara = $jumlah_bukan_warganegara + ($value[0]->jumlah_bukan_warganegara_lelaki + $value[0]->jumlah_bukan_warganegara_perempuan);
                                                    @endphp
                                                </td>




                                                {{-- JUMLAH KESELURUHAN GUNA TENAGA --}}
                                                <td>
                                                    @php
                                                        $papar_jumlah_jumlah_lelaki = $value[0]->jumlah_bumiputera_lelaki + $value[0]->jumlah_bukan_bumiputera_lelaki + $value[0]->jumlah_bukan_warganegara_lelaki;
                                                    @endphp
                                                    {{ $papar_jumlah_jumlah_lelaki }}
                                                    @php
                                                        $jumlah_jumlah_lelaki = $jumlah_jumlah_lelaki + $papar_jumlah_jumlah_lelaki;
                                                    @endphp
                                                </td>
                                                <td>
                                                    @php
                                                        $papar_jumlah_jumlah_perempuan = $value[0]->jumlah_bumiputera_perempuan + $value[0]->jumlah_bukan_bumiputera_perempuan + $value[0]->jumlah_bukan_warganegara_perempuan;
                                                    @endphp
                                                    {{ $papar_jumlah_jumlah_perempuan }}
                                                    @php
                                                        $jumlah_jumlah_perempuan = $jumlah_jumlah_perempuan + $papar_jumlah_jumlah_perempuan;
                                                    @endphp
                                                </td>
                                                <td>
                                                    @php
                                                        $papar_jumlah_jumlah_jumlah = $papar_jumlah_jumlah_lelaki + $papar_jumlah_jumlah_perempuan;
                                                    @endphp
                                                    {{ $papar_jumlah_jumlah_jumlah }}
                                                    @php
                                                        $jumlah_jumlah_jumlah = $jumlah_jumlah_jumlah + $papar_jumlah_jumlah_jumlah;
                                                    @endphp
                                                </td>

                                                {{-- JUMLAH PENDAPATAN --}}
                                                <td>
                                                    {{ number_format(round($value[0]->jumlah_gaji_lelaki, 2)) }}
                                                    @php
                                                        $jumlah_gaji_lelaki = $jumlah_gaji_lelaki + $value[0]->jumlah_gaji_lelaki;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ number_format(round($value[0]->jumlah_gaji_perempuan, 2)) }}
                                                    @php
                                                        $jumlah_gaji_perempuan = $jumlah_gaji_perempuan + $value[0]->jumlah_gaji_perempuan;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ number_format(round($value[0]->jumlah_gaji_lelaki + $value[0]->jumlah_gaji_perempuan, 2)) }}
                                                    @php
                                                        $jumlah_pendapatan = $jumlah_pendapatan + ($value[0]->jumlah_gaji_lelaki + $value[0]->jumlah_gaji_perempuan);
                                                    @endphp
                                                </td>







                                                <td>
                                                    @if ($papar_jumlah_jumlah_lelaki != 0)
                                                        {{ number_format(round($value[0]->jumlah_gaji_lelaki / $papar_jumlah_jumlah_lelaki, 2)) }}
                                                        @php
                                                            $jumlah_purata_lelaki = $jumlah_purata_lelaki + $value[0]->jumlah_gaji_lelaki / $papar_jumlah_jumlah_lelaki;
                                                        @endphp
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($papar_jumlah_jumlah_perempuan != 0)
                                                        {{ number_format(round($value[0]->jumlah_gaji_perempuan / $papar_jumlah_jumlah_perempuan, 2)) }}
                                                        @php
                                                            $jumlah_purata_perempuan = $jumlah_purata_perempuan + $value[0]->jumlah_gaji_perempuan / $papar_jumlah_jumlah_perempuan;
                                                        @endphp
                                                    @else
                                                        0
                                                    @endif
                                                </td>
                                                <td>
                                                    @if ($papar_jumlah_jumlah_lelaki == 0 && $papar_jumlah_jumlah_perempuan == 0)
                                                        0
                                                    @else
                                                        @php
                                                            if ($papar_jumlah_jumlah_lelaki == 0) {
                                                                $purata_lelaki = 0;
                                                            } else {
                                                                $purata_lelaki = $value[0]->jumlah_gaji_lelaki / $papar_jumlah_jumlah_lelaki;
                                                            }

                                                            if ($papar_jumlah_jumlah_perempuan == 0) {
                                                                $purata_perempuan = 0;
                                                            } else {
                                                                $purata_perempuan = $value[0]->jumlah_gaji_perempuan / $papar_jumlah_jumlah_perempuan;
                                                            }

                                                            $purata_keseluruhan = $purata_lelaki + $purata_perempuan;
                                                        @endphp

                                                        {{ number_format(round($jumlah_purata_keseluruhan = $jumlah_pendapatan / max($jumlah_jumlah_jumlah, 1), 2)) }}


                                                        @php
                                                            $jumlah_purata_keseluruhan = $jumlah_purata_keseluruhan + $purata_keseluruhan;
                                                        @endphp
                                                    @endif
                                                </td>
                                            </tr>
                                        @endforeach
                                    @else
                                        @foreach ($kategori as $key => $data)
                                            <tr style="text-align: right;">

                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td style="text-align: left;">{{ $data->keterangan }}</td>

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

                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>0.00</td>

                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>0.00</td>

                                            </tr>
                                        @endforeach
                                    @endif

                                    <tr style="background-color: lightgray; font-weight: bold; text-align: right;">
                                        <td></td>
                                        <td style="text-align: left;">Jumlah</td>

                                        <td>{{ $jumlah_bumi_lelaki }}</td>
                                        <td>{{ $jumlah_bumi_perempuan }}</td>
                                        <td>{{ $jumlah_bumiputera }}</td>

                                        <td>{{ $jumlah_bukan_bumi_lelaki }}</td>
                                        <td>{{ $jumlah_bukan_bumi_perempuan }}</td>
                                        <td>{{ $jumlah_bukan_bumiputera }}</td>

                                        <td>{{ $jumlah_bukan_warga_lelaki }}</td>
                                        <td>{{ $jumlah_bukan_warga_perempuan }}</td>
                                        <td>{{ $jumlah_bukan_warganegara }}</td>

                                        <td>{{ $jumlah_jumlah_lelaki }}</td>
                                        <td>{{ $jumlah_jumlah_perempuan }}</td>
                                        <td>{{ $jumlah_jumlah_jumlah }}</td>

                                        <td>{{ number_format(round($jumlah_gaji_lelaki, 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_gaji_perempuan, 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_pendapatan, 2)) }}</td>

                                        <td>{{ number_format(round($jumlah_purata_lelaki = $jumlah_gaji_lelaki / max($jumlah_jumlah_lelaki, 1), 2)) }}
                                        </td>
                                        <td>{{ number_format(round($jumlah_purata_perempuan = $jumlah_gaji_perempuan / max($jumlah_jumlah_perempuan, 1), 2)) }}
                                        </td>
                                        <td>{{ number_format(round($jumlah_purata_keseluruhan = $jumlah_pendapatan / max($jumlah_jumlah_jumlah, 1), 2)) }}
                                        </td>

                                    </tr>
                                </tbody>
                            </table>
                        @endforeach

                    </div>
                </div>
            </div>



        </div>
    </div>




</div>
