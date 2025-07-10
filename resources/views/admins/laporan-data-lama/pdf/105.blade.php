<style>
    table {
      border-collapse: collapse;
      font-size: 10px;
    }

    td, th {
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
                <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} Bagi Tahun {{ $tahun }}</div>
                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="table-bordered">
                            @if($shuttle == 'shuttle3' || $shuttle == 'shuttle5')
                                <thead style="background-color: lightgrey; font-weight: bold;">
                                    <tr>
                                    @foreach ($columns as $data)
                                        @if($data == 'Jumlah Pengeluaran Kayu Gergaji')
                                        <th style="text-align: center;">{{ $data }}</th>
                                        @else
                                        <th style="text-align: center;" rowspan="2">{{ $data }}</th>
                                        @endif
                                    @endforeach
                                    </tr>
                                    <tr>
                                        <th style="text-align: center;">m³</th>
                                    </tr>
                                </thead>
                            @endif
                            <tbody>

                                @foreach ($results as $result)
                                    <tr style="text-align: center;">
                                        <td> {{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_namakilang ?? "" }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_nossm ?? ""}}</td>
                                        <td style="text-align: left;">{{ $result->rekod_nolesen ?? ""}}</td>
                                        <td style="text-align: left;">{{ $result->rekod_notel ?? ""}}</td>
                                        <td style="text-align: left;">{{ $result->rekod_nofaks ?? '-' }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_email ?? ""}}</td>
                                        <td style="text-align: left;">{{ $result->rekod_alamatkilang_jalan1 ?? ""}}</td>
                                        <td style="text-align: left;">{{ $result->rekod_alamatkilang_jalan2 ?? ""}}</td>
                                        <td style="text-align: left;">{{ $result->rekod_alamatkilang_poskod ?? ""}}</td>
                                        <td style="text-align: left;">{{ $result->rekod_daerah ?? ""?? ""}}</td>
                                        <td style="text-align: left;">{{ $result->rekod_negeri ?? ""}}</td>

                                        <td style="text-align: left;">N/A</td>
                                        <td style="text-align: left;">N/A</td>
                                        <td style="text-align: left;">N/A</td>
                                        <td style="text-align: left;">N/A</td>

                                        <td style="text-align: left;">{{ Carbon\Carbon::parse($result->rekod_tarikhtubuh ?? "")->format('d-m-Y')  }}</td>
                                        <td style="text-align: left;">{{ Carbon\Carbon::parse($result->rekod_tarikhoperasi ?? "")->format('d-m-Y') }}</td>
                                        <td style="text-align: left;">{{ $result->rekod_tarafsyarikat ?? ""}}</td>
                                        <td style="text-align: left;">{{ $result->rekod_statushakmilik ?? ""}}</td>
                                        <td style="text-align: right;">{{ number_format($result->jumlahpengeluaran, 0) }}</td>
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
