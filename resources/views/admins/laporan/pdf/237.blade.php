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
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
            $grandtotal = $results['grandtotal'] ?? [];

@endphp

                    <div class="text-center card-header" style="text-align: center;">
                        {{ $title }} Dari Tahun {{ $tahun_mula }} Hingga {{ $tahun_akhir }}
                    </div>
                            <table id="example" class="table-bordered" style="width:100%; font-size:10px">
                                <thead >
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th >{{ $data }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($datas as $negeri => $data)
                                        @php
                                            $jumlah_row_muka = 0;
                                            $jumlah_row_teras = 0;
                                            $total_jumlah_row_muka = 0;
                                            $total_jumlah_row_teras = 0;

                                        @endphp
                                        <tr >
                                            <td> {{ $loop->iteration }}</td>
                                            <td >{{ $negeri }}</td>
                                            <td >Muka/Face</td>
                                            @foreach ($data as $result)
                                                <td >
                                                    {{ number_format($result[0]->rekod_veniermuka, 0) }}</td>

                                                    @php
                                                    $jumlah_row_muka = $jumlah_row_muka + $result[0]->rekod_veniermuka;
                                                @endphp
                                            @endforeach
                                            {{-- <td >{{ number_format($jumlah_row_muka) }}</td> --}}
                                        </tr>

                                        <tr >
                                            <td></td>
                                            <td ></td>
                                            <td >Teras/Core</td>
                                            @foreach ($data as $result)
                                                <td >
                                                    {{ number_format($result[0]->rekod_venierteras, 0) }}</td>
                                                    @php
                                                    $jumlah_row_teras = $jumlah_row_teras + $result[0]->rekod_venierteras;
                                                @endphp
                                            @endforeach
                                            {{-- <td >{{ number_format($jumlah_row_teras) }}</td> --}}
                                        </tr>
                                    @endforeach


                                    <tr  >
                                        <td ></td>
                                        <td >Jumlah (m³)</td>
                                        <td >Muka/Face</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['muka'] as $data)
                                            @php
                                                $total_jumlah_row_muka += $data;
                                            @endphp
                                            <td >{{ number_format($data, 0) }}</td>
                                        @endforeach
                                        {{-- <td >{{ number_format($total_jumlah_row_muka, 0) }}</td> --}}
                                    </tr>
                                    <tr  >
                                        <td></td>
                                        <td ></td>
                                        <td >Teras/Core</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['teras'] as $data)
                                            @if (is_numeric($data))
                                                @php
                                                    $total_jumlah_row_teras += $data;
                                                @endphp
                                                <td >{{ number_format($data, 0) }}</td>
                                            @endif
                                        @endforeach
                                        {{-- <td >{{ number_format($total_jumlah_row_teras, 0) }}</td> --}}
                                    </tr>
                                </tbody>
                            </table>
