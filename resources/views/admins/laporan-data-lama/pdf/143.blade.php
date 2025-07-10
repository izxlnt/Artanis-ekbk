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
                                        <th style="border: 1px solid #000 !important; text-align: center;">{{ $data }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($results as $result)
                                    <tr class="text-center">
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $result->negeri_keterangan }}</td>
                                        @for ($i = 1; $i <= 13; $i++)
                                            <td class="text-right">
                                                @if($title == '243')
                                                {{ number_format($result->papanlapis->$i->jualantempatan, 0) }}
                                                @elseif($title == '244')
                                                {{ number_format($result->venier->$i->jualantempatan, 0) }}
                                                @elseif($title == '343')
                                                {{ number_format($result->kayukumai->$i->jualantempatan, 0) }}
                                                @else
                                                {{ number_format($result->kayugergaji->$i->jualantempatan, 0) }}
                                                @endif
                                            </td>
                                        @endfor
                                    </tr>
                                @endforeach

                                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                    <td class="text-center"></td>
                                    <td class="text-left">Jumlah (m³)</td>
                                    @foreach ($grandtotal->jualantempatan as $total)
                                        <td class="text-right">{{ number_format($total, 0) }}</td>
                                    @endforeach
                                </tr>

                            </tbody>
                            {{-- <tfoot>
                                <tr style="border: 1px solid #000 !important; text-align: center;" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td>JUMLAH (m³)</td>
                                    @foreach ($grandtotal->jualantempatan as $total)
                                        <td style="border: 1px solid #000 !important; text-align: center;">{{ number_format($total, 0) }}</td>
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
