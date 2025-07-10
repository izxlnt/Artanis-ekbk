<style>
    table {
        border-collapse: collapse;
        font-size: 12px;
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
                {{-- <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title }}</div> --}}
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
                        <div class="table-responsive">
                            @if (!$loop->first)
                                <div class="page-break"></div>
                                @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                                    <div class="text-center card-header" style="text-align: center;">
                                        {{ $title_laporan }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }}
                                        Bagi Tahun
                                        {{ $tahun }}</div>
                                @else
                                    <div class="text-center card-header" style="text-align: center;">
                                        {{ $title_laporan }} : Suku
                                        Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
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
                                <table id="example_{{ $key }}" class="table-bordered"
                                    style="width: 100%; padding-top: 10px;">
                                    <thead style="background-color: #f3ce8f;">
                                        <tr>
                                            @foreach ($columns as $data)
                                                @if ($data == 'Bumiputera')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Bukan Bumiputera')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Bukan Warganegara')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Bukan Warganegara')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Jumlah Guna Tenaga')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Pendapatan (RM)')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Purata Pendapatan (RM)')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @else
                                                    <th class="text-center" rowspan="2">{{ $data }}</th>
                                                @endif
                                            @endforeach
                                        </tr>
                                        <tr>
                                            <th class="text-center">L</th>
                                            <th class="text-center">P</th>
                                            <th class="text-center">Jumlah (L+P)</th>

                                            <th class="text-center">L</th>
                                            <th class="text-center">P</th>
                                            <th class="text-center">Jumlah (L+P)</th>

                                            <th class="text-center">L</th>
                                            <th class="text-center">P</th>
                                            <th class="text-center">Jumlah (L+P)</th>

                                            <th class="text-center">L</th>
                                            <th class="text-center">P</th>
                                            <th class="text-center">Jumlah (L+P)</th>

                                            <th class="text-center">L</th>
                                            <th class="text-center">P</th>
                                            <th class="text-center">Jumlah (L+P)</th>

                                            <th class="text-center">L</th>
                                            <th class="text-center">P</th>
                                            <th class="text-center">Jumlah (L+P)</th>
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

                                            $jumlah_gaji_lelaki = 0;
                                            $jumlah_gaji_perempuan = 0;
                                            $jumlah_pendapatan = 0;

                                            $jumlah_purata_lelaki = 0;
                                            $jumlah_purata_perempuan = 0;
                                            $jumlah_purata_keseluruhan = 0;

                                        @endphp

                                        @foreach ($suku as $result)
                                            <tr class="text-center">
                                                <td>{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $result->kod_keterangan }}</td>

                                                <td class="text-right">
                                                    {{ number_format($result->wargabumi->l, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->wargabumi->p, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->wargabumi->jumlah, 0) }}
                                                </td>

                                                <td class="text-right">
                                                    {{ number_format($result->wargabukanbumi->l, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->wargabukanbumi->p, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->wargabukanbumi->jumlah, 0) }}</td>

                                                <td class="text-right">
                                                    {{ number_format($result->bukanwarga->l, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->bukanwarga->p, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->bukanwarga->jumlah, 0) }}</td>

                                                <td class="text-right">
                                                    {{ number_format($result->keseluruhan->l, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->keseluruhan->p, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->keseluruhan->jumlah, 0) }}</td>

                                                <td class="text-right">
                                                    {{ number_format($result->pendapatan->l, 2) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->pendapatan->p, 2) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->pendapatan->jumlah, 2) }}</td>

                                                <td class="text-right">{{ number_format($result->purata->l, 2) }}
                                                </td>
                                                <td class="text-right">{{ number_format($result->purata->p, 2) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->purata->jumlah, 2) }}
                                                </td>
                                            </tr>

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

                                                $jumlah_gaji_lelaki += $result->pendapatan->l;
                                                $jumlah_gaji_perempuan += $result->pendapatan->p;
                                                $jumlah_pendapatan += $result->pendapatan->jumlah;

                                                $jumlah_purata_lelaki += $result->purata->l;
                                                $jumlah_purata_perempuan += $result->purata->p;
                                                $jumlah_purata_keseluruhan += $result->purata->jumlah;

                                            @endphp
                                        @endforeach

                                        <tr class="text-right"
                                            style="background-color: lightgray; font-weight: bold;">
                                            <td class="text-center"></td>
                                            <td class="text-left">Jumlah</td>

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

                                            <td> {{ number_format($jumlah_gaji_lelaki, 2) }}</td>
                                            <td> {{ number_format($jumlah_gaji_perempuan, 2) }}</td>
                                            <td> {{ number_format($jumlah_pendapatan, 2) }}</td>

                                            <td> {{ number_format($jumlah_gaji_lelaki / max($jumlah_jumlah_lelaki, 1), 2) }}
                                            </td>
                                            <td> {{ number_format($jumlah_gaji_perempuan / max($jumlah_jumlah_perempuan, 1), 2) }}
                                            </td>
                                            <td> {{ number_format($jumlah_pendapatan / max($jumlah_jumlah_jumlah, 1), 2) }}
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
