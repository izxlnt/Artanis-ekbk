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

</style>
<div class="container-fluid">

    <div class="row">

        <div class="col-12">


            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} Bagi Tahun
                    {{ $tahun }}</div>
                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px; width: 100%;">
                        <table id="example" class="table-bordered">
                            <thead style="background-color: #f3ce8f">
                                <tr>
                                    @foreach ($columns as $data)
                                        <th style="text-align: center;">{{ $data }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($results as $result)
                                    <tr>
                                        <td style="text-align: center;"> {{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $result->kod_keterangan }}</td>
                                        @for ($i = 0; $i < 12; $i++)
                                            <td style="text-align: right;">
                                                {{ number_format($result->jualantempatan->kayugergaji[$i], 0) }}</td>
                                        @endfor
                                        <td style="text-align: right;">
                                            {{ number_format($result->jumlahkeseluruhan->kayugergaji, 0) }}</td>
                                    </tr>
                                @endforeach
                                <tr style="background-color: lightgray; font-weight: bold;">
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: left;">Jumlah (m³)</td>
                                    @foreach ($total as $data)
                                        <td style="text-align: right;">{{ number_format($data->jualantempatan, 0) }}</td>
                                    @endforeach
                                    <td style="text-align: right;">{{ number_format($grandtotal->jualantempatan, 0) }}
                                    </td>
                                </tr>
                            </tbody>
                            {{-- <tfoot>
                                <tr style="text-align: center;" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td>JUMLAH BESAR </td>
                                    @foreach ($total as $data)
                                        <td>{{ number_format($data->jualantempatan, 0) }}</td>
                                    @endforeach
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
