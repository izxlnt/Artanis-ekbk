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
                    {{-- <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title }} : Suku Tahun {{ $nama_suku_tahun }} ({{ $tahun }})</div> --}}
                    @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                        <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} : Suku
                            Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                            {{ $tahun }}</div>
                    @else
                        <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} : Suku
                            Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                    @endif
                    <div class="card-body">
                        @foreach ($results as $key => $suku)
                            @if(!$loop->first)
                                <div class="page-break"></div>
                                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                                    <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                                        {{ $tahun }}</div>
                                @else
                                    <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Bagi Tahun {{ $tahun }}</div>
                                @endif
                            @endif
                            <div class="table-responsive" style="padding-top: 15px;">

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

                                <table id="example_{{ $key }}" class="table-bordered" style="width: 100%; padding-top: 10px;">
                                    <thead style="background-color: lightgrey;">
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
                                                <td style="text-align: center;"> {{ $loop->iteration }}</td>
                                                <td style="text-align: left;">{{ $result->kod_keterangan }}</td>
                                                <td style="text-align: right;">{{ number_format($result->gunatenaga->l, 0) }}
                                                </td>
                                                <td style="text-align: right;">{{ number_format($result->gunatenaga->p, 0) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->gunatenaga->jumlah, 0) }}</td>

                                                <td style="text-align: right;">{{ number_format($result->pendapatan->l, 2) }}
                                                </td>
                                                <td style="text-align: right;">{{ number_format($result->pendapatan->p, 2) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->pendapatan->jumlah, 2) }}</td>

                                                <td style="text-align: right;">{{ number_format($result->purata->l, 2) }}
                                                </td>
                                                <td style="text-align: right;">{{ number_format($result->purata->p, 2) }}
                                                </td>
                                                <td style="text-align: right;">
                                                    {{ number_format($result->purata->jumlah, 2) }}</td>
                                            </tr>

                                            @php

                                                $jumlah_lelaki += $result->gunatenaga->l;
                                                $jumlah_perempuan += $result->gunatenaga->p;
                                                $jumlah_guna_tenaga += $result->gunatenaga->jumlah;

                                                $jumlah_gaji_lelaki += $result->pendapatan->l;
                                                $jumlah_gaji_perempuan += $result->pendapatan->p;
                                                $jumlah_pendapatan += $result->pendapatan->jumlah;

                                                $jumlah_purata_lelaki += $result->purata->l;
                                                $jumlah_purata_perempuan += $result->purata->p;
                                                $jumlah_purata_keseluruhan += $result->purata->jumlah;

                                            @endphp
                                        @endforeach

                                        <tr style="background-color: lightgray; font-weight: bold;">
                                            <td style="text-align: center;"></td>
                                            <td style="text-align: left;">Jumlah</td>
                                            <td style="text-align: right;">{{ number_format($jumlah_lelaki, 0) }}</td>
                                            <td style="text-align: right;">{{ number_format($jumlah_perempuan, 0) }}</td>
                                            <td style="text-align: right;">{{ number_format($jumlah_guna_tenaga, 0) }}</td>

                                            <td style="text-align: right;"> {{ number_format($jumlah_gaji_lelaki, 2) }}</td>
                                            <td style="text-align: right;"> {{ number_format($jumlah_gaji_perempuan, 2) }}</td>
                                            <td style="text-align: right;"> {{ number_format($jumlah_pendapatan, 2) }}</td>

                                            <td style="text-align: right;"> {{ number_format($jumlah_purata_lelaki, 2) }}</td>
                                            <td style="text-align: right;"> {{ number_format($jumlah_purata_perempuan, 2) }}</td>
                                            <td style="text-align: right;"> {{ number_format($jumlah_purata_keseluruhan, 2) }}</td>

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
