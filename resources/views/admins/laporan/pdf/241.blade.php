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

<div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun {{ $tahun }}</div> <br>

                            <table id="example" class="text-center table-bordered" style="width: 100%; font-size:10px">
                                <thead >
                                    <!--th colspan="4">{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th-->
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

                                    @foreach ($datas as $bulan => $data)
                                        <tr >
                                            <td >{{ $loop->iteration }}</td>
                                            <td >
                                                @if($bulan == '1')
                                                Januari
                                                @elseif($bulan == '2')
                                                Februari
                                                @elseif($bulan == '3')
                                                Mac
                                                @elseif($bulan == '4')
                                                April
                                                @elseif($bulan == '5')
                                                Mei
                                                @elseif($bulan == '6')
                                                Jun
                                                @elseif($bulan == '7')
                                                Julai
                                                @elseif($bulan == '8')
                                                Ogos
                                                @elseif($bulan == '9')
                                                September
                                                @elseif($bulan == '10')
                                                Oktober
                                                @elseif($bulan == '11')
                                                November
                                                @else
                                                Disember
                                                @endif
                                            </td>
                                            <td >
                                                {{ number_format($data[0]->domestik_papan_lapis, 0) }}</td>
                                            <td >{{ number_format($data[0]->domestik_venier, 0) }}
                                            </td>
                                            @php
                                                $jumlah_jualan_keseluruhan_papan_lapis += $data[0]->domestik_papan_lapis;
                                                $jumlah_jualan_keseluruhan_venier += $data[0]->domestik_venier;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    <tr  >
                                        <td></td>
                                        <td >Jumlah (m³)</td>
                                        <td>{{ number_format($jumlah_jualan_keseluruhan_papan_lapis) }}</td>
                                        <td>{{ number_format($jumlah_jualan_keseluruhan_venier) }}</td>
                                    </tr>
                                </tbody>
                            </table>
