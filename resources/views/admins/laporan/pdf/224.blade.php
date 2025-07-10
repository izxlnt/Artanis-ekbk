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
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
@endphp

<div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
    {{ $tahun }}</div>
<table style="width:100%; font-size:10px">

    <thead style="background-color: #f3ce8f;">
        <!--th colspan="15">{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th-->
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach
        </tr>
    </thead>

    <tbody>
        @php
            for ($i = 1; $i < 13; $i++) {
                $keseluruhan[$i] = 0;
            }
            $keseluruhan_kumpulan = 0;
        @endphp
        @foreach ($kumpulan_kayu as $kayu)
            <tr style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td>{{ $kayu->singkatan }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                for ($i = 1; $i < 13; $i++) {
                    $jumlah[$i] = 0;
                }
                $jumlah_kumpulan = 0;
            @endphp
            @foreach ($datas as $keterangan => $data)
                @if ($keterangan == $kayu->singkatan)
                    {{-- {{ dd($data) }} --}}

                    @foreach ($data as $nama_species => $species)
                        {{-- {{ dd($species) }} --}}

                        @php
                            $jumlah_row = 0;
                        @endphp

                        @if ($species)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $nama_species }}</td>
                                @forelse ($species as $bulan => $get_data)
                                    <td>
                                        {{ number_format($get_data[0]->jumlah_penggunaan ?? 0, 0) }}

                                    </td>
                                    @php
                                        $jumlah_row += $get_data[0]->jumlah_penggunaan ?? 0;

                                        $jumlah[$bulan] += $get_data[0]->jumlah_penggunaan ?? 0;
                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan ?? 0;

                                        $keseluruhan[$bulan] += $get_data[0]->jumlah_penggunaan ?? 0;
                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan ?? 0;
                                    @endphp
                                @empty
                                    0
                                @endforelse
                                <td>
                                    {{ number_format($jumlah_row, 0) }}</td>
                            </tr>
                        @else
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $nama_species }}</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                                <td>0</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <tr style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td>Jumlah {{ $kayu->singkatan }}</td>
                @for ($i = 1; $i < 13; $i++)
                    <td>{{ number_format($jumlah[$i], 0) }}</td>
                @endfor
                <td>{{ number_format($jumlah_kumpulan, 0) }}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach

        <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>JUMLAH BESAR (m³)</td>

            @for ($i = 1; $i < 13; $i++)
                <td>{{ number_format($keseluruhan[$i], 0) }}</td>
            @endfor

            <td>{{ number_format($keseluruhan_kumpulan, 0) }}</td>
        </tr>
    </tbody>
</table>
