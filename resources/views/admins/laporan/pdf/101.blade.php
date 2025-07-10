<style>
    table {
      border-collapse: collapse;
      font-size: 7px;
    }

    td, th {
      border: 1px solid black;
    }

    th {
        background-color: lightgrey;
    }

</style>
@php
      $shuttle = $results['shuttle'] ?? [];
            $data_shuttles = $results['data_shuttles'] ?? [];
            $data_guna_tenagas = $results['data_guna_tenagas'] ?? [];
            $data_kemasukan_bahans = $results['data_kemasukan_bahans'] ?? [];
            $data_form_d_s = $results['data_form_d_s'] ?? [];


@endphp
<div class="container-fluid">

    <div class="row">
        <div class="col-12">


            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
                    {{ $tahun }}</div>
                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="table-bordered" style="width: 100%;">
                            <thead>
                                <tr>
                                    @foreach ($columns as $data)
                                        @if ($data == 'Guna Tenaga')
                                            <th class="text-center" colspan="6">{{ $data }}</th>
                                        @elseif($data == 'Nilai Harta Tetap Pada Tahun Berakhir')
                                            <th class="text-center" rowspan="2">{{ $data }}</th>
                                        @elseif($data == 'Jumlah Penggunaan Kayu Balak')
                                            <th class="text-center" rowspan="2">{{ $data }}</th>
                                        @elseif($data == 'Jumlah Pengeluaran Kayu Gergaji')
                                            <th class="text-center" rowspan="2">{{ $data }}</th>
                                        @elseif($data == 'Penjualan Kayu Gergaji Eksport')
                                            <th class="text-center" rowspan="2">{{ $data }}</th>
                                        @elseif($data == 'Penjualan Kayu Gergaji Tempatan')
                                            <th class="text-center" rowspan="2">{{ $data }}</th>
                                        @else
                                            <th class="text-center" rowspan="3">{{ $data }}</th>
                                        @endif
                                    @endforeach
                                </tr>
                                <tr>
                                    <th class="text-center" colspan="2">Bumiputera</th>
                                    <th class="text-center" colspan="2">Bukan Bumiputera</th>
                                    <th class="text-center" colspan="2">Bukan Warganegara</th>


                                </tr>
                                <tr class="text-center">
                                    <th>RM</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>L</th>
                                    <th>P</th>
                                    <th>m³</th>
                                    <th>m³</th>
                                    <th>m³</th>
                                    <th>m³</th>
                                </tr class="text-center">

                            </thead>
                            <tbody>


                                @foreach ($data_shuttles as $data)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $data->nama_kilang }}</td>
                                        <td class="text-left">{{ $data->no_ssm }}</td>
                                        <td class="text-left">{{ $data->no_lesen }}</td>
                                        <td class="text-left">{{ $data->no_telefon }}</td>
                                        <td class="text-left">{{ $data->no_faks ?? '-' }}</td>
                                        <td class="text-left">{{ $data->email }}</td>
                                        <td class="text-left">{{ $data->alamat_kilang_1 }}</td>
                                        <td class="text-left">{{ $data->alamat_kilang_2 }}</td>
                                        <td class="text-left">{{ $data->alamat_kilang_poskod }}</td>
                                        <td class="text-left">{{ $data->daerah_id }}</td>
                                        <td class="text-left">{{ $data->negeri_id }}</td>
                                        <td class="text-left">{{ $data->alamat_surat_menyurat_1 }}</td>
                                        <td class="text-left">{{ $data->alamat_surat_menyurat_2 }}</td>
                                        <td class="text-left">{{ $data->alamat_surat_menyurat_poskod }}</td>
                                        <td class="text-left">{{ $data->alamat_surat_menyurat_daerah }}</td>
                                        <td class="text-left">
                                            {{ Carbon\Carbon::parse($data->tarikh_tubuh)->format('d-m-Y') }}
                                        </td>
                                        <td class="text-left">
                                            {{ Carbon\Carbon::parse($data->tarikh_operasi)->format('d-m-Y') }}
                                        </td>
                                        <td class="text-left">{{ $data->taraf_syarikat_catatan }}
                                        </td>
                                        <td class="text-left">{{ $data->status_hak_milik }}</td>
                                        <td class="text-left">
                                            {{ number_format($data->nilai_harta, 2) }}</td>
                                        <td class="text-left">
                                            {{ Carbon\Carbon::parse($data->updated_at)->format('d-m-Y') }}
                                        </td>

                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_wargabumi_lelaki_laporan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_wargabumi_perempuan_laporan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_bukan_wargabumi_lelaki_laporan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_bukan_wargabumi_perempuan_laporan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_asing_lelaki_laporan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_asing_perempuan_laporan, 0) }}</td>

                                        <td class="text-right">{{ number_format($data_kemasukan_bahans[$data->id]->jumlah_penggunaan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_kemasukan_bahans[$data->id]->jumlah_pengeluaran, 0) }}</td>

                                        <td class="text-right">{{ number_format($data_form_d_s[$data->id]->export, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_form_d_s[$data->id]->domestik, 0) }}</td>
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
