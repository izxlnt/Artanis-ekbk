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
$datas = $results['datas'] ?? [];
            $negeri_list = $results['negeri_list'] ?? [];
@endphp

<div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
    {{ $tahun }}</div>

<table id="example" class="table-bordered" style= "width:100%; font-size:10px">
    <!--thead>
        <th>
            <!--th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </th>
        <th></th>
    </thead-->
    <thead>


            <th>Bil</th>
            <th>Negeri</th>
            <th>Harta Tetap</th>

    </thead>
    <tbody>

        @foreach ($negeri_list as $key => $negeri)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>
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
                <td>
                    RM {{ number_format($jumlah_by_negeri, 2) }}
                </td>
            </tr>
        @endforeach

        <tr style="background-color: lightgray;">

            @php
                $jumlah_setiap_negeri = 0;

                foreach ($datas as $data) {
                    $jumlah_setiap_negeri = $jumlah_setiap_negeri + $data->jumlah;
                }
            @endphp
            <td></td>
            <td><b>JUMLAH</b></td>
            <td><b>RM
                    {{ number_format($jumlah_setiap_negeri, 2) }}</b>
            </td>
        </tr>
    </tbody>

</table>
