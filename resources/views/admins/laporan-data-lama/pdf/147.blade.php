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
                            @if ($shuttle == 'shuttle3' || $shuttle == 'shuttle5')
                                <thead>
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th class="text-center">{{ $data }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                            @endif
                            <tbody style="text-align: right;">

                                @foreach ($results as $result)
                                    <tr class="text-center">
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        @if($shuttle == 'shuttle5')
                                        <td style="text-align: left;">{{ $result->kayukumai->bulan }}</td>
                                        <td class="text-right">
                                            {{ number_format($result->kayukumai->jualaneksport, 0) }}</td>
                                        @else
                                        <td style="text-align: left;">{{ $result->kayugergaji->bulan }}</td>
                                        <td class="text-right">
                                            {{ number_format($result->kayugergaji->jualaneksport, 0) }}</td>
                                        @endif
                                    </tr>
                                @endforeach

                                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left;.">Jumlah (m³)</td>
                                    @foreach ($grandtotal->jualaneksport as $total)
                                            @if (is_numeric($total))
                                                <td class="text-right">{{ number_format($total, 0) }}</td>
                                            @endif
                                        @break
                                    @endforeach
                            </tr>
                            </tbody>
                            {{-- <tfoot>
                                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td class="text-left">JUMLAH (m³)</td>
                                    @foreach ($grandtotal->jualaneksport as $total)
                                        @if (is_numeric($total))
                                            <td class="text-right">{{ number_format($total, 0) }}</td>
                                        @endif
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
