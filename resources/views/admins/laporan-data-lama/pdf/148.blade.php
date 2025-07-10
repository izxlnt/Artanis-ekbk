<style>
    table {
    border-collapse: collapse;
    /* font-size: 15px; */
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
                        <table id="example" class="table-bordered" style="width:100%">
                            <thead>
                                <tr>
                                    @foreach ($columns as $data)
                                        <th class="text-center">{{ $data }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($results as $result)
                                    <tr class="text-center">
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $result->negeri_keterangan }}</td>
                                        @if($shuttle == 'shuttle5')
                                        <td style="text-align: right;">
                                            {{ number_format($result->kayukumai->jualaneksport, 0) }}</td>
                                        @else
                                        <td style="text-align: right;">
                                            {{ number_format($result->kayugergaji->jualaneksport, 0) }}</td>
                                        @endif
                                    </tr>
                                @endforeach

                                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td style="text-align: left;">Jumlah (m³)</td>
                                        @foreach ($grandtotal->jualaneksport as $total)
                                                <td style="text-align: right;">{{ number_format($total, 0) }}</td>
                                        @break
                                        @endforeach
                                </tr>

                            </tbody>
                            {{-- <tfoot>
                                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left;">JUMLAH (m³)</td>
                                    @foreach ($grandtotal->jualaneksport as $total)
                                        <td style="text-align: right;">{{ number_format($total, 0) }}</td>
                                    @break
                                @endforeach
                            </tr>
                        </tfoot> --}}
                    </table>



                </div>
            </div>
        </div>


    </div>
</div>
