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
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];
@endphp
<div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun {{ $tahun }}</div> <br>

<table style="width:100%; font-size:10px">
                                <thead>
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th >{{ $data }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($datas as $negeri => $data)
                                        @php
                                            $jumlah_row_mr = 0;
                                            $jumlah_row_wbp = 0;
                                            $total_jumlah_row_mr = 0;
                                            $total_jumlah_row_wbp = 0;
                                        @endphp
                                        <tr >
                                            <td> {{ $loop->iteration }}</td>
                                            <td >{{ $negeri }}</td>
                                            <td >MR</td>
                                            @foreach ($data as $result)
                                                <td >
                                                    {{ number_format($result[0]->jumlah_besar_mr, 0) }}</td>

                                                @php
                                                    $jumlah_row_mr = $jumlah_row_mr + $result[0]->jumlah_besar_mr;
                                                @endphp
                                            @endforeach
                                            <td >{{ number_format($jumlah_row_mr) }}</td>
                                        </tr>

                                        <tr >
                                            <td></td>
                                            <td ></td>
                                            <td >WBP</td>
                                            @foreach ($data as $result)
                                                <td >
                                                    {{ number_format($result[0]->jumlah_besar_wbp, 0) }}</td>
                                                @php
                                                    $jumlah_row_wbp = $jumlah_row_wbp + $result[0]->jumlah_besar_wbp;
                                                @endphp
                                            @endforeach
                                            <td >{{ number_format($jumlah_row_wbp) }}</td>
                                        </tr>
                                    @endforeach


                                    <tr  >
                                        <td ></td>
                                        <td >Jumlah (m³)</td>
                                        <td >MR</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['mr'] as $data)
                                            @php
                                                $total_jumlah_row_mr += $data;
                                            @endphp
                                            <td >{{ number_format($data, 0) }}</td>
                                        @endforeach
                                        <td >{{ number_format($total_jumlah_row_mr, 0) }}</td>
                                    </tr>
                                    <tr  >
                                        <td></td>
                                        <td ></td>
                                        <td >WBP</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['wbp'] as $data)
                                            @if (is_numeric($data))
                                                @php
                                                    $total_jumlah_row_wbp += $data;
                                                @endphp
                                                <td >{{ number_format($data, 0) }}</td>
                                            @endif
                                        @endforeach
                                        <td >{{ number_format($total_jumlah_row_wbp, 0) }}</td>
                                    </tr>

                                </tbody>
                            </table>
