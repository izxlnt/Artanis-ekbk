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
            $datas = $results['datas'] ?? [];
            $tahun = $results['tahun'] ?? [];
@endphp
<div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
    {{ $tahun }}</div>

<table style="width: 100%; font-size: 15px"  >
    <thead>
        <tr>
            @foreach ($columns as $data)
                @if ($data == 'Jumlah')
                    <th>{{ $data }} (m³)</th>
                @else
                    <th>{{ $data }}</th>
                @endif
            @endforeach

        </tr>
    </thead>
    <tbody>

        @php
            for ($bulan_counter = 1; $bulan_counter <= 12; $bulan_counter++) {
                $jumlah_column[$bulan_counter] = 0;
            }

            $jumlah_keseluruhan = 0;
        @endphp

        @foreach ($datas as $negeri => $data)
            @php
                $jumlah_m3 = 0;
            @endphp
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td> {{ $negeri }}</td>
                @foreach ($data as $bulan => $data_negeri)
                    <td>
                        {{ number_format($data_negeri[0]->jumlah_penggunaan, 0) }}
                    </td>

                    @php
                        $jumlah_m3 = $jumlah_m3 + $data_negeri[0]->jumlah_penggunaan;
                        $jumlah_column[$bulan] += $data_negeri[0]->jumlah_penggunaan;
                        $jumlah_keseluruhan += $data_negeri[0]->jumlah_penggunaan;
                    @endphp
                @endforeach

                <td>{{ number_format($jumlah_m3, 0) }}</td>

            </tr>
        @endforeach

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>

            @for ($bulan_counter = 1; $bulan_counter <= 12; $bulan_counter++)
                <td>
                    {{ number_format($jumlah_column[$bulan_counter], 0) }}</td>
            @endfor


            <td>{{ number_format($jumlah_keseluruhan, 0) }}</td>
        </tr>
    </tbody>
</table>
