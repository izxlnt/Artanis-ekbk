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
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];

@endphp

<div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
    {{ $tahun }}</div>
                            <table id="example" class="text-center table-bordered" style="width: 100% ;font-size:10px">
                                <thead >
                                    <!--th colspan="15">{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th-->

                                    <tr>
                                        @foreach ($columns as $data)
                                            <th>{{ $data }}</th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $keterangan_pembeli_key => $data)
                                        @php
                                            $jumlah_keseluruhan = 0;
                                            $total_jualan[$keterangan_pembeli_key] = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                $total_jualan_bulan[$i] = 0;
                                            }
                                        @endphp
                                    @endforeach
                                    @foreach ($datas as $keterangan_pembeli_key => $data)
                                        <tr >
                                            <td >{{ $loop->iteration }}</td>
                                            <td >{{ $keterangan_pembeli_key }}</td>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <td>{{ number_format($data[$i][0]->jumlah_jualan ?? 0) }}</td>
                                                @php
                                                    $total_jualan[$keterangan_pembeli_key] += $data[$i][0]->jumlah_jualan ?? 0;
                                                    $total_jualan_bulan[$i] += round($data[$i][0]->jumlah_jualan ?? 0);
                                                @endphp
                                            @endfor
                                            <td>{{ number_format($total_jualan[$keterangan_pembeli_key]) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr>
                                        <td></td>
                                        <td >Jumlah (m³)</td>

                                        @for ($i = 1; $i <= 12; $i++)
                                            <td>{{ number_format($total_jualan_bulan[$i]) }}</td>
                                            @php
                                                $jumlah_keseluruhan += $total_jualan_bulan[$i];
                                            @endphp
                                        @endfor
                                        <td>{{ number_format($jumlah_keseluruhan) }}</td>
                                    </tr>
                                </tbody>
                            </table>
