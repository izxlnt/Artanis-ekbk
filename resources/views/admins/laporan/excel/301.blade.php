<table>
    <thead>
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                @if ($data == 'Guna Tenaga')
                    <th colspan="6">{{ $data }}</th>
                @elseif($data == 'Nilai Harta Tetap Pada Tahun Berakhir')
                    <th rowspan="2">{{ $data }}</th>
                @elseif($data == 'Jumlah Penggunaan Kayu Balak')
                    <th rowspan="2">{{ $data }}</th>
                @elseif($data == 'Jumlah Pengeluaran Kayu Gergaji')
                    <th rowspan="2">{{ $data }}</th>
                @elseif($data == 'Penjualan Kayu Gergaji Eksport')
                    <th rowspan="2">{{ $data }}</th>
                @elseif($data == 'Penjualan Kayu Gergaji Tempatan')
                    <th rowspan="2">{{ $data }}</th>
                @else
                    <th rowspan="3">{{ $data }}</th>
                @endif
            @endforeach
        </tr>
        <tr>
            <th colspan="2">Bumiputera</th>
            <th colspan="2">Bukan Bumiputera</th>
            <th colspan="2">Bukan Warganegara</th>


        </tr>
        <tr>
            <th>RM</th>
            <th>L</th>
            <th>P</th>
            <th>L</th>
            <th>P</th>
            <th>L</th>
            <th>P</th>
            {{-- <th><span style="font-size:25px;">&#x33A5;</span></th> --}}
            <th>m³</th>
            <th>m³</th>
            <th>m³</th>
            <th>m³</th>
        </tr>

    </thead>
    <tbody>


        @foreach ($shuttle as $kilang)
        <tr>
            <td>{{ $loop->iteration }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->nama_kilang }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->no_ssm }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->no_lesen }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->no_telefon }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->no_faks ?? '-' }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->email }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->alamat_kilang_1 }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->alamat_kilang_2 }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->alamat_kilang_poskod }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->daerah_id }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->negeri_id }}</td>

            <td style="text-align: left">{{ $kilang->shuttle->alamat_surat_menyurat_1 }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->alamat_surat_menyurat_2 }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->alamat_surat_menyurat_poskod }}</td>
            <td style="text-align: left">{{ $kilang->shuttle->alamat_surat_menyurat_daerah }}</td>

            <td style="text-align: left">
                {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_tubuh)->format('d-m-Y') }}
            </td>
            <td style="text-align: left">
                {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_operasi)->format('d-m-Y') }}
            </td>
            <td style="text-align: left">{{ $kilang->shuttle->taraf_syarikat_catatan }}
            </td>
            <td style="text-align: left">{{ $kilang->shuttle->status_hak_milik }}</td>
            <td style="text-align: right">
                {{ number_format($kilang->shuttle->nilai_harta, 2) }}</td>
            <td style="text-align: right">
                {{ Carbon\Carbon::parse($kilang->shuttle->updated_at)->format('d-m-Y') }}
            </td>




            <td style="text-align: right">
                {{ number_format($data_guna_tenagas[$kilang->id]->pekerja_wargabumi_lelaki_laporan, 0) }}</td>
            <td style="text-align: right">
                {{ number_format($data_guna_tenagas[$kilang->id]->pekerja_wargabumi_perempuan_laporan, 0) }}</td>
            <td style="text-align: right">
                {{ number_format($data_guna_tenagas[$kilang->id]->pekerja_bukan_wargabumi_lelaki_laporan, 0) }}</td>
            <td style="text-align: right">
                {{ number_format($data_guna_tenagas[$kilang->id]->pekerja_bukan_wargabumi_perempuan_laporan, 0) }}
            </td>
            <td style="text-align: right">
                {{ number_format($data_guna_tenagas[$kilang->id]->pekerja_asing_lelaki_laporan, 0) }}</td>
            <td style="text-align: right">
                {{ number_format($data_guna_tenagas[$kilang->id]->pekerja_asing_perempuan_laporan, 0) }}</td>

            <td style="text-align: right">{{ number_format($data_kemasukan_bahans[$kilang->id]->jumlah_penggunaan, 0) }}
            </td>
            <td style="text-align: right">{{ number_format($data_kemasukan_bahans[$kilang->id]->jumlah_pengeluaran, 0) }}
            </td>

            <td style="text-align: right">{{ number_format($data_form_d_s[$kilang->id]->export, 0) }}</td>
            <td style="text-align: right">{{ number_format($data_form_d_s[$kilang->id]->domestik, 0) }}</td>
        </tr>
        @endforeach
    </tbody>
</table>
