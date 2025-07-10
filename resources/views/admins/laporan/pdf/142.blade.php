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
$tahun = $results['tahun'] ?? '';
$negeri_list = $results['negeri_list'] ?? '';
$datas = $results['datas'] ?? '';
$columns = $results['columns'] ?? [];
$title = $results['title_laporan'] ?? '';
@endphp

<div class="container-fluid">

    <div class="row">
        <div class="col-12">


            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
                    {{ $tahun }}</div>
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
                            <tbody style="text-align: right;">
                                @php
                                    $jumlah_jualan_keseluruhan = 0;
                                @endphp
                                @foreach ($datas as $negeri => $data)
                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $negeri }}</td>
                                        <td>
                                            {{ number_format($data[0]->domestik) }}
                                            @php
                                                $jumlah_jualan_keseluruhan += $data[0]->domestik;
                                            @endphp
                                        </td>
                                    </tr>
                                @endforeach

                                <tr style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td style="text-align: left;">JUMLAH</td>
                                    <td>{{ number_format($jumlah_jualan_keseluruhan) }}</td>
                                </tr>
                            </tbody>

                        </table>



                    </div>
                </div>
            </div>


        </div>
    </div>

</div>
