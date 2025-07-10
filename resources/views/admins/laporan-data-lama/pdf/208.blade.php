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
                    <div class="text-center card-header">{{ $title_laporan }} Bagi Tahun
                        {{ $tahun }}</div>
                    <div class="card-body">

                        <div>
                            <table>
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Nilai Harta Tetap Pada Tahun Berakhir')
                                                <th rowspan="1">{{ $data }} <br> RM</th>
                                            @else
                                                <th>{{ $data }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
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
                                            <td class="text-left">{{ $result->rekod_daerah ?? '' }}</td>
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
                                            <td class="text-right">
                                                {{ number_format($result->rekod_nilaiharta, 0) }}</td>

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

