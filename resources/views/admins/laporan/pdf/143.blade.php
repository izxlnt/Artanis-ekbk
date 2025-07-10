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
$tahun = $results['tahun'] ?? '';
$negeri_list = $results['negeri_list'] ?? '';
$datas = $results['datas'] ?? '';
$columns = $results['columns'] ?? [];
$title = $results['title_laporan'] ?? '';
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
                                            <th>{{ $data }} (<span style="font-size:20px;">&#x33A5;</span>)</th>
                                        @else
                                            <th>{{ $data }}</th>
                                        @endif
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody style="text-align: right">

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
                                        <td style="text-align: center">{{ $loop->iteration }}</td>
                                        <td style="text-align: left"> {{ $negeri }}</td>
                                        @foreach ($data as $bulan => $data_negeri)
                                            <td>
                                                {{ number_format($data_negeri[0]->domestik, 0) }}
                                            </td>

                                            @php
                                                $jumlah_m3 = $jumlah_m3 + round($data_negeri[0]->domestik);
                                                $jumlah_column[$bulan] += round($data_negeri[0]->domestik);
                                                $jumlah_keseluruhan += round($data_negeri[0]->domestik);
                                            @endphp
                                        @endforeach

                                        <td>{{ number_format($jumlah_m3, 0) }}</td>

                                    </tr>
                                @endforeach

                                <tr style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left">Jumlah (m³)</td>

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
