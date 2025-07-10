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
    $form_b = $results['form_b'] ?? [];
    $guna_tenaga = $results['guna_tenaga'] ?? [];
    $datas_formc = $results['datas_formc'] ?? [];
    $datas_formd = $results['datas_formd'] ?? [];
    $tahun = $results['tahun'] ?? [];
    $columns = $results['columns'] ?? [];

@endphp
<div class="container-fluid">

    <div class="row">
        <div class="col-12">


            <div class="card">
                <div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun
                    {{ $tahun }}</div>
                <div class="card-body">

                    <div class="table-responsive" style="padding-top: 15px;">
                        <table id="example" class="table-bordered">
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


                                @foreach ($shuttle as $kilang)
                                    <tr class="text-center">
                                        <td style="text-align: center;">{{ $loop->iteration }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->nama_kilang }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->no_ssm }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->no_lesen }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->no_telefon }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->no_faks ?? '-' }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->email }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->alamat_kilang_1 }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->alamat_kilang_2 }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->alamat_kilang_poskod }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->daerah_id }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->negeri_id }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->alamat_surat_menyurat_1 }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->alamat_surat_menyurat_2 }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->alamat_surat_menyurat_poskod }}</td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->alamat_surat_menyurat_daerah }}</td>
                                        <td style="text-align: left;">
                                            {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_tubuh)->format('d-m-Y') }}
                                        </td>
                                        <td style="text-align: left;">
                                            {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_operasi)->format('d-m-Y') }}
                                        </td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->taraf_syarikat_catatan }}
                                        </td>
                                        <td style="text-align: left;">{{ $kilang->shuttle->status_hak_milik }}</td>
                                        <td style="text-align: left;">
                                            {{ number_format($kilang->shuttle->nilai_harta, 2) }}</td>
                                        <td style="text-align: left;">
                                            {{ Carbon\Carbon::parse($kilang->shuttle->updated_at)->format('d-m-Y') }}
                                        </td>

                                        @php

                                            $bumi_l = 0;
                                            $bumi_p = 0;

                                            $non_bumi_l = 0;
                                            $non_bumi_p = 0;

                                            $non_warga_l = 0;
                                            $non_warga_p = 0;

                                            if ($form_b->count() != 0) {
                                                foreach ($form_b as $borang_b) {
                                                    if ($borang_b->shuttle_id == $kilang->shuttle->id) {
                                                        foreach ($guna_tenaga as $workload) {
                                                            if ($workload->formbs_id == $borang_b->id) {
                                                                //wargabumi
                                                                if ($workload->pekerja_wargabumi_lelaki_cleaning != 0) {
                                                                    $bumi_l = $bumi_l + $workload->pekerja_wargabumi_lelaki_cleaning;
                                                                } else {
                                                                    $bumi_l = $bumi_l + $workload->pekerja_wargabumi_lelaki;
                                                                }

                                                                if ($workload->pekerja_wargabumi_perempuan_cleaning != 0) {
                                                                    $bumi_p = $bumi_p + $workload->pekerja_wargabumi_perempuan_cleaning;
                                                                } else {
                                                                    $bumi_p = $bumi_p + $workload->pekerja_wargabumi_perempuan;
                                                                }

                                                                //bukan wargabumi
                                                                if ($workload->pekerja_bukan_wargabumi_lelaki_cleaning != 0) {
                                                                    $non_bumi_l = $non_bumi_l + $workload->pekerja_bukan_wargabumi_lelaki_cleaning;
                                                                } else {
                                                                    $non_bumi_l = $non_bumi_l + $workload->pekerja_bukan_wargabumi_lelaki;
                                                                }

                                                                if ($workload->pekerja_bukan_wargabumi_perempuan_cleaning != 0) {
                                                                    $non_bumi_p = $non_bumi_p + $workload->pekerja_bukan_wargabumi_perempuan_cleaning;
                                                                } else {
                                                                    $non_bumi_p = $non_bumi_p + $workload->pekerja_bukan_wargabumi_perempuan;
                                                                }

                                                                //bukan warganegara
                                                                if ($workload->pekerja_asing_lelaki_cleaning != 0) {
                                                                    $non_warga_l = $non_warga_l + $workload->pekerja_asing_lelaki_cleaning;
                                                                } else {
                                                                    $non_warga_l = $non_warga_l + $workload->pekerja_asing_lelaki;
                                                                }

                                                                if ($workload->pekerja_asing_perempuan_cleaning != 0) {
                                                                    $non_warga_p = $non_warga_p + $workload->pekerja_asing_perempuan_cleaning;
                                                                } else {
                                                                    $non_warga_p = $non_warga_p + $workload->pekerja_asing_perempuan;
                                                                }
                                                            }
                                                        }
                                                    }
                                                }
                                            }

                                        @endphp

                                        <td style="text-align: right;">{{ number_format($bumi_l, 0) }}</td>
                                        <td style="text-align: right;">{{ number_format($bumi_p, 0) }}</td>
                                        <td style="text-align: right;">{{ number_format($non_bumi_l, 0) }}</td>
                                        <td style="text-align: right;">{{ number_format($non_bumi_p, 0) }}</td>
                                        <td style="text-align: right;">{{ number_format($non_warga_l, 0) }}</td>
                                        <td style="text-align: right;">{{ number_format($non_warga_p, 0) }}</td>


                                        @php
                                            $jumlah_penggunaan = 0;
                                            $jumlah_pengeluaran = 0;

                                            $export = 0;
                                            $domestik = 0;
                                        @endphp

                                        @foreach ($datas_formc as $data_c)
                                            @if ($data_c->shuttle_id == $kilang->shuttle->id)
                                                @php
                                                    $jumlah_penggunaan += $data_c->jumlah_penggunaan;
                                                    $jumlah_pengeluaran += $data_c->jumlah_pengeluaran;
                                                @endphp
                                            @endif
                                        @endforeach

                                        <td style="text-align: right;">{{ number_format($jumlah_penggunaan, 0) }}</td>
                                        <td style="text-align: right;">{{ number_format($jumlah_pengeluaran, 0) }}</td>

                                        @foreach ($datas_formd as $data_d)
                                            @if ($data_c->shuttle_id == $kilang->shuttle->id)
                                                @php
                                                    $export += $data_d->export;
                                                    $domestik += $data_d->domestik;
                                                @endphp
                                            @endif
                                        @endforeach

                                        <td style="text-align: right;">{{ number_format($export, 0) }}</td>
                                        <td style="text-align: right;">{{ number_format($domestik, 0) }}</td>

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
