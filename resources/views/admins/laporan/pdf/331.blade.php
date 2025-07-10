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
$negeri_list = $results['negeri_list'] ?? [];
$datas = $results['datas'] ?? [];
$columns = $results['columns'] ?? [];
$title = $results['title_laporan'] ?? [];
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">



            <div class="card">
                <div class="text-center card-header" style="text-align:center;">{{ $title }} Bagi Tahun
                    {{ $tahun }}</div>
                <div class="card-body">
                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="text-center table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    @foreach ($columns as $data)
                                        <th>{{ $data }}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody style="text-align:right;">
                                @php
                                    for ($month_counter = 1; $month_counter <= 12; $month_counter++) {
                                        $jumlah[$month_counter] = 0;
                                    }
                                    $jumlah_keseluruhan = 0;
                                @endphp

                                @foreach ($datas as $negeri => $data_bulan)
                                    @php
                                        $jumlah_row = 0;
                                    @endphp
                                    <tr>
                                        <td style="text-align:center;">{{ $loop->iteration }}</td>
                                        <td style="text-align:left;">{{ $negeri }}</td>
                                        @foreach ($data_bulan as $bulan => $data)
                                            <td>
                                                {{ number_format($data[0]->jumlah_pengeluaran, 0) }}</td>
                                            @php
                                                $jumlah_row += $data[0]->jumlah_pengeluaran;
                                                $jumlah[$bulan] += $data[0]->jumlah_pengeluaran;
                                                $jumlah_keseluruhan += $data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @endforeach
                                        <td>{{ number_format($jumlah_row, 0) }}</td>

                                    </tr>
                                @endforeach
                                <tr style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align:left;">Jumlah (m³)</td>

                                    @for ($month_counter = 1; $month_counter <= 12; $month_counter++)
                                        <td>{{ number_format($jumlah[$month_counter], 0) }}
                                        </td>
                                    @endfor

                                    <td>{{ number_format($jumlah_keseluruhan, 0) }}</td>

                                </tr>
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>



        </div>
    </div>




</div>
