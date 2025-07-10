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

                            <table id="example" class="text-center table-bordered" style="width:100% ;font-size:10px">
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
                                    @foreach ($datas as $negeri => $data)
                                        <tr >
                                            <td >{{ $loop->iteration }}</td>
                                            <td >{{ $negeri }}</td>
                                            <td>
                                                {{ number_format($data[0]->domestik_papan_lapis) }}
                                                @php
                                                    $jumlah_jualan_keseluruhan_papan_lapis += $data[0]->domestik_papan_lapis;
                                                @endphp
                                            </td>
                                            <td>
                                                {{ number_format($data[0]->domestik_venier) }}
                                                @php
                                                    $jumlah_jualan_keseluruhan_venier += $data[0]->domestik_venier;
                                                @endphp
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr  >
                                        <td></td>
                                        <td >JUMLAH</td>
                                        <td>{{ number_format($jumlah_jualan_keseluruhan_papan_lapis) }}</td>
                                        <td>{{ number_format($jumlah_jualan_keseluruhan_venier) }}</td>
                                    </tr>
                                </tbody>
                            </table>
