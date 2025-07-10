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
$columns = $results['columns'] ?? [];
$bulan_senarai = $results['bulan_senarai'] ?? [];
$tahun = $results['tahun'] ?? [];
$datas = $results['datas'] ?? [];
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
                            <thead style="background-color: #f3ce8f;">
                                <tr>
                                    @foreach ($columns as $data)
                                        <th>{{ $data }}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody style="text-align: right">
                                @php
                                    $jumlah_jualan_keseluruhan = 0;
                                @endphp
                                @foreach ($bulan_senarai as $bulan)
                                    @php
                                        $month_counter = $loop->iteration;
                                    @endphp

                                    <tr class="text-right">
                                        <td style="text-align: center">{{ $loop->iteration }}</td>
                                        <td style="text-align: left">{{ $bulan }}</td>
                                        <td>
                                            @foreach ($datas as $data)
                                                @if ($data[0]->bulan == $month_counter)
                                                    {{ number_format($data[0]->domestik) }}
                                                    @php
                                                        $jumlah_jualan_keseluruhan += $data[0]->domestik;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left">Jumlah (m³)</td>
                                    <td>{{ number_format($jumlah_jualan_keseluruhan) }}</td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
