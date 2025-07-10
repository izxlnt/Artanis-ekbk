
    <style>
        table {
            border-collapse: collapse;
            /* font-size: 6px; */
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

                        <div class="table-responsive">
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
                                            <td> {{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $result->negeri_keterangan }}</td>
                                            <td class="text-left">Nipis</td>
                                            @foreach ($result->jumlahpengeluaran->nipis as $data)
                                                @if (is_numeric($data))
                                                    <td class="text-right">{{ number_format($data, 0) }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                        <tr class="text-center">
                                            <td></td>
                                            <td class="text-left"></td>
                                            <td class="text-left">Tebal</td>
                                            @foreach ($result->jumlahpengeluaran->tebal as $data)
                                                @if (is_numeric($data))
                                                    <td class="text-right">{{ number_format($data, 0) }}</td>
                                                @endif
                                            @endforeach
                                        </tr>
                                    @endforeach

                                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                        <td class="text-left"></td>
                                        <td class="text-left">Jumlah (m³)</td>
                                        <td class="text-left">Nipis</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['nipis'] as $data)
                                            <td class="text-right">{{ number_format($data, 0) }}</td>
                                        @endforeach
                                    </tr>
                                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td class="text-left"></td>
                                        <td class="text-left">Tebal</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['tebal'] as $data)
                                            @if (is_numeric($data))
                                                <td class="text-right">{{ number_format($data, 0) }}</td>
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
