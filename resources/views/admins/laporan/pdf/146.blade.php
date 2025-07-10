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
    $pembeli_list = $results['pembeli_list'] ?? '';
    $tahun_mula = $results['tahun_mula'] ?? '';
    $tahun_akhir = $results['tahun_akhir'] ?? '';

    $datas = $results['datas'] ?? '';
    $columns = $results['columns'] ?? [];
    $title = $results['title_laporan'] ?? '';
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Dari Tahun
                    {{ $tahun_mula }} Hingga {{ $tahun_akhir }}</div>
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

                                    <tr class="text-right">
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $pembeli->keterangan }}</td>

                                        @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                            <td>{{ number_format($datas[$pembeli->keterangan][$x][0]->jumlah_jualan ?? 0) }}
                                            </td>

                                            @php
                                                $jumlah_row += $datas[$pembeli->keterangan][$x][0]->jumlah_jualan ?? 0;
                                                $jumlah_year[$x] += $datas[$pembeli->keterangan][$x][0]->jumlah_jualan ?? 0;
                                                $jumlah_keseluruhan += $datas[$pembeli->keterangan][$x][0]->jumlah_jualan ?? 0;
                                            @endphp
                                        @endfor

                                        {{-- <td>{{ number_format($jumlah_row) }}</td> --}}
                                    </tr>
                                @endforeach
                                <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left;">Jumlah (m³)</td>

                                    @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                        <td>{{ number_format($jumlah_year[$x]) }}</td>
                                    @endfor

                                    {{-- <td>{{ number_format($jumlah_keseluruhan) }}</td> --}}
                                </tr>
                            </tbody>

                        </table>



                    </div>
                </div>
            </div>


        </div>
    </div>

</div>
