<style>
    table {
      border-collapse: collapse;
      /* font-size; 15px; */
    }

    td, th {
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
    $bulan_senarai = $results['bulan_senarai'] ?? '';

    $datas = $results['datas'] ?? '';
    $columns = $results['columns'] ?? [];
    $title = $results['title_laporan'] ?? '';
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="text-center card-header" style="text-align:center;">{{ $title }} Bagi Tahun
                    {{ $tahun }}</div>
                <div class="card-body">
                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="text-center table-bordered" style="width: 100%">
                            @php
                                $jumlah_keseluruhan = 0;
                            @endphp
                            <thead style="background-color: #f3ce8f; font-weight: bold;">
                                <tr>
                                    @foreach ($columns as $data)
                                        <th>{{ $data }}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody style="text-align: right;">
                                @foreach ($bulan_senarai as $key => $bulan)
                                    <tr class="text-right">
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $bulan }}</td>
                                        <td>
                                            @foreach ($datas as $index_bulan => $data)
                                                @if ($index_bulan == $key + 1)
                                                    {{ number_format($data[0]->export ?? 0) }}
                                                    @php
                                                        $jumlah_keseluruhan += $data[0]->export ?? 0;
                                                    @endphp
                                                @endif
                                            @endforeach
                                        </td>
                                    </tr>
                                @endforeach
                                <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left;">Jumlah (m³)</td>
                                    <td>{{ number_format($jumlah_keseluruhan) }}</td>
                                </tr>
                            </tbody>
                        </table>



                    </div>
                </div>
            </div>



        </div>
    </div>

</div>
