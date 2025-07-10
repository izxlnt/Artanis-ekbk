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
            $pembeli_list = $results['pembeli_list'] ?? [];
            $tahun_mula = $results['tahun_mula'] ?? [];
            $tahun_akhir = $results['tahun_akhir'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

@endphp

<div class="text-center card-header" style="text-align: center;">
    {{ $title }} Dari Tahun {{ $tahun_mula }} Hingga {{ $tahun_akhir }}
</div>

                            <table id="example" class="text-center table-bordered" style="width: 100%; font-size:10px">
                                <thead >

                                    <tr>
                                        @foreach ($columns as $data)
                                            <th>{{ $data }}</th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>

                                    @php
                                        for ($curr_year = $tahun_mula; $curr_year <= $tahun_akhir; $curr_year++) {
                                            $jumlah_year[$curr_year] = 0;
                                        }
                                        $jumlah_keseluruhan = 0;
                                    @endphp

                                    @foreach ($pembeli_list as $pembeli)
                                        @php
                                            $jumlah_row = 0;
                                        @endphp

                                        <tr >
                                            <td >{{ $loop->iteration }}</td>
                                            <td >{{ $pembeli->keterangan }}</td>

                                            @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                                <td>{{ number_format($datas[$pembeli->keterangan][$x][0]->jumlah_jualan ?? 0) }}
                                                </td>

                                                @php
                                                    $jumlah_row += $datas[$pembeli->keterangan][$x][0]->jumlah_jualan ?? 0;
                                                    $jumlah_year[$x] += $datas[$pembeli->keterangan][$x][0]->jumlah_jualan ?? 0;
                                                    $jumlah_keseluruhan += $datas[$pembeli->keterangan][$x][0]->jumlah_jualan ?? 0;
                                                @endphp
                                            @endfor

                                            <td>{{ number_format($jumlah_row) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr  >
                                        <td></td>
                                        <td >Jumlah (m³)</td>

                                        @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                            <td>{{ number_format($jumlah_year[$x]) }}</td>
                                        @endfor

                                        <td>{{ number_format($jumlah_keseluruhan) }}</td>
                                    </tr>
                                </tbody>

                            </table>
