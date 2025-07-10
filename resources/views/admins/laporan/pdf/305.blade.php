
<style>
    table {
      border-collapse: collapse;
      font-size: 10px;
    }

    td, th {
      border: 1px solid black;
    }

    th {
        background-color: lightgrey;
    }

</style>

<div class="container-fluid">

    <div class="row">
        <div class="col-12">


            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun {{ $tahun }}</div>
                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="table-bordered">
                            <thead>
                                <tr>
                                    @foreach ($columns as $data)
                                        @if ($data == 'Jumlah Pengeluaran Kayu Kumai')
                                            <th style="text-align: center;" rowspan="1">{{ $data }}</th>
                                        @else
                                            <th style="text-align: center;" rowspan="2">{{ $data }}</th>
                                        @endif
                                    @endforeach
                                </tr>

                                <tr style="text-align: center;">
                                    <th>m³</th>
                                </tr style="text-align: center;">

                            </thead>
                            <tbody>

                                @foreach ($shuttle as $kilang)
                                <tr class="text-center">
                                    <td>{{ $loop->iteration }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->nama_kilang }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->no_ssm }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->no_lesen }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->no_telefon }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->no_faks ?? '-' }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->email }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->alamat_kilang_1 }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->alamat_kilang_2 }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->alamat_kilang_poskod }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->daerah_id }}</td>
                                    <td class="text-left">{{ $kilang->shuttle->negeri_id }}</td>
                                    <td class="text-left">
                                        {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_tubuh)->format('d-m-Y') }}
                                    </td>
                                    <td class="text-left">
                                        {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_operasi)->format('d-m-Y') }}
                                    </td>
                                    <td class="text-left">{{ $kilang->shuttle->taraf_syarikat_catatan }}
                                    </td>
                                    <td class="text-left">{{ $kilang->shuttle->status_hak_milik }}</td>

                                    <td class="text-right">
                                        @foreach ($datas_formc as $data)
                                            @if ($data->shuttle_id == $kilang->shuttle->id)
                                                {{ number_format($data->jumlah_pengeluaran ?? 0) }}
                                            @endif
                                        @endforeach
                                    </td>

                                </tr>
                            @endforeach

                            </tbody>
                        </table>



                    </div>
                </div>
            </div>


        </div>
    </div>
</div>
