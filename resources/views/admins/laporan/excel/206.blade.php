
                            <table id="example" class="table-bordered">
                                <thead>
                                    <tr>
                                        <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
                                    </tr>
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Jumlah Pengeluaran Venir Mengikut Jenis')
                                                <th  colspan="2" rowspan="1">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan')
                                                <th  colspan="2" rowspan="1">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Papan Venir Mengikut Jenis')
                                                <th  colspan="2" rowspan="1">{{ $data }}</th>
                                            @else
                                                <th  rowspan="3">{{ $data }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>


                                            <th >Muka</th>
                                            <th >Teras</th>

                                    </tr>
                                    <tr>


                                            <th >m³</th>
                                            <th >m³</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($shuttle as $kilang)
                                        <tr >
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
                                            <td style="text-align: left">{{ $kilang->shuttle->alamat_surat_menyurat_1 }}
                                            </td>
                                            <td style="text-align: left">{{ $kilang->shuttle->alamat_surat_menyurat_2 }}
                                            </td>
                                            <td style="text-align: left">
                                                {{ $kilang->shuttle->alamat_surat_menyurat_poskod }}</td>
                                            <td style="text-align: left">
                                                {{ $kilang->shuttle->alamat_surat_menyurat_daerah }}</td>
                                            <td style="text-align: left">
                                                {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_tubuh)->format('d-m-Y') }}
                                            </td>
                                            <td style="text-align: left">
                                                {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_operasi)->format('d-m-Y') }}
                                            </td>
                                            <td style="text-align: left">{{ $kilang->shuttle->taraf_syarikat_catatan }}
                                            </td>
                                            <td style="text-align: left">{{ $kilang->shuttle->status_hak_milik }}</td>

                                            @php
                                            $jumlah_penggunaan = 0;
                                            $baki_stok_kehadapan = 0;
                                            $jumlah_besar_mr = 0;
                                            $jumlah_besar_wbp = 0;
                                            $export_papan_lapis = 0;
                                            $export_venier = 0;
                                            $domestik_papan_lapis = 0;
                                            $domestik_venier = 0;


                                            $export = 0;
                                            $domestik = 0;
                                        @endphp

                                            @foreach ($rekod_muka as $jenis)
                                                @if ($jenis->shuttle_id == $kilang->shuttle->id)
                                                    @php
                                                        $muka = $jenis->rekod_veniermuka ;
                                                        $teras = $jenis->rekod_venierteras ;

                                                    @endphp
                                                @endif
                                            @endforeach

                                            <td style="text-align: right">{{ number_format($muka, 0) }}</td>
                                            <td style="text-align: right">{{ number_format($teras, 0) }}</td>
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
