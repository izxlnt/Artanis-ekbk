<table id="example" class="table-bordered">
    <thead>
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                @if ($data == 'Guna Tenaga')
                    <th colspan="6">{{ $data }}</th>
                @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Jenis')
                    <th colspan="2" rowspan="2">{{ $data }}</th>
                @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan')
                    <th colspan="2" rowspan="2">{{ $data }}</th>
                @elseif($data == 'Jumlah Pengeluaran Venir Mengikut Jenis')
                    <th colspan="2" rowspan="2">{{ $data }}</th>
                @elseif($data == 'Jualan Eksport')
                    <th colspan="2">{{ $data }}</th>
                @elseif($data == 'Jualan Tempatan')
                    <th colspan="2">{{ $data }}</th>
                @else
                    <th rowspan="3">{{ $data }}</th>
                @endif
            @endforeach
        </tr>
        <tr>
            <th colspan="2">Bumiputera</th>
            <th colspan="2">Bukan Bumiputera</th>
            <th colspan="2">Bukan Warganegara</th>

            <th rowspan="2">Penjualan Papan Lapis Eksport</th>
            <th rowspan="2">Penjualan Venir Eksport</th>

            <th rowspan="2">Penjualan Papan Lapis Tempatan</th>
            <th rowspan="2">Penjualan Venir Tempatan</th>
        </tr>
        <tr>
            <th>L</th>
            <th>P</th>
            <th>L</th>
            <th>P</th>
            <th>L</th>
            <th>P</th>

            <th>MR</th>
            <th>WBP</th>

            <th>Nipis</th>
            <th>Tebal</th>

            <th>Muka</th>
            <th>Teras</th>
        </tr>

        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>RM</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
            <th><span>m³</span></th>
        </tr>

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

                                        <td class="text-right">{{ number_format($data_kemasukan_bahans[$data->id]->baki_stok_kehadapan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_kemasukan_bahans[$data->id]->jumlah_penggunaan, 0) }}</td>

                                        <td class="text-right">{{ number_format($produk_pengeluaran[$data->id]->jumlah_besar_mr, 0) }}</td>
                                        <td class="text-right">{{ number_format($produk_pengeluaran[$data->id]->jumlah_besar_wbp, 0) }}</td>

                                        @if ($produk_pengeluaran[$data->id])
                                        @php
                                            $nipis = $produk_pengeluaran[$data->id]->jumlah_kecil_1_mr + $produk_pengeluaran[$data->id]->jumlah_kecil_1_wbp ;
                                            $tebal = $produk_pengeluaran[$data->id]->jumlah_kecil_2_mr + $produk_pengeluaran[$data->id]->jumlah_kecil_2_wbp ;

                                        @endphp
                                         @endif

                                         <td class="text-right">{{ number_format($nipis, 0) }}</td>
                                         <td class="text-right">{{ number_format($tebal, 0) }}</td>

                                         <td class="text-right">{{ number_format($rekod_muka[$data->id]->rekod_veniermuka, 0) }}</td>
                                        <td class="text-right">{{ number_format($rekod_muka[$data->id]->rekod_venierteras, 0) }}</td>

                                        <td class="text-right">{{ number_format($data_form_d_s[$data->id]->export_papan_lapis, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_form_d_s[$data->id]->export_venier, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_form_d_s[$data->id]->domestik_papan_lapis, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_form_d_s[$data->id]->domestik_venier, 0) }}</td>
                                    </tr>
                                    @endforeach


    </tbody>
</table>
