<style>
    table {
        border-collapse: collapse;
        font-size: 7px;
    }

    td,
    th {
        border: 1px solid black;
    }

    th {
        background-color: lightgrey;
    }

</style>
@php
$columns = $results['columns'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
@endphp

<div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun {{ $tahun }}</div> <br>
<table id="example" class="table-bordered" style="width:100%; font-size:10px">

                                <thead >

                                    <tr>
                                        @foreach ($columns as $data)
                                            <th>{{ $data }}</th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
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
                                        <tr >
                                            <td >{{ $loop->iteration }}</td>
                                            <td >{{ $negeri }}</td>
                                            @foreach ($data_bulan as $bulan => $data)
                                                <td >
                                                    {{ number_format($data[0]->jumlah_besar_mr + $data[0]->jumlah_besar_wbp, 0) }}</td>
                                                @php
                                                    $jumlah_row += $data[0]->jumlah_besar_mr + $data[0]->jumlah_besar_wbp;
                                                    $jumlah[$bulan] += $data[0]->jumlah_besar_mr + $data[0]->jumlah_besar_wbp;
                                                    $jumlah_keseluruhan += $data[0]->jumlah_besar_mr + $data[0]->jumlah_besar_wbp;
                                                @endphp
                                            @endforeach
                                            <td >{{ number_format($jumlah_row, 0) }}</td>

                                        </tr>
                                    @endforeach
                                    <tr  style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td >Jumlah (m³)</td>

                                        @for ($month_counter = 1; $month_counter <= 12; $month_counter++)
                                            <td >{{ number_format($jumlah[$month_counter], 0) }}
                                            </td>
                                        @endfor

                                        <td >{{ number_format($jumlah_keseluruhan, 0) }}</td>

                                    </tr>
                                </tbody>
                            </table>
