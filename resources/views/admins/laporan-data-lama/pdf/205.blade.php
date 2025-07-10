
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
    <div class="container-fluid">

        <div class="row">

            <div class="col-12">


                <div class="card">
                    <div class="text-center card-header" >{{ $title_laporan }} Bagi Tahun
                        {{ $tahun }}</div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="example" class="table-bordered">

                                <thead>
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Jenis')
                                                <th class="text-center" colspan="2" rowspan="1">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan')
                                                <th class="text-center" colspan="2" rowspan="1">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Papan Venir Mengikut Jenis')
                                                <th class="text-center" colspan="2" rowspan="1">{{ $data }}ss</th>
                                            @else
                                                <th class="text-center" rowspan="3">{{ $data }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @if ($title == '206')
                                            <th class="text-center">Muka</th>
                                            <th class="text-center">Teras</th>
                                        @else
                                            <th class="text-center">MR</th>
                                            <th class="text-center">WBP</th>
                                            <th class="text-center">Nipis</th>
                                            <th class="text-center">Tebal</th>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if ($title == '206')
                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>
                                        @else
                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($results as $result)
                                        <tr class="text-center">
                                            <td> {{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $result->rekod_namakilang ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_nossm ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_nolesen ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_notel ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_nofaks ?? '-' }}</td>
                                            <td class="text-left">{{ $result->rekod_email ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_alamatkilang_jalan1 ?? '' }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_alamatkilang_jalan2 ?? '' }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_alamatkilang_poskod ?? '' }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_daerah ?? ('' ?? '') }}</td>
                                            <td class="text-left">{{ $result->rekod_negeri ?? '' }}</td>

                                            <td class="text-left">N/A</td>
                                            <td class="text-left">N/A</td>
                                            <td class="text-left">N/A</td>
                                            <td class="text-left">N/A</td>

                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($result->rekod_tarikhtubuh ?? '')->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($result->rekod_tarikhoperasi ?? '')->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_tarafsyarikat ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_statushakmilik ?? '' }}</td>
                                            @if ($title == '206')
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->muka, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->teras, 0) }}</td>
                                            @else
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->jumlahmr, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->jumlahwbp, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->nipis, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->tebal, 0) }}</td>
                                            @endif
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

