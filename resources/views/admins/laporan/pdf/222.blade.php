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
$tahun_mula = $results['tahun_mula'] ?? [];
$tahun_akhir = $results['tahun_akhir'] ?? [];
$negeri_list = $results['negeri_list'] ?? [];
$datas = $results['datas'] ?? [];
$grandtotal = $results['grandtotal'] ?? [];
@endphp

<div class="text-center card-header" style="text-align: center;">
    {{ $title }} Dari Tahun {{ $tahun_mula }} Hingga {{ $tahun_akhir }}
</div>

<table style="width: 100%; font-size: 15px"  >
    <thead>
        <tr>

        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody style="width: 70%">
        @foreach ($datas as $negeri => $data_negeri)
            @php
                $jumlah_row = 0;
            @endphp

            <tr >
                <td>{{ $loop->iteration }}</td>
                <td> {{ $negeri }}</td>

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

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah</td>
            @foreach ($grandtotal as $jumlah)
            @endforeach
            <td>{{ number_format($jumlah, 0) }}</td>

        </tr>
    </tbody>
</table>
