<style>
    table {
      border-collapse: collapse;
      font-size: 14px;
    }

    td, th {
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
$columns = $results['columns'] ?? [];
$negeri_list = $results['negeri_list'] ?? [];
$datas = $results['datas'] ?? [];
$nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
$nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
$tahun = $results['tahun'] ?? [];
$suku_tahun = $results['suku_tahun'] ?? [];
$suku_tahun_akhir = $results['suku_tahun_akhir'] ?? [];
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">


            <div class="card">
                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                    <div class="text-center card-header" style="text-align:center;">{{ $title }} : Suku
                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                        {{ $tahun }}</div>
                @else
                    <div class="text-center card-header" style="text-align:center;">{{ $title }} : Suku
                        Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                @endif
                <div class="card-body">
                    <div class="table-responsive" style="padding-top: 15px;">
                        @foreach ($datas as $key => $data_jumlah)
                            @if (!$loop->first)
                                <div class="page-break"></div>
                                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                                    <div class="text-center card-header" style="text-align:center;">{{ $title }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                                        {{ $tahun }}</div>
                                @else
                                    <div class="text-center card-header" style="text-align:center;">{{ $title }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                                @endif
                            @endif
                            @if ($key == 1)
                                <div class="text-center" style="font-weight: bold; text-align:center; padding-top: 15px;">Suku
                                    Tahun Pertama</div>
                            @elseif($key == 2)
                                <div class="text-center" style="font-weight: bold; text-align:center; padding-top: 15px;">Suku
                                    Tahun Kedua</div>
                            @elseif($key == 3)
                                <div class="text-center" style="font-weight: bold; text-align:center; padding-top: 15px;">Suku
                                    Tahun Ketiga</div>
                            @else
                                <div class="text-center" style="font-weight: bold; text-align:center; padding-top: 15px;">Suku
                                    Tahun Keempat</div>
                            @endif
                            <table id="example_{{ $key }}" class="text-center table-bordered"
                                style="width: 100%; padding-top: 10px;" style="padding-top: 15px;">
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

                                <thead style="text-align: center;">
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

                                <tbody style="text-align: center">

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
                                            @foreach($data as $value)
                                                @php
                                                    $data_total_pekerja_lelaki += $value->total_pekerja_lelaki;

                                                    $data_total_pekerja_perempuan += $value->total_pekerja_perempuan;

                                                    $data_jumlah_guna_tenaga += $value->total_pekerja_lelaki + $value->total_pekerja_perempuan;

                                                    $data_jumlah_gaji_lelaki += $value->jumlah_gaji_lelaki;

                                                    $data_jumlah_gaji_perempuan += $value->jumlah_gaji_perempuan;

                                                    $data_jumlah_pendapatan = $data_jumlah_gaji_lelaki + $data_jumlah_gaji_perempuan;

                                                    $purata_lelaki = $data_jumlah_gaji_lelaki / $data_total_pekerja_lelaki;
                                                    $purata_perempuan = $data_jumlah_gaji_perempuan / $data_total_pekerja_perempuan;
                                                    $purata_keseluruhan = $data_jumlah_pendapatan / $data_jumlah_guna_tenaga ;

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

                                            <td>
                                                {{ number_format($data_total_pekerja_lelaki,0) }}
                                            </td>
                                            <td>
                                                {{ number_format($data_total_pekerja_perempuan,0) }}
                                            </td>
                                            <td>
                                                {{ number_format($data_jumlah_guna_tenaga,0) }}
                                            </td>
                                            <td>
                                                {{ number_format(round($data_jumlah_gaji_lelaki, 2)) }}
                                            </td>
                                            <td>
                                                {{ number_format(round($data_jumlah_gaji_perempuan, 2)) }}
                                            </td>
                                            <td>
                                                {{ number_format(round($data_jumlah_pendapatan, 2)) }}
                                            </td>

                                            <td>
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
                                <tr style="background-color: lightgray; font-weight: bold; text-align: right;">
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: left;">Jumlah</td>
                                    <td>{{ number_format($jumlah_lelaki,0) }}</td>
                                    <td>{{ number_format($jumlah_perempuan,0) }}</td>
                                    <td>{{ number_format($jumlah_guna_tenaga,0) }}</td>

                                    <td>{{ number_format(round($jumlah_gaji_lelaki, 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_gaji_perempuan, 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_pendapatan, 2)) }}</td>

                                        <td>{{ number_format(round($jumlah_purata_lelaki = ($jumlah_gaji_lelaki / max($jumlah_lelaki, 1)), 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_purata_perempuan = ($jumlah_gaji_perempuan / max($jumlah_perempuan, 1)), 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_purata_keseluruhan = ($jumlah_pendapatan / max($jumlah_guna_tenaga, 1)), 2))  }}</td>

                                </tr>
                            </table>
                        @endforeach



                    </div>
                </div>
            </div>

        </div>
    </div>
</div>
