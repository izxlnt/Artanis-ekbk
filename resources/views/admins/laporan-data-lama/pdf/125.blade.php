<style>
    table {
        /* border-collapse: collapse; */
        border-spacing: 0;
        font-size: 15px;
    }

    td,
    th {
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
                    {{ $tahun }} Hingga {{ $tahunakhir }} (m³)</div>
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
                            @foreach ($results as $data)
                                @foreach ($data->jumlahpenggunaan as $key => $value)
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
                                    <td></td>
                                    <td class="text-left" style="text-align: left;">{{ $kayu->singkatan }}
                                    </td>
                                    @foreach ($results as $data)
                                        @foreach ($data->jumlahpenggunaan as $key => $value)
                                            <td></td>
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
                                @if (strtolower($data->spesies_kumpulankayu) == strtolower($kayu->singkatan))
                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $data->spesies_namatempatan }}</td>

                                        @foreach ($data->jumlahpenggunaan as $key => $value)
                                            <td style="text-align: right;">
                                                {{ number_format($value, 0) }}</td>
                                            @php
                                                $jumlah[$key] += $value ?? 0;
                                                $jumlah_besar[$key] += $value ?? 0;
                                            @endphp
                                        @endforeach
                                    </tr>
                                @endif
                            @endforeach

                            <tr class="text-bold" style="background-color: lightgray; font-weight: bold;">
                                <td></td>
                                <td style="text-align: left;">Jumlah {{ $kayu->singkatan }} (m³)</td>
                                @foreach ($results as $data)
                                    @foreach ($data->jumlahpenggunaan as $key => $value)
                                        <td style="text-align: right;">{{ number_format($jumlah[$key], 0) }}
                                        </td>
                                    @endforeach
                                @break
                            @endforeach
                        <tr>
                            <td></td>
                            <td></td>
                            @foreach ($results as $data)
                                @foreach ($data->jumlahpenggunaan as $value)
                                    <td></td>
                                @endforeach
                            @break
                        @endforeach
                @endforeach
                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                    <td></td>
                    <td class="text-left">JUMLAH BESAR (m³)</td>

                    @foreach ($results as $data)
                        @foreach ($data->jumlahpenggunaan as $key => $value)
                            <td class="text-right">{{ number_format($jumlah_besar[$key], 0) }}
                            </td>
                        @endforeach
                    @break
                @endforeach
            </tr>
        </tbody>
        {{-- <tfoot>
                <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                    <td></td>
                    <td class="text-left">JUMLAH BESAR (m³)</td>

                    @foreach ($results as $data)
                        @foreach ($data->jumlahpenggunaan as $key => $value)
                            <td class="text-right">{{ number_format($jumlah_besar[$key], 0) }}</td>
                        @endforeach
                    @break
                @endforeach
            </tr>
        </tfoot> --}}
    </table>
</div>
