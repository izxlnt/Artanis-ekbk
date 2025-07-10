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
    $tahun = $results['tahun'] ?? [];
    $tahun_mula = $results['tahun_mula'] ?? [];
    $tahun_akhir = $results['tahun_akhir'] ?? [];
    $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
    $datas = $results['datas'] ?? [];
    $columns = $results['columns'] ?? [];
    $title = $results['title_laporan'] ?? [];
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">


            <div class="card">
                <div class="text-center card-header" style="text-align:center;">{{ $title }} Dari Tahun
                    {{ $tahun_mula }} Hingga {{ $tahun_akhir }}</div>
                <div class="card-body">
                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="text-center table-bordered" style="width: 100%">
                            <thead style="background-color: #f3ce8f;">
                                <tr>
                                    @foreach ($columns as $data)
                                        <th>{{ $data }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody style="text-align: right;">
                                @php
                                    for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
                                        $jumlah[$x] = 0;
                                        $keseluruhan[$x] = 0;
                                    }
                                    $keseluruhan_kumpulan = 0;
                                @endphp

                                @foreach ($kumpulan_kayu as $kayu)
                                    {{-- tajuk kumpulan --}}
                                    <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td style="text-align: left;">{{ $kayu->singkatan }}</td>
                                        @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                            <td></td>
                                        @endfor
                                        <td></td>
                                    </tr>

                                    @php
                                        for ($x = $tahun_mula; $x <= $tahun_akhir; $x++) {
                                            $jumlah[$x] = 0;
                                        }

                                        $jumlah_kumpulan = 0;
                                    @endphp

                                    {{-- data kumpulan --}}

                                    @foreach ($datas as $keterangan => $data)
                                        @if ($keterangan == $kayu->singkatan)
                                            @foreach ($data as $nama_species => $species)
                                                {{-- {{ dd($species) }} --}}
                                                @php
                                                    $jumlah_row = 0;
                                                @endphp

                                                @if ($species != null)
                                                    <tr class="text-right">
                                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                        <td style="text-align: left;">{{ $nama_species }}</td>
                                                        @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                                            @foreach ($species as $spesis)
                                                                @if ($spesis->tahun == $x)
                                                                    <td>{{ number_format($spesis->jumlah_penggunaan) }}
                                                                    </td>
                                                                    @php
                                                                        $jumlah_row += $spesis->jumlah_penggunaan;

                                                                        $jumlah[$x] += $spesis->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $spesis->jumlah_penggunaan;

                                                                        $keseluruhan[$x] += $spesis->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $spesis->jumlah_penggunaan;
                                                                    @endphp
                                                                @else
                                                                    <td>0</td>
                                                                @endif
                                                            @endforeach
                                                        @endfor
                                                        <td>{{ number_format($jumlah_row) }}</td>
                                                    </tr>
                                                @else
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td style="text-align: left;">Jumlah {{ $kayu->singkatan }}</td>
                                        @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                            <td>{{ number_format($jumlah[$x]) }}</td>
                                        @endfor
                                        <td>{{ number_format($jumlah_kumpulan) }}</td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                            <td></td>
                                        @endfor
                                        <td></td>
                                    </tr>
                                @endforeach
                            </tbody>
                            <tfoot>
                                <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td class="text-left">JUMLAH BESAR </td>

                                    @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                        <td>{{ number_format($keseluruhan[$x]) }}</td>
                                    @endfor

                                    <td>{{ number_format($keseluruhan_kumpulan) }}</td>
                                </tr>
                            </tfoot>
                        </table>

                        {{-- @else

                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $nama_species }}</td>
                                                @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                                                <td>0</td>
                                                @endfor
                                                <td>0</td>
                                            </tr> --}}

                    </div>
                </div>
            </div>


        </div>
    </div>




</div>
