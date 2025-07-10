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
    $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
    $negeri_list = $results['negeri_list'] ?? [];
    $spesis = $results['spesis'] ?? [];
    $datas = $results['datas'] ?? [];
    $columns = $results['columns'] ?? [];
    $title = $results['title_laporan'] ?? '';
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun {{ $tahun }}</div>
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
                                    for ($x = 1; $x <= 12; $x++) {
                                        $jumlah_bulan[$x] = 0;
                                    }

                                    $jumlah_besar = 0;
                                @endphp
                                @foreach ($negeri_list as $negeri)
                                    @php
                                        $jumlah_row = 0;
                                    @endphp
                                    <tr class="text-right">
                                        <td style="text-align: center">{{ $loop->iteration }}</td>
                                        <td style="text-align: left">{{ $negeri->negeri }}</td>

                                        @foreach ($datas as $key => $data)
                                            @if ($key == $negeri->negeri)
                                                @foreach ($data as $bulan => $value)
                                                    <td>{{ number_format($value[0]->jumlah_pengeluaran ?? 0) }}</td>

                                                    @php
                                                        $jumlah_row += $value[0]->jumlah_pengeluaran ?? 0;
                                                        $jumlah_bulan[$bulan] += $value[0]->jumlah_pengeluaran ?? 0;
                                                        $jumlah_besar += $value[0]->jumlah_pengeluaran ?? 0;
                                                    @endphp
                                                @endforeach
                                            @endif
                                        @endforeach



                                        <td>{{ number_format($jumlah_row)}}</td>

                                    </tr>
                                @endforeach

                                <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td  style="text-align: left">Jumlah (m³)</td>
                                    @for ($x = 1; $x <= 12; $x++)
                                        <td>{{ number_format($jumlah_bulan[$x]) }}</td>
                                    @endfor
                                    <td>{{ number_format($jumlah_besar) }}</td>
                                </tr>
                            </tbody>
                        </table>



                    </div>

                </div>

            </div>
        </div>
    </div>
</div>
