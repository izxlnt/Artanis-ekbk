<style>
    table {
    border-collapse: collapse;
    font-size: 15px;
    }

    td, th {
    border: 1px solid black;
    padding: 5px;
    }

    th {
        background-color: lightgrey;
    }
</style>

<div class="container-fluid">

    <div class="row">

        <div class="col-12">


            <div class="card">
                <div class="text-center card-header" style="text-align: center">{{ $title_laporan }} Bagi Tahun
                    {{ $tahun }}</div>
                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="table-bordered" style="width: 100%;">
                            <thead style="background-color: #f3ce8f">
                                <tr>
                                    @foreach ($columns as $data)
                                        <th class="text-center">{{ $data }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($results as $result)
                                    <tr class="text-center">
                                        <td style="text-align: center;"> {{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $result->kod_keterangan }}</td>
                                        @for ($gi = 1; $gi <= 13; $gi++)
                                            <td style="text-align: right;">
                                                {{ number_format($result->jualantempatan->kayugergaji->$gi, 0) }}
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach
                                <tr style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left;">Jumlah (m³)</td>
                                    @for ($gi = 1; $gi <= 13; $gi++)
                                        <td style="text-align: right;">
                                            {{ number_format($grandtotal->jualantempatan[$gi], 0) }}</td>
                                    @endfor
                                </tr>

                            </tbody>
                            <tfoot>
                                {{-- <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td>JUMLAH BESAR </td>
                                    <td>{{ number_format($grandtotal->jualantempatan, 0) }}</td>
                                </tr> --}}
                            </tfoot>
                        </table>



                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
