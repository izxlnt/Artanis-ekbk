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
                <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} Bagi Tahun
                    {{ $tahun }}</div>
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
                            @foreach ($results as $data)
                                @foreach ($data->jumlahpengeluaran as $key => $value)
                                    @php
                                        $jumlah_besar[$key] = 0;
                                        $jumlah_besar_kumpulan = 0;
                                    @endphp
                                @endforeach
                            @break
                        @endforeach
                        <tbody style="text-align: center">
                            @foreach ($kumpulan_kayu as $kayu)
                                <tr style="background-color: lightgray; font-weight: bold;">
                                    <td style="border: 1px solid #000 !important;"></td>
                                    <td style="border: 1px solid #000 !important; text-align:left;">{{ $kayu->singkatan }}</td>
                                    @foreach ($results as $data)
                                        @foreach ($data->jumlahpengeluaran as $key => $value)
                                            <td style="border: 1px solid #000 !important;"></td>
                                            @php
                                                $jumlah[$key] = 0;
                                            @endphp
                                        @endforeach
                                    @break
                                @endforeach
                            </tr>
                            @php
                                $jumlah_kumpulan = 0;
                            @endphp

                            @foreach ($results as $data)
                                @if ($data->spesies_kumpulankayu == $kayu->singkatan)
                                    <tr>
                                        <td style="border: 1px solid #000 !important; text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="border: 1px solid #000 !important; text-align:left;">{{ $data->spesies_namatempatan }}</td>

                                        @foreach ($data->jumlahpengeluaran as $key => $value)
                                            <td style="border: 1px solid #000 !important; text-align:right;">
                                                {{ number_format($value, 0) }}</td>
                                            @php
                                                $jumlah[$key] += $value ?? 0;
                                                $jumlah_besar[$key] += $value ?? 0;
                                            @endphp
                                        @endforeach

                                        {{-- <td style="border: 1px solid #000 !important; text-align:right;"> --}}
                                        @php
                                            $jumlah_kumpulan += $data->jumlahkeseluruhan ?? 0;
                                            $jumlah_besar_kumpulan += $data->jumlahkeseluruhan ?? 0;
                                        @endphp
                                        {{-- {{ number_format($data->jumlahkeseluruhan ?? 0, 0) }} --}}
                                        {{-- </td> --}}
                                    </tr>
                                @endif
                            @endforeach

                            <tr class="text-bold" style="background-color: lightgray; font-weight: bold;">
                                <td style="border: 1px solid #000 !important;"></td>
                                <td style="border: 1px solid #000 !important; text-align:left;">Jumlah {{ $kayu->singkatan }}</td>
                                @foreach ($results as $data)
                                    @foreach ($data->jumlahpengeluaran as $key => $value)
                                        <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah[$key], 0) }}</td>
                                    @endforeach
                                @break
                            @endforeach
                            {{-- <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_kumpulan, 0) }}</td> --}}

                        <tr>
                            <td></td>
                            <td></td>
                            @foreach ($results as $data)
                                @foreach ($data->jumlahpengeluaran as $value)
                                    <td></td>
                                @endforeach
                            @break
                        @endforeach
                        {{-- <td></td> --}}
                @endforeach

                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                    <td></td>
                    <td style="border: 1px solid #000 !important; text-align:left;">JUMLAH BESAR (m³)</td>

                    @foreach ($results as $data)
                        @foreach ($data->jumlahpengeluaran as $key => $value)
                            <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_besar[$key], 0) }}
                            </td>
                        @endforeach
                    @break
                @endforeach

            </tr>
        </tbody>
        {{-- <tfoot>
                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                    <td></td>
                    <td style="border: 1px solid #000 !important; text-align:left;">JUMLAH BESAR (m³)</td>

                    @foreach ($results as $data)
                        @foreach ($data->jumlahpengeluaran as $key => $value)
                            <td style="border: 1px solid #000 !important; text-align:right;">{{ number_format($jumlah_besar[$key], 0) }}</td>
                        @endforeach
                    @break
                @endforeach

            </tr>
        </tfoot> --}}
    </table>
</div>
