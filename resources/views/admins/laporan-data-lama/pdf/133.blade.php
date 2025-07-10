<style>
    table {
    /* border-collapse: collapse; */
    border-spacing: 0;
    font-size: 15px;
    }

    td, th {
    border: 1px solid black;
    padding: 5px;
    }

    th {
        background-color: lightgrey;
    }
</style>

<div class="container-fluid">

    <div class="row">
        <div class="col-12">

            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} Bagi Tahun {{ $tahun }}</div>
                <div class="card-body">


                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="text-center table-bordered" style="border: 1px solid #000 !important;">
                            <thead>
                                <tr>
                                    @foreach ($columns as $data)
                                        <th style="border: 1px solid #000 !important;">{{ $data }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody style="text-align: center">
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
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important; text-align:left;">{{ $kayu->singkatan }}</td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important;"></td>
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

                                    @foreach ($results as $data)
                                        @if ($data->spesies_kumpulankayu == $kayu->singkatan)
                                            @php
                                                $jumlah_row = 0;
                                            @endphp

                                            <tr>
                                                <td style="border: 1px solid #000 !important; text-align:center;">{{ $loop->iteration }}</td>
                                                <td style="border: 1px solid #000 !important; text-align:left;">{{ $data->spesies_namatempatan }}</td>

                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[0], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[0];
                                                    $jumlah_johor += $data->jumlahpengeluaran[0];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[0];

                                                    $keseluruhan_johor += $data->jumlahpengeluaran[0];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[0];
                                                @endphp
                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[1], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[1];
                                                    $jumlah_kedah += $data->jumlahpengeluaran[1];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[1];

                                                    $keseluruhan_kedah += $data->jumlahpengeluaran[1];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[1];
                                                @endphp
                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[2], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[2];
                                                    $jumlah_kelantan += $data->jumlahpengeluaran[2];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[2];

                                                    $keseluruhan_kelantan += $data->jumlahpengeluaran[2];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[2];
                                                @endphp
                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[3], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[3];
                                                    $jumlah_melaka += $data->jumlahpengeluaran[3];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[3];

                                                    $keseluruhan_melaka += $data->jumlahpengeluaran[3];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[3];
                                                @endphp

                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[4], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[4];
                                                    $jumlah_n9 += $data->jumlahpengeluaran[4];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[4];

                                                    $keseluruhan_n9 += $data->jumlahpengeluaran[4];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[4];
                                                @endphp
                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[5], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[5];
                                                    $jumlah_pahang += $data->jumlahpengeluaran[5];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[5];

                                                    $keseluruhan_pahang += $data->jumlahpengeluaran[5];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[5];
                                                @endphp
                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[6], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[6];
                                                    $jumlah_perak += $data->jumlahpengeluaran[6];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[6];

                                                    $keseluruhan_perak += $data->jumlahpengeluaran[6];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[6];
                                                @endphp
                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[7], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[7];
                                                    $jumlah_perlis += $data->jumlahpengeluaran[7];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[7];

                                                    $keseluruhan_perlis += $data->jumlahpengeluaran[7];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[7];
                                                @endphp

                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[8], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[8];
                                                    $jumlah_penang += $data->jumlahpengeluaran[8];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[8];

                                                    $keseluruhan_penang += $data->jumlahpengeluaran[8];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[8];
                                                @endphp
                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[9], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[9];
                                                    $jumlah_selangor += $data->jumlahpengeluaran[9];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[9];

                                                    $keseluruhan_selangor += $data->jumlahpengeluaran[9];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[9];
                                                @endphp
                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[10], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[10];
                                                    $jumlah_tganu += $data->jumlahpengeluaran[10];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[10];

                                                    $keseluruhan_tganu += $data->jumlahpengeluaran[10];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[10];
                                                @endphp
                                                <td style="border: 1px solid #000 !important; text-align:right;">
                                                    {{ number_format($data->jumlahpengeluaran[11], 0) }}</td>
                                                @php
                                                    $jumlah_row += $data->jumlahpengeluaran[11];
                                                    $jumlah_kl += $data->jumlahpengeluaran[11];
                                                    $jumlah_kumpulan += $data->jumlahpengeluaran[11];

                                                    $keseluruhan_kl += $data->jumlahpengeluaran[11];
                                                    $keseluruhan_kumpulan += $data->jumlahpengeluaran[11];
                                                @endphp

                                                <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_row, 0) }}</td>

                                            </tr>
                                        @endif
                                    @endforeach




                                    <tr class="text-bold" style="background-color: lightgray; font-weight: bold;">
                                        <td style="border: 1px solid #000 !important;"></td>
                                        <td style="border: 1px solid #000 !important; text-align:left;">Jumlah {{ $kayu->singkatan }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_johor, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_kedah, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_kelantan, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_melaka, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_n9, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_pahang, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_perak, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_perlis, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_penang, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_selangor, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_tganu, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_kl, 0) }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_kumpulan, 0) }}</td>
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
                                    <td style="border: 1px solid #000 !important;"></td>
                                    <td style="border: 1px solid #000 !important; text-align:left;">JUMLAH BESAR (m³)</td>

                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_johor, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_kedah, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_kelantan, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_melaka, 0) }}</td>

                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_n9, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_pahang, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_perak, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_perlis, 0) }}</td>

                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_penang, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_selangor, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_tganu, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_kl, 0) }}</td>

                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_kumpulan, 0) }}</td>
                                </tr>
                            </tbody>
                            {{-- <tfoot>
                                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="border: 1px solid #000 !important; text-align:left;">JUMLAH BESAR (m³)</td>

                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_johor, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_kedah, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_kelantan, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_melaka, 0) }}</td>

                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_n9, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_pahang, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_perak, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_perlis, 0) }}</td>

                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_penang, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_selangor, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_tganu, 0) }}</td>
                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_kl, 0) }}</td>

                                    <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($keseluruhan_kumpulan, 0) }}</td>
                                </tr>
                            </tfoot> --}}
                        </table>
                    </div>


                </div>
            </div>


        </div>
    </div>


</div>
