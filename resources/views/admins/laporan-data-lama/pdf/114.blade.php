<style>
    table {
    border-collapse: collapse;
    font-size: 13px;
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

<div class="container-fluid">

    <div class="row">

        <div class="col-12">

            <div class="card">
                {{-- <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title }}</div> --}}

                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                    <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} : Suku
                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                        {{ $tahun }}</div>
                @else
                    <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} :
                        Suku
                        Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                @endif

                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px;">
                        @foreach ($results as $key => $suku)
                            @if (!$loop->first)
                                <div class="page-break"></div>
                                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                                    <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                                        {{ $tahun }}</div>
                                @else
                                    <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} :
                                        Suku
                                        Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                                @endif

                            @endif
                            <div class="table-responsive" style="padding-top: 15px;">
                                @if ($key == 1)
                                    <div style="font-weight: bold; text-align: center;">Suku
                                        Tahun Pertama</div>
                                @elseif($key == 2)
                                    <div style="font-weight: bold; text-align: center;">Suku
                                        Tahun Kedua</div>
                                @elseif($key == 3)
                                    <div style="font-weight: bold; text-align: center;">Suku
                                        Tahun Ketiga</div>
                                @else
                                    <div style="font-weight: bold; text-align: center;">Suku
                                        Tahun Keempat</div>
                                @endif
                                <table id="example_{{ $key }}" class="table-bordered" style="width: 100%; padding-top: 10px;">
                                    <thead style="background-color: #f3ce8f;">
                                        <tr>
                                            @foreach ($columns as $data)
                                                @if ($data == 'Bumiputera')
                                                    <th style="text-align: center;" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Bukan Bumiputera')
                                                    <th style="text-align: center;" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Bukan Warganegara')
                                                    <th style="text-align: center;" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Bukan Warganegara')
                                                    <th style="text-align: center;" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Jumlah')
                                                    <th style="text-align: center;" colspan="3">{{ $data }}</th>
                                                @else
                                                    <th style="text-align: center;" rowspan="2">{{ $data }}</th>
                                                @endif
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th style="text-align: center;">L</th>
                                            <th style="text-align: center;">P</th>
                                            <th style="text-align: center;">Jumlah (L+P)</th>

                                            <th style="text-align: center;">L</th>
                                            <th style="text-align: center;">P</th>
                                            <th style="text-align: center;">Jumlah (L+P)</th>

                                            <th style="text-align: center;">L</th>
                                            <th style="text-align: center;">P</th>
                                            <th style="text-align: center;">Jumlah (L+P)</th>

                                            <th style="text-align: center;">L</th>
                                            <th style="text-align: center;">P</th>
                                            <th style="text-align: center;">Jumlah (L+P)</th>
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

                                        @foreach ($suku as $result)
                                            <tr style="text-align: right;">
                                                <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                <td style="text-align: left;">{{ $result->negeri_keterangan }}</td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->wargabumi->l, 0) }}</td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->wargabumi->p, 0) }}</td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->wargabumi->jumlah, 0) }}
                                                </td>

                                                <td style="text-align: right;">
                                                    {{ number_format($result->wargabukanbumi->l, 0) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->wargabukanbumi->p, 0) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->wargabukanbumi->jumlah, 0) }}</td>

                                                <td style="text-align: right;">
                                                    {{ number_format($result->bukanwarga->l, 0) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->bukanwarga->p, 0) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->bukanwarga->jumlah, 0) }}</td>

                                                <td style="text-align: right;">
                                                    {{ number_format($result->keseluruhan->l, 0) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->keseluruhan->p, 0) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->keseluruhan->jumlah, 0) }}</td>

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

                                                @endphp
                                            </tr>
                                        @endforeach

                                        <tr style="background-color: lightgray; font-weight: bold; text-align: right;">
                                            <td style="text-align: center;"></td>
                                            <td style="text-align: left;">Jumlah</td>

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

                                        </tr>
                                    </tbody>


                                </table>



                            </div>
                        @endforeach
                    </div>
                </div>


            </div>
        </div>
    </div>
</div>
