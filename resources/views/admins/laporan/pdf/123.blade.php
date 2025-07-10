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
$tahun = $results['tahun'] ?? [];
$negeri_list = $results['negeri_list'] ?? [];
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
                                    $keseluruhan_johor = 0;
                                    $keseluruhan_kedah = 0;
                                    $keseluruhan_kelantan = 0;
                                    $keseluruhan_melaka = 0;
                                    $keseluruhan_n9 = 0;
                                    $keseluruhan_pahang = 0;
                                    $keseluruhan_perak = 0;
                                    $keseluruhan_perlis = 0;
                                    $keseluruhan_penang = 0;
                                    $keseluruhan_selangor = 0;
                                    $keseluruhan_tganu = 0;
                                    $keseluruhan_kl = 0;
                                    $keseluruhan_kumpulan = 0;
                                @endphp
                                @foreach ($kumpulan_kayu as $kayu)
                                    <tr style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td style="text-align: left">{{ $kayu->singkatan }}</td>
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
                                        $jumlah_johor = 0;
                                        $jumlah_kedah = 0;
                                        $jumlah_kelantan = 0;
                                        $jumlah_melaka = 0;
                                        $jumlah_n9 = 0;
                                        $jumlah_pahang = 0;
                                        $jumlah_perak = 0;
                                        $jumlah_perlis = 0;
                                        $jumlah_penang = 0;
                                        $jumlah_selangor = 0;
                                        $jumlah_tganu = 0;
                                        $jumlah_kl = 0;
                                        $jumlah_kumpulan = 0;
                                    @endphp
                                    @foreach ($datas as $keterangan => $data)
                                        @if ($keterangan == $kayu->singkatan)
                                            @foreach ($data as $nama_species => $species)
                                                @php
                                                    $jumlah_row = 0;
                                                @endphp

                                                @if ($species)
                                                    <tr>
                                                        <td style="text-align: center">{{ $loop->iteration }}</td>
                                                        <td style="text-align: left">{{ $nama_species }}</td>
                                                        @foreach ($species as $negeri => $get_data)
                                                            {{-- {{ dd($species) }} --}}
                                                            <td>

                                                                @if ($negeri == 'Johor')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_johor += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_johor += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'Kedah')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_kedah += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_kedah += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'Kelantan')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_kedah += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_kedah += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'Melaka')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_melaka += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_melaka += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'Negeri Sembilan')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_n9 += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_n9 += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'Pahang')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_pahang += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_pahang += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'Perak')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_perak += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_perak += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'Perlis')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_perlis += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_perlis += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'Pulau Pinang')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_penang += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_penang += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'Selangor')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_selangor += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_selangor += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'Terengganu')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_tganu += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_tganu += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @elseif ($negeri == 'W.P Kuala Lumpur')
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                    @php
                                                                        $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                        $jumlah_kl += $get_data[0]->jumlah_penggunaan;
                                                                        $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                        $keseluruhan_kl += $get_data[0]->jumlah_penggunaan;
                                                                        $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                    @endphp
                                                                @endif
                                                            </td>
                                                        @endforeach
                                                        <td>
                                                            {{ number_format($jumlah_row, 0) }}</td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endif
                                    @endforeach

                                    <tr style="background-color: lightgray; font-weight: bold; text-align: left">
                                        <td></td>
                                        <td style="text-align: left">Jumlah {{ $kayu->singkatan }}</td>
                                        <td>{{ number_format($jumlah_johor, 0) }}</td>
                                        <td>{{ number_format($jumlah_kedah, 0) }}</td>
                                        <td>{{ number_format($jumlah_kelantan, 0) }}</td>
                                        <td>{{ number_format($jumlah_melaka, 0) }}</td>
                                        <td>{{ number_format($jumlah_n9, 0) }}</td>
                                        <td>{{ number_format($jumlah_pahang, 0) }}</td>
                                        <td>{{ number_format($jumlah_perak, 0) }}</td>
                                        <td>{{ number_format($jumlah_perlis, 0) }}</td>
                                        <td>{{ number_format($jumlah_penang, 0) }}</td>
                                        <td>{{ number_format($jumlah_selangor, 0) }}</td>
                                        <td>{{ number_format($jumlah_tganu, 0) }}</td>
                                        <td>{{ number_format($jumlah_kl, 0) }}</td>
                                        <td>{{ number_format($jumlah_kumpulan, 0) }}</td>
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
                                <tr style="background-color: lightgray; font-weight: bold; text-align: left">
                                    <td></td>
                                    <td style="text-align: right">JUMLAH BESAR (m³)</td>

                                    <td>{{ number_format($keseluruhan_johor, 0) }}</td>
                                    <td>{{ number_format($keseluruhan_kedah, 0) }}</td>
                                    <td>{{ number_format($keseluruhan_kelantan, 0) }}</td>
                                    <td>{{ number_format($keseluruhan_melaka, 0) }}</td>

                                    <td>{{ number_format($keseluruhan_n9, 0) }}</td>
                                    <td>{{ number_format($keseluruhan_pahang, 0) }}</td>
                                    <td>{{ number_format($keseluruhan_perak, 0) }}</td>
                                    <td>{{ number_format($keseluruhan_perlis, 0) }}</td>

                                    <td>{{ number_format($keseluruhan_penang, 0) }}</td>
                                    <td>{{ number_format($keseluruhan_selangor, 0) }}</td>
                                    <td>{{ number_format($keseluruhan_tganu, 0) }}</td>
                                    <td>{{ number_format($keseluruhan_kl, 0) }}</td>

                                    <td>{{ number_format($keseluruhan_kumpulan, 0) }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>


                </div>
            </div>


        </div>
    </div>


</div>
