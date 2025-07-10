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
                <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} Bagi Tahun
                    {{ $tahun }}</div>
                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="table-bordered" style="border: 1px solid #000 !important; width: 100%;">
                            <thead>
                                <tr>
                                    @foreach ($columns as $data)
                                        <th style="border: 1px solid #000 !important; text-align: center;" style="border: 1px solid #000 !important;">{{ $data }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($results as $result)
                                    <tr style="border: 1px solid #000 !important; text-align: center;">
                                        <td style="border: 1px solid #000 !important; text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="border: 1px solid #000 !important; text-align: left;">{{ $result->negeri_keterangan }}</td>
                                        @foreach ($result->jumlahpengeluaran as $data)
                                            @if (is_numeric($data))
                                                <td style="border: 1px solid #000 !important; text-align: right;">{{ number_format($data, 0) }}</td>
                                            @endif
                                        @endforeach
                                    </tr>
                                @endforeach

                                <tr style="background-color: lightgray; font-weight: bold; border: 1px solid #000 !important; text-align: center;">
                                    <td style="border: 1px solid #000 !important; text-align: center;"></td>
                                    <td style="border: 1px solid #000 !important; text-align: left;">Jumlah (m³)</td>

                                    @foreach ($grandtotal->jumlahpengeluaran as $total)
                                        @if (is_numeric($total))
                                            <td style="border: 1px solid #000 !important; text-align: right;">{{ number_format($total, 0) }}</td>
                                        @endif
                                    @endforeach

                                </tr>

                            </tbody>
                            {{-- <tfoot>
                                <tr style="border: 1px solid #000 !important; text-align: center;" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="border: 1px solid #000 !important; text-align: left;">JUMLAH BESAR (m³)</td>

                                    @foreach ($grandtotal->jumlahpengeluaran as $total)
                                        @if (is_numeric($total))
                                            <td style="border: 1px solid #000 !important; text-align: right;">{{ number_format($total, 0) }}</td>
                                        @endif
                                    @endforeach

                                </tr>
                            </tfoot> --}}
                        </table>



                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
