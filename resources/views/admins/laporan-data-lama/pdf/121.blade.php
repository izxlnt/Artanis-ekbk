<style>
    table {
    border-collapse: collapse;
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
                <div class="card-body" style="padding-top: 15px;">

                        <table id="example" class="table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    @foreach ($columns as $data)
                                        <th class="text-center" style="border: 1px solid #000 !important;">{{ $data }}</th>
                                    @endforeach
                                </tr>
                            </thead>
                            <tbody>
                                @php
                                    for ($bulan_counter = 1; $bulan_counter <= 12; $bulan_counter++) {
                                        $jumlah_column[$bulan_counter] = 0;
                                    }
                                    $jumlah_keseluruhan = 0;
                                @endphp

                                @foreach ($results as $result)
                                    <tr class="text-center">
                                        <td style="border: 1px solid #000 !important; text-align: center;">{{ $loop->iteration }} </td>
                                        <td style="border: 1px solid #000 !important; text-align: left;">{{ $result->negeri_keterangan }}</td>
                                        @foreach ($result->jumlahpenggunaan as $data)
                                            <td style="border: 1px solid #000 !important; text-align: right;">{{ number_format($data, 0) }}</td>
                                        @endforeach
                                    </tr>
                                @endforeach
                                <tr style="background-color: lightgray; font-weight: bold; width: 10%;">
                                    <td></td>
                                    <td style="border: 1px solid #000 !important; text-align: left;">Jumlah (m³)</td>
                                    @foreach ($grandtotal->jumlahpenggunaan as $total)
                                        <td style="border: 1px solid #000 !important; text-align: right;">{{ number_format($total, 0) }}</td>
                                    @endforeach
                                </tr>

                            </tbody>
                            {{-- <tfoot>
                                <tr style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td class="text-left">Jumlah (m³)</td>
                                    @foreach ($grandtotal->jumlahpenggunaan as $total)
                                        <td class="text-right">{{ number_format($total, 0) }}</td>
                                    @endforeach
                                </tr>
                            </tfoot> --}}
                        </table>



                </div>
            </div>


        </div>
    </div>
</div>
