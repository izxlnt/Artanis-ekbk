<style>
    table {
      border-collapse: collapse;
      font-size; 15px;
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
    $pembelis = $results['pembelis'] ?? '';
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
                            <thead style="background-color: #f3ce8f; font-weight: bold;">
                                <tr>
                                    @foreach ($columns as $data)
                                        <th>{{ $data }}</th>
                                    @endforeach

                                </tr>
                            </thead>
                            <tbody style="text-align: right;">
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
                                    <tr class="text-right">
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $keterangan_pembeli_key }}</td>
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
                                <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left;">Jumlah (m³)</td>

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
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
