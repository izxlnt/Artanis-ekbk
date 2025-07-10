<style>
    table {
        border-collapse: collapse;
        font-size;
        15px;
    }

    td,
    th {
        border: 1px solid black;
        padding: 5px;
    }

    th {
        background-color: lightgrey;
    }

    .page-break {
        page-break-after: always;
    }

</style>

@php
$tahun = $results['tahun'] ?? '';
$pembeli_list = $results['pembeli_list'] ?? '';
$negeri_list = $results['negeri_list'] ?? '';
$datas = $results['datas'] ?? '';
$columns = $results['columns'] ?? [];
$title = $results['title_laporan'] ?? '';
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
                    {{ $tahun }}</div>

                <div class="card-body">


                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="text-center table-bordered" style="width: 100%;">
                            <thead style="background-color: #f3ce8f; font-weight: bold;">
                                <tr>
                                    @foreach ($columns as $data)
                                        <th>{{ $data }}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody style="text-align: right">

                                @php
                                    foreach ($negeri_list as $negeri_name) {
                                        $jumlah_negeri[$negeri_name->negeri] = 0;
                                    }

                                    $jumlah_keseluruhan = 0;
                                @endphp

                                @foreach ($datas as $pembeli => $data_pembeli)
                                    @php
                                        $jumlah_row = 0;
                                    @endphp

                                    <tr>
                                        <td style="text-align: center">{{ $loop->iteration }}</td>
                                        <td style="text-align: left">{{ $pembeli }}</td>
                                        @foreach ($data_pembeli as $negeri => $data)
                                            <td>{{ number_format($data[0]->jumlah_jualan) }}</td>
                                            @php
                                                $jumlah_row += $data[0]->jumlah_jualan;
                                                $jumlah_negeri[$negeri] += $data[0]->jumlah_jualan;
                                                $jumlah_keseluruhan += $data[0]->jumlah_jualan;
                                            @endphp
                                        @endforeach

                                        <td>{{ number_format($jumlah_row) }}</td>
                                    </tr>
                                @endforeach
                                <tr style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left">Jumlah (m³)</td>

                                    @foreach ($negeri_list as $nama_negeri)
                                        <td>{{ number_format($jumlah_negeri[$nama_negeri->negeri]) }}</td>
                                    @endforeach

                                    <td>{{ number_format($jumlah_keseluruhan) }}</td>
                                </tr>
                            </tbody>

                        </table>
                    </div>



                </div>
            </div>

        </div>
    </div>




</div>
