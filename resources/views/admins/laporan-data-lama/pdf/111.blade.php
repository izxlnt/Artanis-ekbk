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
<div class="container-fluid">

    <div class="row">

        <div class="col-12">


            <div class="card">
                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                    <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} : Suku
                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                        {{ $tahun }}</div>
                @else
                    <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} : Suku
                        Tahun {{ $nama_suku_tahun }} Bagi Tahun {{ $tahun }}</div>
                @endif
                <div class="card-body">
                    @foreach ($results as $key => $suku)
                        @if (!$loop->first)
                            <div class="page-break"></div>
                            @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                                <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} :
                                    Suku
                                    Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi
                                    Tahun
                                    {{ $tahun }}</div>
                            @else
                                <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }}
                                    : Suku
                                    Tahun {{ $nama_suku_tahun }} Bagi Tahun {{ $tahun }}</div>
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
                            <table id="example_{{ $key }}" class="table-bordered"
                                style="width: 100%; padding-top: 10px;">
                                <thead style="background-color: #f3ce8f; font-weight: bold;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Guna Tenaga')
                                                <th style="text-align: center;" colspan="3">{{ $data }}</th>
                                            @elseif($data == 'Pendapatan (RM)')
                                                <th style="text-align: center;" colspan="3">{{ $data }}</th>
                                            @elseif($data == 'Purata (RM)')
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
                                        <tr style="text-align: center;">
                                            <td> {{ $loop->iteration }}</td>
                                            <td style="text-align: left;">{{ $result->negeri_keterangan }}</td>
                                            <td style="text-align: right;">
                                                {{ number_format($result->gunatenaga->l, 0) }}
                                            </td>
                                            @php
                                                $jumlah_lelaki += $result->gunatenaga->l;
                                            @endphp
                                            <td style="text-align: right;">
                                                {{ number_format($result->gunatenaga->p, 0) }}
                                            </td>
                                            @php
                                                $jumlah_perempuan += $result->gunatenaga->p;
                                            @endphp
                                            <td style="text-align: right;">
                                                {{ number_format($result->gunatenaga->jumlah, 0) }}</td>
                                            @php
                                                $jumlah_guna_tenaga += $result->gunatenaga->jumlah;
                                            @endphp


                                            <td style="text-align: right;">
                                                {{ number_format($result->pendapatan->l, 2) }}
                                            </td>
                                            @php
                                                $jumlah_gaji_lelaki += $result->pendapatan->l;
                                            @endphp
                                            <td style="text-align: right;">
                                                {{ number_format($result->pendapatan->p, 2) }}
                                            </td>
                                            @php
                                                $jumlah_gaji_perempuan += $result->pendapatan->p;
                                            @endphp
                                            <td style="text-align: right;">
                                                {{ number_format($result->pendapatan->jumlah, 2) }}</td>
                                            @php
                                                $jumlah_pendapatan += $result->pendapatan->jumlah;
                                            @endphp

                                            <td style="text-align: right;">{{ number_format($result->purata->l, 2) }}
                                            </td>
                                            @php
                                                $jumlah_purata_lelaki += $result->purata->l;
                                            @endphp
                                            <td style="text-align: right;">{{ number_format($result->purata->p, 2) }}
                                            </td>
                                            @php
                                                $jumlah_purata_perempuan += $result->purata->p;
                                            @endphp
                                            <td style="text-align: right;">
                                                {{ number_format($result->purata->jumlah, 2) }}</td>
                                            @php
                                                $jumlah_purata_keseluruhan += $result->purata->jumlah;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    <tr style="background-color: lightgray; font-weight: bold;">
                                        <td style="text-align: center;"></td>
                                        <td style="text-align: left;">Jumlah</td>
                                        <td style="text-align: right;">{{ number_format($jumlah_lelaki, 0) }}</td>
                                        <td style="text-align: right;">{{ number_format($jumlah_perempuan, 0) }}</td>
                                        <td style="text-align: right;">{{ number_format($jumlah_guna_tenaga, 0) }}
                                        </td>

                                        <td style="text-align: right;"> {{ number_format($jumlah_gaji_lelaki, 2) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($jumlah_gaji_perempuan, 2) }}</td>
                                        <td style="text-align: right;"> {{ number_format($jumlah_pendapatan, 2) }}
                                        </td>


                                        <td style="text-align: right;"> {{ number_format($jumlah_gaji_lelaki / max($jumlah_lelaki, 1), 2) }}
                                        </td>
                                        <td style="text-align: right;"> {{ number_format($jumlah_gaji_perempuan / max($jumlah_perempuan, 1), 2) }}
                                        </td>
                                        <td style="text-align: right;"> {{ number_format($jumlah_pendapatan / max($jumlah_guna_tenaga, 1), 2) }}
                                        </td>
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
