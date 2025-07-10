<style>
    table {
      border-collapse: collapse;
      font-size: 6px;
    }

    td, th {
      border: 1px solid black;
    }

    th {
        background-color: lightgrey;
    }

</style>
<div class=" container-fluid">

    <div class="row">

        <div class="col-12">


            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} Bagi Tahun
                    {{ $tahun }}</div>
                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px;">
                        <table style="text-align: left;">
                            @if ($shuttle == 'shuttle3')
                                <thead style="text-align: center;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Guna Tenaga')
                                                <th class="text-center" colspan="6" style="text-align: center;">{{ $data }}</th>
                                            @elseif($data == 'Nilai Harta Tetap Pada Tahun Berakhir')
                                                <th class="text-center" rowspan="2" style="text-align: center;">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Penggunaan Kayu Balak')
                                                <th class="text-center" rowspan="2" style="text-align: center;">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Kayu Gergaji')
                                                <th class="text-center" rowspan="2" style="text-align: center;">{{ $data }}</th>
                                            @elseif($data == 'Penjualan Kayu Gergaji Eksport')
                                                <th class="text-center" rowspan="2" style="text-align: center;">{{ $data }}</th>
                                            @elseif($data == 'Penjualan Kayu Gergaji Tempatan')
                                                <th class="text-center" rowspan="2" style="text-align: center;">{{ $data }}</th>
                                            @else
                                                <th class="text-center" rowspan="3" style="text-align: center;">{{ $data }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="2" style="text-align: center;">Bumiputera</th>
                                        <th class="text-center" colspan="2" style="text-align: center;">Bukan Bumiputera</th>
                                        <th class="text-center" colspan="2" style="text-align: center;">Bukan Warganegara</th>

                                    </tr>
                                    <tr class="text-center">
                                        <th style="text-align: center;">RM</th>
                                        <th style="text-align: center;">L</th>
                                        <th style="text-align: center;">P</th>
                                        <th style="text-align: center;">L</th>
                                        <th style="text-align: center;">P</th>
                                        <th style="text-align: center;">L</th>
                                        <th style="text-align: center;">P</th>
                                        <th style="text-align: center;">m³</th>
                                        <th style="text-align: center;">m³</th>
                                        <th style="text-align: center;">m³</th>
                                        <th style="text-align: center;">m³</th>
                                    </tr>

                                </thead>
                            @elseif($shuttle == 'shuttle4')
                                <thead style="text-align: center;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Guna Tenaga')
                                                <th class="text-center" colspan="6" style="text-align: left;">{{ $data }}</th>
                                            @elseif($data == 'Nilai Harta Tetap Pada Tahun Berakhir')
                                                <th class="text-center" rowspan="2" style="text-align: left;">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Penggunaan Kayu Balak')
                                                <th class="text-center" rowspan="2" style="text-align: left;">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Kayu Gergaji')
                                                <th class="text-center" rowspan="2" style="text-align: left;">{{ $data }}</th>
                                            @elseif($data == 'Penjualan Kayu Gergaji Eksport')
                                                <th class="text-center" rowspan="2" style="text-align: left;">{{ $data }}</th>
                                            @elseif($data == 'Penjualan Kayu Gergaji Tempatan')
                                                <th class="text-center" rowspan="2" style="text-align: left;">{{ $data }}</th>
                                            @else
                                                <th class="text-center" rowspan="3" style="text-align: left;">{{ $data }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th class="text-center" colspan="2" style="text-align: left;">Bumiputera</th>
                                        <th class="text-center" colspan="2" style="text-align: left;">Bukan Bumiputera</th>
                                        <th class="text-center" colspan="2" style="text-align: left;">Bukan Warganegara</th>


                                    </tr>
                                    <tr class="text-center">
                                        <th style="text-align: left;">RM</th>
                                        <th style="text-align: left;">L</th>
                                        <th style="text-align: left;">P</th>
                                        <th style="text-align: left;">L</th>
                                        <th style="text-align: left;">P</th>
                                        <th style="text-align: left;">L</th>
                                        <th style="text-align: left;">P</th>
                                        <th style="text-align: left;"><span style="font-size:25px;">m³</span></th>
                                        <th style="text-align: left;"><span style="font-size:25px;">m³</span></th>
                                        <th style="text-align: left;"><span style="font-size:25px;">m³</span></th>
                                        <th style="text-align: left;"><span style="font-size:25px;">m³</span></th>
                                    </tr class="text-center">

                                </thead>
                            @endif
                            <tbody>


                                @foreach ($results as $result)
                                    <tr class="text-center">
                                        <td style="text-align: center;"> {{ $loop->iteration }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_namakilang ?? '' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_nossm ?? '' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_nolesen ?? '' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_notel ?? '' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_nofaks ?? '-' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_email ?? '' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_alamatkilang_jalan1 ?? '' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_alamatkilang_jalan2 ?? '' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_alamatkilang_poskod ?? '' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_daerah ?? ('' ?? '') }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_negeri ?? '' }}</td>

                                        <td class="text-left" style="text-align: left;">N/A</td>
                                        <td class="text-left" style="text-align: left;">N/A</td>
                                        <td class="text-left" style="text-align: left;">N/A</td>
                                        <td class="text-left" style="text-align: left;">N/A</td>

                                        <td class="text-left" style="text-align: left;">
                                            {{ Carbon\Carbon::parse($result->rekod_tarikhtubuh ?? '')->format('d-m-Y') }}
                                        </td>
                                        <td class="text-left" style="text-align: left;">
                                            {{ Carbon\Carbon::parse($result->rekod_tarikhoperasi ?? '')->format('d-m-Y') }}
                                        </td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_tarafsyarikat ?? '' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ $result->rekod_statushakmilik ?? '' }}</td>
                                        <td class="text-left" style="text-align: left;">{{ number_format($result->rekod_nilaiharta, 2) }}
                                        </td>
                                        <td class="text-left" style="text-align: left;">
                                            {{ Carbon\Carbon::parse($result->rekod_modified_on ?? '')->format('d-m-Y') }}
                                        </td>
                                        <td class="text-right" style="text-align: right;">{{ $result->guna_tenaga->sum_wargabumi_l ?? '' }}
                                        </td>
                                        <td class="text-right" style="text-align: right;">{{ $result->guna_tenaga->sum_wargabumi_p ?? '' }}
                                        </td>
                                        <td class="text-right" style="text-align: right;">
                                            {{ $result->guna_tenaga->sum_wargabukanbumi_l ?? '' }}</td>
                                        <td class="text-right" style="text-align: right;">
                                            {{ $result->guna_tenaga->sum_wargabukanbumi_p ?? '' }}</td>
                                        <td class="text-right" style="text-align: right;">{{ $result->guna_tenaga->sum_bukanwarga_l ?? '' }}
                                        </td>
                                        <td class="text-right" style="text-align: right;">{{ $result->guna_tenaga->sum_bukanwarga_p ?? '' }}
                                        </td>
                                        <td class="text-right" style="text-align: right;">{{ number_format($result->jumlahpenggunaan, 0) }}
                                        </td>
                                        <td class="text-right" style="text-align: right;">{{ number_format($result->jumlahpengeluaran, 0) }}
                                        </td>
                                        <td class="text-right" style="text-align: right;">{{ number_format($result->jumlaheksport, 0) }}
                                        </td>
                                        <td class="text-right" style="text-align: right;">{{ number_format($result->jumlahtempatan, 0) }}
                                        </td>

                                    </tr>
                                @endforeach


                            </tbody>
                        </table>



                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
