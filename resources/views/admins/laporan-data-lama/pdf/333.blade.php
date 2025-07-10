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
                                            <td> {{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $result->kod_keterangan }}</td>
                                            @for ($gi = 1; $gi <= 13; $gi++)
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->$gi, 0) }}

                                                </td>
                                            @endfor
                                        </tr>
                                    @endforeach
                                    <tr style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td class="text-left">Jumlah (m³)</td>
                                        @for ($gi = 1; $gi <= 13; $gi++)
                                            <td class="text-right">
                                                {{ number_format($grandtotal->jumlahpengeluaran[$gi], 0) }}</td>
                                        @endfor
                                    </tr>

                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>


            </div>
        </div>
    </div>
