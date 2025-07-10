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
    $negeri_list = $results['negeri_list'] ?? [];
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
                        Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                @endif


                <div class="card-body">
                    <div class="table-responsive" style="padding-top: 15px;">
                        @foreach ($datas as $key => $data_jumlah)
                            @if (!$loop->first)
                                <div class="page-break"></div>
                                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                                    <div class="text-center card-header" style="text-align: center; padding-bottom: 10px;">{{ $title }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                                        {{ $tahun }}</div>
                                @else
                                    <div class="text-center card-header" style="text-align: center; padding-bottom: 10px;">{{ $title }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                                @endif

                            @endif
                            @if ($key == 1)
                                <div class="text-center" style="font-weight: bold; text-align: center;">Suku
                                    Tahun Pertama</div>
                            @elseif($key == 2)
                                <div class="text-center" style="font-weight: bold; text-align: center;">Suku
                                    Tahun Kedua</div>
                            @elseif($key == 3)
                                <div class="text-center" style="font-weight: bold; text-align: center;">Suku
                                    Tahun Ketiga</div>
                            @else
                                <div class="text-center" style="font-weight: bold; text-align: center;">Suku
                                    Tahun Keempat</div>
                            @endif
                            <table id="example_{{ $key }}" class="text-center table-bordered"
                                style="width: 100%; padding-top: 10px;">
                                <thead>
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
                                <tbody style="text-align: right;">

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

                                    @foreach ($data_jumlah as $key2 => $data)
                                        @if ($data)
                                            <tr>
                                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                <td style="text-align: left;">{{ $data[0]->negeri }}</td>


                                                {{-- bumiputera --}}
                                                <td>
                                                    {{ number_format($data[0]->jumlah_bumiputera_lelaki) }}
                                                    @php
                                                        $jumlah_bumi_lelaki = $jumlah_bumi_lelaki + $data[0]->jumlah_bumiputera_lelaki;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ number_format($data[0]->jumlah_bumiputera_perempuan) }}
                                                    @php
                                                        $jumlah_bumi_perempuan = $jumlah_bumi_perempuan + $data[0]->jumlah_bumiputera_perempuan;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ number_format($data[0]->jumlah_bumiputera_lelaki + $data[0]->jumlah_bumiputera_perempuan) }}
                                                    @php
                                                        $jumlah_bumiputera = $jumlah_bumiputera + ($data[0]->jumlah_bumiputera_lelaki + $data[0]->jumlah_bumiputera_perempuan);
                                                    @endphp
                                                </td>


                                                {{-- bukan bumiputera --}}
                                                <td>
                                                    {{ number_format($data[0]->jumlah_bukan_bumiputera_lelaki) }}
                                                    @php
                                                        $jumlah_bukan_bumi_lelaki = $jumlah_bukan_bumi_lelaki + $data[0]->jumlah_bukan_bumiputera_lelaki;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ number_format($data[0]->jumlah_bukan_bumiputera_perempuan) }}
                                                    @php
                                                        $jumlah_bukan_bumi_perempuan = $jumlah_bukan_bumi_perempuan + $data[0]->jumlah_bukan_bumiputera_perempuan;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ number_format($data[0]->jumlah_bukan_bumiputera_lelaki + $data[0]->jumlah_bukan_bumiputera_perempuan) }}
                                                    @php
                                                        $jumlah_bukan_bumiputera = $jumlah_bukan_bumiputera + ($data[0]->jumlah_bukan_bumiputera_lelaki + $data[0]->jumlah_bukan_bumiputera_perempuan);
                                                    @endphp
                                                </td>

                                                {{-- bukan warganegara --}}
                                                <td>
                                                    {{ number_format($data[0]->jumlah_bukan_warganegara_lelaki) }}
                                                    @php
                                                        $jumlah_bukan_warga_lelaki = $jumlah_bukan_warga_lelaki + $data[0]->jumlah_bukan_warganegara_lelaki;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ number_format($data[0]->jumlah_bukan_warganegara_perempuan) }}
                                                    @php
                                                        $jumlah_bukan_warga_perempuan = $jumlah_bukan_warga_perempuan + $data[0]->jumlah_bukan_warganegara_perempuan;
                                                    @endphp
                                                </td>
                                                <td>
                                                    {{ number_format($data[0]->jumlah_bukan_warganegara_lelaki + $data[0]->jumlah_bukan_warganegara_perempuan) }}
                                                    @php
                                                        $jumlah_bukan_warganegara = $jumlah_bukan_warganegara + ($data[0]->jumlah_bukan_warganegara_lelaki + $data[0]->jumlah_bukan_warganegara_perempuan);
                                                    @endphp
                                                </td>

                                                {{-- Jumlah --}}
                                                <td>
                                                    @php
                                                        $papar_jumlah_jumlah_lelaki = $data[0]->jumlah_bumiputera_lelaki + $data[0]->jumlah_bukan_bumiputera_lelaki + $data[0]->jumlah_bukan_warganegara_lelaki;
                                                    @endphp
                                                    {{ number_format($papar_jumlah_jumlah_lelaki) }}
                                                    @php
                                                        $jumlah_jumlah_lelaki = $jumlah_jumlah_lelaki + $papar_jumlah_jumlah_lelaki;
                                                    @endphp
                                                </td>
                                                <td>
                                                    @php
                                                        $papar_jumlah_jumlah_perempuan = $data[0]->jumlah_bumiputera_perempuan + $data[0]->jumlah_bukan_bumiputera_perempuan + $data[0]->jumlah_bukan_warganegara_perempuan;
                                                    @endphp
                                                    {{ number_format($papar_jumlah_jumlah_perempuan) }}
                                                    @php
                                                        $jumlah_jumlah_perempuan = $jumlah_jumlah_perempuan + $papar_jumlah_jumlah_perempuan;
                                                    @endphp
                                                </td>
                                                <td>
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
                                            <tr>
                                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                <td style="text-align: left;">{{ $key2 }}</td>

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
                                    <tr style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td style="text-align: left;">Jumlah</td>

                                        <td>{{ number_format($jumlah_bumi_lelaki) }}</td>
                                        <td>{{ number_format($jumlah_bumi_perempuan) }}</td>
                                        <td>{{ number_format($jumlah_bumiputera) }}</td>

                                        <td>{{ number_format($jumlah_bukan_bumi_lelaki) }}</td>
                                        <td>{{ number_format($jumlah_bukan_bumi_perempuan) }}</td>
                                        <td>{{ number_format($jumlah_bukan_bumiputera) }}</td>

                                        <td>{{ number_format($jumlah_bukan_warga_lelaki) }}</td>
                                        <td>{{ number_format($jumlah_bukan_warga_perempuan) }}</td>
                                        <td>{{ number_format($jumlah_bukan_warganegara) }}</td>

                                        <td>{{ number_format($jumlah_jumlah_lelaki) }}</td>
                                        <td>{{ number_format($jumlah_jumlah_perempuan) }}</td>
                                        <td>{{ number_format($jumlah_jumlah_jumlah) }}</td>

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
