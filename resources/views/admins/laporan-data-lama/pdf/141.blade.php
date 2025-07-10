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
                        <table id="example" class="table-bordered" style="border: 1px solid #000 !important; width: 100%;">
                            @if ($shuttle == 'shuttle3' || $shuttle == 'shuttle5')
                                <thead>
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th style="border: 1px solid #000 !important; text-align: center;">{{ $data }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                            @endif
                            <tbody>

                                @foreach ($results as $result)
                                    @if ($shuttle == 'shuttle4')
                                        <tr class="text-center">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $result->kayugergaji->bulan }}</td>
                                            <td class="text-right">
                                                {{ number_format($result->papanlapis->jualantempatan, 0) }}</td>
                                            <td class="text-right">
                                                {{ number_format($result->venier->jualantempatan, 0) }}</td>
                                        </tr>
                                    @elseif ($shuttle == 'shuttle5')
                                        <tr class="text-center">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $result->kayukumai->bulan }}</td>
                                            <td class="text-right">
                                                {{ number_format($result->kayukumai->jualantempatan, 0) }}</td>
                                        </tr>
                                    @else
                                        <tr class="text-center">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $result->kayugergaji->bulan }}</td>
                                            <td class="text-right">
                                                {{ number_format($result->kayugergaji->jualantempatan, 0) }}</td>
                                        </tr>
                                    @endif
                                @endforeach

                                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                    <td class="text-center"></td>
                                    <td class="text-left">Jumlah (m³)</span></td>
                                    @if ($shuttle == 'shuttle4')
                                        @foreach ($grandtotal->jualantempatan as $total)
                                            <td class="text-right">{{ number_format($total, 0) }}</td>
                                        @endforeach

                                    @elseif ($shuttle == 'shuttle5')
                                        @foreach ($grandtotal->jualantempatan as $total)
                                            <td class="text-right">{{ number_format($total, 0) }}</td>
                                            @break
                                        @endforeach
                                    @else
                                        @foreach ($grandtotal->jualantempatan as $total)
                                            @if (is_numeric($total))
                                                <td class="text-right">{{ number_format($total, 0) }}</td>
                                            @endif
                                        @break
                                        @endforeach
                                    @endif
                                </tr>
                        </tbody>
                            {{-- <tfoot>
                                <tr style="border: 1px solid #000 !important; text-align: center;" style="background-color: lightgray; font-weight: bold;">
                                    <td style="border: 1px solid #000 !important; text-align: center;"></td>
                                    <td style="border: 1px solid #000 !important; text-align: left;">JUMLAH (m³)</span></td>
                                    @foreach ($grandtotal->jualantempatan as $total)
                                        @if (is_numeric($total))
                                            <td style="border: 1px solid #000 !important; text-align: right;">{{ number_format($total, 0) }}</td>
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
