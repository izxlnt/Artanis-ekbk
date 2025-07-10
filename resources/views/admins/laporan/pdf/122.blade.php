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
$columns = $results['columns'] ?? [];
$title_laporan = $results['title_laporan'] ?? '';
$tahun_mula = $results['tahun_mula'] ?? '';
$tahun_akhir = $results['tahun_akhir'] ?? '';
$negeri_list = $results['negeri_list'] ?? [];
$datas = $results['datas'] ?? [];
$negeri_list = $results['negeri_list'] ?? [];
$grandtotal = $results['grandtotal'] ?? [];

@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">



            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Dari Tahun
                    {{ $tahun_mula }} Hingga {{ $tahun_akhir }}</div>
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
                            <tbody style="text-align: right;">
                                @foreach ($datas as $negeri => $data_negeri)
                                    @php
                                        $jumlah_row = 0;
                                    @endphp

                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: left;"> {{ $negeri }}</td>

                                        @foreach ($data_negeri as $tahun => $data)
                                            @php
                                                $jumlah_col = 0;
                                                $total[$tahun] = 0;
                                            @endphp
                                            <td>{{ number_format($data[0]->jumlah_penggunaan, 0) }}</td>
                                            @php
                                                $jumlah_row = $jumlah_row + $data[0]->jumlah_penggunaan;
                                                $total[$tahun] = $total[$tahun] + $data[0]->jumlah_penggunaan;
                                            @endphp
                                        @endforeach

                                        {{-- <td>{{ number_format($jumlah_row, 0) }}</td> --}}

                                    </tr>
                                @endforeach

                                <tr style="background-color: lightgray; font-weight: bold; text-align: right;">
                                    <td></td>
                                    <td style="text-align: left;">Jumlah</td>
                                    @foreach ($grandtotal as $jumlah)
                                        {{-- <td>{{ number_format($jumlah, 0) }}</td> --}}
                                    @endforeach
                                    <td>{{ number_format($jumlah, 0) }}</td>

                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>



        </div>
    </div>




</div>
