
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
            $kumpulan_kayu = $results['kumpulan_kayu'] ?? [];
            $tahun = $results['tahun'] ?? [];
            $datas = $results['datas'] ?? [];
@endphp

<div class="text-center card-header" style="text-align: center;">
    {{ $title }} Dari Tahun {{ $tahun_mula }} Hingga {{ $tahun_akhir }}
</div>
<table style="width: 100%; font-size:10px">

    <thead style="background-color: #f3ce8f;">
        <!--th colspan="4">{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th-->
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>
        @php
            for ($bulan = $tahun_mula; $bulan <= $tahun_akhir; $bulan++) {
                $jumlah[$bulan] = 0;
                $keseluruhan[$bulan] = 0;
            }
            $keseluruhan_kumpulan = 0;
        @endphp

        @foreach ($kumpulan_kayu as $kayu)
            {{-- tajuk kumpulan --}}
            <tr  style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td >{{ $kayu->singkatan }}</td>
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
                            <tr >
                                <td >{{ $loop->iteration }}</td>
                                <td >{{ $nama_species }}</td>
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

            <tr  style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td >Jumlah {{ $kayu->singkatan }}</td>
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
        <tr  style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td >JUMLAH BESAR </td>

            @for ($x = $tahun_mula; $x <= $tahun_akhir; $x++)
                <td>{{ number_format($keseluruhan[$x]) }}</td>
            @endfor

            <td>{{ number_format($keseluruhan_kumpulan) }}</td>
        </tr>
    </tfoot>
</table>
