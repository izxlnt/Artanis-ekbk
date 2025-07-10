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

$tahun = $results['tahun'] ?? [];
$tahun_mula = $results['tahun_mula'] ?? [];
$tahun_akhir = $results['tahun_akhir'] ?? [];
$negeri_list = $results['negeri_list'] ?? [];
$datas = $results['datas'] ?? [];
$grandtotal = $results['grandtotal'] ?? [];
$columns = $results['columns'] ?? [];
$title_laporan = $results['title_laporan'] ?? [];

@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">



            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Dari Tahun
                    {{ $tahun_mula }} Hingga {{ $tahun_akhir }}</div>
                <div class="card-body">
                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="text-center table-bordered" style="width: 100%">
                            <thead style="background-color: #f3ce8f;">
                                <tr>
                                    @foreach ($columns as $data)
                                        <th>{{ $data }}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody style="text-align: right;">
                                @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                    @php
                                        $jumlah_col = 0;
                                        $total[$x] = 0;
                                    @endphp
                                @endfor

                                @foreach ($datas as $negeri => $data_tahun)
                                    @php
                                        $jumlah_row = 0;
                                    @endphp

                                    <tr>
                                        <td style="text-align: center;"> {{ $loop->iteration }}</td>
                                        <td style="text-align: left;"> {{ $negeri }}</td>
                                        @foreach ($data_tahun as $tahun => $data)
                                            <td>{{ number_format($data[0]->jumlah_pengeluaran) }}</td>
                                            @php
                                                $jumlah_row = $jumlah_row + $data[0]->jumlah_pengeluaran;
                                                $total[$tahun] = $total[$tahun] + $data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @endforeach
                                        <td>{{ number_format($jumlah_row) }}</td>

                                    </tr>
                                @endforeach



                                @php
                                    $jumlah_keseluruhan = 0;
                                @endphp

                                <tr style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left;">Jumlah</td>
                                    @foreach ($grandtotal as $key => $jumlah)
                                        <td>{{ number_format($jumlah, 0) }}</td>
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
