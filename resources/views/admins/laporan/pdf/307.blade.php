<style>
    table {
      border-collapse: collapse;
      /* font-size: 10px; */
    }

    td, th {
      border: 1px solid black;
      padding: 5px;
    }

    th {
        background-color: lightgrey;
    }

</style>
@php
    $negeri_list = $results['negeri_list'] ?? [];
    $datas = $results['datas'] ?? [];
    $jumlah_setiap_negeri = $results['jumlah_setiap_negeri'] ?? [];
    $columns = $results['columns'] ?? [];
    $title_laporan = $results['title_laporan'] ?? [];
    $tahun = $results['tahun'] ?? [];

@endphp
<div class="container-fluid">

    <div class="row">
        <div class="col-12">



            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title_laporan }} Bagi Tahun
                    {{ $tahun }}</div>
                <div class="card-body">
                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="table-bordered" style="width: 100%;">
                            <thead>
                                <tr style="text-align: center;">

                                    <th>Bil</th>
                                    <th>Negeri</th>
                                    <th>Harta Tetap</th>

                                </tr>
                            </thead>
                            <tbody>

                                @foreach ($negeri_list as $key => $negeri)
                                    <tr>
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: left;">
                                            {{ $negeri->negeri }}
                                        </td>
                                        @php
                                            $jumlah_by_negeri = 0;
                                            foreach ($datas as $jumlah) {
                                                if ($jumlah->negeri == $negeri->negeri) {
                                                    $jumlah_by_negeri = $jumlah->jumlah;
                                                }
                                            }
                                        @endphp
                                        <td style="text-align: right;">
                                            RM {{ number_format($jumlah_by_negeri, 2) }}
                                        </td>
                                    </tr>
                                @endforeach

                                <tr style="background-color: lightgray;">
                                    <td></td>
                                    <td style="text-align: left;"><b>JUMLAH</b></td>
                                    <td style="text-align: right;"><b>RM {{ number_format($jumlah_setiap_negeri, 2) }}</b>
                                    </td>
                                </tr>
                            </tbody>

                        </table>



                    </div>
                </div>
            </div>



        </div>
    </div>




</div>
