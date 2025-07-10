<style>
    table {
        border-collapse: collapse;
        font-size: 6px;
    }

    td,
    th {
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
                        <table id="example" class="table-bordered">
                            <thead style="text-align: center;">
                                <tr>
                                    @foreach ($columns as $data)
                                        @if ($data == 'Guna Tenaga')
                                            <th style="text-align: center;" colspan="6">{{ $data }}</th>
                                        @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Jenis')
                                            <th style="text-align: center;" colspan="2" rowspan="2">{{ $data }}
                                            </th>
                                        @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan')
                                            <th style="text-align: center;" colspan="2" rowspan="2">{{ $data }}
                                            </th>
                                        @elseif($data == 'Jumlah Pengeluaran Venir Mengikut Jenis')
                                            <th style="text-align: center;" colspan="2" rowspan="2">{{ $data }}
                                            </th>
                                        @elseif($data == 'Jualan Eksport')
                                            <th style="text-align: center;" colspan="2">{{ $data }}</th>
                                        @elseif($data == 'Jualan Tempatan')
                                            <th style="text-align: center;" colspan="2">{{ $data }}</th>
                                        @else
                                            <th style="text-align: center;" rowspan="3">{{ $data }}</th>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <th colspan="2">Bumiputera</th>
                                    <th colspan="2">Bukan Bumiputera</th>
                                    <th colspan="2">Bukan Warganegara</th>

                                    <th rowspan="2">Penjualan Papan Lapis Eksport</th>
                                    <th rowspan="2">Penjualan Venir Eksport</th>

                                    <th rowspan="2">Penjualan Papan Lapis Tempatan</th>
                                    <th rowspan="2">Penjualan Venir Tempatan</th>
                                </tr>
                                <tr>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>P</th>

                                    <th>MR</th>
                                    <th>WBP</th>

                                    <th>Nipis</th>
                                    <th>Tebal</th>

                                    <th>Muka</th>
                                    <th>Teras</th>
                                </tr>

                                <tr>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th>RM</th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                    <th><span>m³</span></th>
                                </tr>

                            </thead>
                            <tbody>


                                @foreach ($results as $result)
                                    <tr style="text-align: center;">
                                        <td> {{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_namakilang ?? '' }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_nossm ?? '' }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_nolesen ?? '' }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_notel ?? '' }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_nofaks ?? '-' }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_email ?? '' }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_alamatkilang_jalan1 ?? '' }}
                                        </td>
                                        <td style="text-align: left;">{{ $result->rekod_alamatkilang_jalan2 ?? '' }}
                                        </td>
                                        <td style="text-align: left;">{{ $result->rekod_alamatkilang_poskod ?? '' }}
                                        </td>
                                        <td style="text-align: left;">{{ $result->rekod_daerah ?? ('' ?? '') }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_negeri ?? '' }}</td>

                                        <td style="text-align: left;">N/A</td>
                                        <td style="text-align: left;">N/A</td>
                                        <td style="text-align: left;">N/A</td>
                                        <td style="text-align: left;">N/A</td>



                                        <td style="text-align: left;">
                                            {{ Carbon\Carbon::parse($result->rekod_tarikhtubuh ?? '')->format('d-m-Y') }}
                                        </td>
                                        <td style="text-align: left;">
                                            {{ Carbon\Carbon::parse($result->rekod_tarikhoperasi ?? '')->format('d-m-Y') }}
                                        </td>
                                        <td style="text-align: left;">{{ $result->rekod_tarafsyarikat ?? '' }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_statushakmilik ?? '' }}</td>
                                        <td style="text-align: left;">
                                            {{ number_format($result->rekod_nilaiharta, 2) }}
                                        </td>
                                        <td style="text-align: left;">
                                            {{ Carbon\Carbon::parse($result->rekod_modified_on ?? '')->format('d-m-Y') }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ $result->guna_tenaga->sum_wargabumi_l ?? 0 }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ $result->guna_tenaga->sum_wargabumi_p ?? 0 }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ $result->guna_tenaga->sum_wargabukanbumi_l ?? 0 }}</td>
                                        <td style="text-align: right;">
                                            {{ $result->guna_tenaga->sum_wargabukanbumi_p ?? 0 }}</td>
                                        <td style="text-align: right;">
                                            {{ $result->guna_tenaga->sum_bukanwarga_l ?? 0 }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ $result->guna_tenaga->sum_bukanwarga_p ?? 0 }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahstoksemasa, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahpenggunaan, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahpengeluaran->jumlahmr, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahpengeluaran->jumlahwbp, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahpengeluaran->nipis, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahpengeluaran->tebal, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahpengeluaran->muka, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahpengeluaran->teras, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlaheksportlapis, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlaheksportvenier, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahtempatanlapis, 0) }}
                                        </td>
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahtempatanvenier, 0) }}
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
