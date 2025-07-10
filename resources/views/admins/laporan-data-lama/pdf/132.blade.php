<style>
    table {
    border-collapse: collapse;
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
                    {{ $tahun }} Hingga Tahun {{ $tahunakhir }}</div>
                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="table-bordered" style="width:100%">
                            <thead style="background-color: #f3ce8f;">
                                <tr>
                                    @foreach ($columns as $data)
                                        <th style="text-align: center;">{{ $data }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($results as $result)
                                    <tr class="text-center">
                                        <td style="text-align: center;"> {{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $result->negeri_keterangan }}</td>
                                        @foreach ($result->jumlahpengeluaran as $data)
                                            @if (is_numeric($data))
                                                <td style="text-align: right;">{{ number_format($data, 0) }}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach
                                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                    <td style="text-align: center;"></td>
                                    <td style="text-align: left;">Jumlah (m³)</td>
                                    @foreach ($grandtotal->jumlahpengeluaran as $total)
                                        @if (is_numeric($total))
                                            <td style="text-align: right;">{{ number_format($total, 0) }}</td>
                                        @endif
                                    @endforeach
                                </tr>

                            </tbody>
                        </table>



                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
