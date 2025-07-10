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
    $nama_suku_tahun = $results['nama_suku_tahun'] ?? [];
    $nama_suku_tahun_akhir = $results['nama_suku_tahun_akhir'] ?? [];
    $title = $results['title_laporan'] ?? [];
    $columns = $results['columns'] ?? [];
    $kategori = $results['kategori'] ?? [];
    $tahun = $results['tahun'] ?? [];
    $datas = $results['datas'] ?? [];
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
                        Tahun {{ $nama_suku_tahun }} Bagi Tahun {{ $tahun }}</div>
                @endif

                <div class="card-body">
                    <div class="table-responsive" style="padding-top: 15px;">
                        @foreach ($datas as $key => $jumlah)
                            @if (!$loop->first)
                                <div class="page-break"></div>
                                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                                    <div class="text-center card-header" style="text-align: center;">{{ $title }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                                        {{ $tahun }}</div>
                                @else
                                    <div class="text-center card-header" style="text-align: center;">{{ $title }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Bagi Tahun {{ $tahun }}</div>
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
                                style="width: 100%; padding-top: 10px;">
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
                                <thead>
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
                                @if ($value[0]->jumlah_lelaki != 0)
                                    {{ number_format(round($value[0]->jumlah_gaji_lelaki / $value[0]->jumlah_lelaki, 2)) }}
                                    @php
                                        $jumlah_purata_lelaki = $jumlah_purata_lelaki + $value[0]->jumlah_gaji_lelaki / $value[0]->jumlah_lelaki;
                                    @endphp
                                @else
                                    0.00
                                @endif
                            </td>
                            <td>
                                @if ($value[0]->jumlah_perempuan != 0)
                                    {{ number_format(round($value[0]->jumlah_gaji_perempuan / $value[0]->jumlah_perempuan, 2)) }}
                                    @php
                                        $jumlah_purata_perempuan = $jumlah_purata_perempuan + $value[0]->jumlah_gaji_perempuan / $value[0]->jumlah_perempuan;
                                    @endphp
                                @else
                                    0.00
                                @endif
                            </td>
                            <td>
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

                                    {{ number_format(round($purata_keseluruhan = $jumlah_pendapatan / max($jumlah_guna_tenaga, 1), 2)) }}


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
                                    <tr style="background-color: lightgray; font-weight: bold; text-align: right;">
                                        <td class="text-center"></td>
                                        <td style="text-align: left;">Jumlah</td>
                                        <td>{{ $jumlah_lelaki }}</td>
                                        <td>{{ $jumlah_perempuan }}</td>
                                        <td>{{ $jumlah_guna_tenaga }}</td>

                                        <td>{{ number_format(round($jumlah_gaji_lelaki, 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_gaji_perempuan, 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_pendapatan, 2)) }}</td>

                                        <td>{{ number_format(round($jumlah_purata_lelaki = $jumlah_gaji_lelaki / max($jumlah_lelaki, 1), 2)) }}
                                        </td>
                                        <td>{{ number_format(round($jumlah_purata_perempuan = $jumlah_gaji_perempuan / max($jumlah_perempuan, 1), 2)) }}
                                        </td>
                                        <td>{{ number_format(round($jumlah_purata_keseluruhan = $jumlah_pendapatan / max($jumlah_guna_tenaga, 1), 2)) }}
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
