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
    $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
    $spesis = $results['spesis'] ?? [];
    $datas = $results['datas'] ?? [];
    $columns = $results['columns'] ?? [];
    $title = $results['title_laporan'] ?? [];
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">


            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
                    {{ $tahun }}</div>
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

                            <tbody style="text-align: right">
                                @php
                                    for ($i = 1; $i < 13; $i++) {
                                        $keseluruhan[$i] = 0;
                                    }
                                    $keseluruhan_kumpulan = 0;
                                @endphp
                                @foreach ($kumpulan_kayu as $kayu)
                                    <tr style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td style="text-align: left;">{{ $kayu->singkatan }}</td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    @php
                                        for ($i = 1; $i < 13; $i++) {
                                            $jumlah[$i] = 0;
                                        }
                                        $jumlah_kumpulan = 0;
                                    @endphp
                                    @foreach ($datas as $keterangan => $data)
                                        @if ($keterangan == $kayu->singkatan)
                                            {{-- {{ dd($data) }} --}}

                                            @foreach ($data as $nama_species => $species)
                                                {{-- {{ dd($species) }} --}}

                                                @php
                                                    $jumlah_row = 0;
                                                @endphp

                                                @if ($species)
                                                    <tr>
                                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                                        <td style="text-align: left;">{{ $nama_species }}</td>
                                                        @forelse ($species as $bulan => $get_data)
                                                            <td class="text-right">
                                                                {{ number_format($get_data[0]->jumlah_penggunaan ?? 0, 0) }}

                                                            </td>
                                                            @php
                                                                $jumlah_row += $get_data[0]->jumlah_penggunaan ?? 0;

                                                                $jumlah[$bulan] += $get_data[0]->jumlah_penggunaan ?? 0;
                                                                $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan ?? 0;

                                                                $keseluruhan[$bulan] += $get_data[0]->jumlah_penggunaan ?? 0;
                                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan ?? 0;
                                                            @endphp
                                                        @empty
                                                            0
                                                        @endforelse
                                                        <td class="text-right">
                                                            {{ number_format($jumlah_row, 0) }}</td>
                                                    </tr>
                                                @else
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td class="text-left">{{ $nama_species }}</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                        <td class="text-right">0</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    <tr class="text-bold" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td style="text-align: left;">Jumlah {{ $kayu->singkatan }}</td>
                                        @for ($i = 1; $i < 13; $i++)
                                            <td class="text-right">{{ number_format($jumlah[$i], 0) }}</td>
                                        @endfor
                                        <td class="text-right">{{ number_format($jumlah_kumpulan, 0) }}</td>
                                    </tr>

                                    <tr>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                @endforeach

                                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left;">JUMLAH BESAR (m³)</td>

                                    @for ($i = 1; $i < 13; $i++)
                                        <td class="text-right">{{ number_format($keseluruhan[$i], 0) }}</td>
                                    @endfor

                                    <td class="text-right">{{ number_format($keseluruhan_kumpulan, 0) }}</td>
                                </tr>
                            </tbody>



                            {{-- <tfoot>
                                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td class="text-left">JUMLAH BESAR (m³)</td>

                                    @for ($i = 1; $i < 13; $i++)
                                        <td class="text-right">{{ number_format($keseluruhan[$i], 0) }}</td>
                                    @endfor

                                    <td class="text-right">{{ number_format($keseluruhan_kumpulan, 0) }}</td>
                                </tr>
                            </tfoot> --}}
                        </table>



                    </div>
                </div>

            </div>
        </div>
    </div>


</div>
