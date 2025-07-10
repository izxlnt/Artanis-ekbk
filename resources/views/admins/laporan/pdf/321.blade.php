<style>
    table {
        border-collapse: collapse;
        font-size;
        15px;
    }

    td,
    th {
        border: 1px solid black;
        padding: 5px;
    }

    th {
        background-color: lightgrey;
    }

    .page-break {
        page-break-after: always;
    }

</style>

@php
$negeri_list = $results['negeri_list'] ?? [];
$datas = $results['datas'] ?? [];
$columns = $results['columns'] ?? [];
$title = $results['title_laporan'] ?? [];
$tahun = $results['tahun'] ?? [];
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">



            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
                    {{ $tahun }}</div>
                <div class="card-body">
                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="text-center table-bordered" style="width: 100%;">
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
                                    <tr style="text-align: right;">
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: left;"> {{ $negeri }}</td>
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

                                <tr style="background-color: lightgray; font-weight: bold; text-align: right;">
                                    <td></td>
                                    <td style="text-align: left;">Jumlah (m³)</td>

                                    @for ($bulan_counter = 1; $bulan_counter <= 12; $bulan_counter++)
                                        <td>
                                            {{ number_format($jumlah_column[$bulan_counter], 0) }}</td>
                                    @endfor


                                    <td>{{ number_format($jumlah_keseluruhan, 0) }}</td>
                                </tr>
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>



        </div>
    </div>
</div>
