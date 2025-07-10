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
            $pembelis = $results['pembelis'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

@endphp


<div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
    {{ $tahun }}</div>
                            <table style="width:100%; font-size:10px">
                                <thead >
                                    <!--th colspan="15">{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th-->

                                    <tr>
                                        @foreach ($columns as $data)
                                            <th>{{ $data }}</th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody >

                                    @php
                                        foreach ($negeri_list as $negeri_name) {
                                            $jumlah_negeri[$negeri_name->negeri] = 0;
                                        }

                                        $jumlah_keseluruhan = 0;
                                    @endphp

                                    @foreach ($datas as $pembeli => $data_pembeli)
                                        @php
                                            $jumlah_row = 0;
                                        @endphp

                                        <tr >
                                            <td >{{ $loop->iteration }}</td>
                                            <td >{{ $pembeli }}</td>
                                            @foreach ($data_pembeli as $negeri => $data)
                                                <td>{{ number_format($data[0]->domestik) }}</td>
                                                @php
                                                    $jumlah_row += $data[0]->domestik;
                                                    $jumlah_negeri[$negeri] += $data[0]->domestik;
                                                    $jumlah_keseluruhan += $data[0]->domestik;
                                                @endphp
                                            @endforeach

                                            <td>{{ number_format($jumlah_row) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr  >
                                        <td></td>
                                        <td> Jumlah (m³)</td>

                                        @foreach ($negeri_list as $nama_negeri)
                                            <td>{{ number_format($jumlah_negeri[$nama_negeri->negeri]) }}</td>
                                        @endforeach

                                        <td>{{ number_format($jumlah_keseluruhan) }}</td>
                                    </tr>
                                </tbody>

                            </table>
