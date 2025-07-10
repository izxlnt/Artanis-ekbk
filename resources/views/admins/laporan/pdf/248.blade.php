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
$bulan_senarai = $results['bulan_senarai'] ?? [];
$tahun = $results['tahun'] ?? [];
$datas = $results['datas'] ?? [];

@endphp
<div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
    {{ $tahun }}</div>

<table id="example" class="text-center table-bordered" style="width: 100%; font-size:10px">
    <thead>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>
        @php
            $jumlah_jualan_keseluruhan_papan_lapis = 0;
            $jumlah_jualan_keseluruhan_venier = 0;
        @endphp
        @foreach ($bulan_senarai as $bulan)
            @php
                $month_counter = $loop->iteration;
            @endphp

            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $bulan }}</td>
                <td>
                    @foreach ($datas as $data)
                        @if ($data[0]->bulan == $month_counter)
                            {{ number_format($data[0]->export_papan_lapis) }}
                            @php
                                $jumlah_jualan_keseluruhan_papan_lapis += $data[0]->export_papan_lapis;
                            @endphp
                        @endif
                    @endforeach
                </td>
                <td>
                    {{-- {{ $month_counter }} --}}
                    @foreach ($datas as $key => $data)
                        {{-- {{ $data->bulan }} --}}
                        @if ($data[0]->bulan == $month_counter)
                            {{ number_format($data[0]->export_venier) }}
                            @php
                                $jumlah_jualan_keseluruhan_venier += $data[0]->export_venier;
                            @endphp
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        <tr>
            <td></td>
            <td>Jumlah (m³)</td>
            <td>{{ number_format($jumlah_jualan_keseluruhan_papan_lapis) }}</td>
            <td>{{ number_format($jumlah_jualan_keseluruhan_venier) }}</td>
        </tr>
    </tbody>
</table>
