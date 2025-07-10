
                            <table>
                                <thead>
                                    <tr>
                                        <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
                                    </tr>
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Nilai Harta Tetap Pada Tahun Berakhir')
                                                <th  colspan="1" rowspan="1">{{ $data }}</th>
                                            @else
                                                <th  rowspan="2">{{ $data }}</th>
                                            @endif
                                        @endforeach
                                    </tr>

                                    <tr>

                                        <th >RM</th>


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
                                            <td style="text-align: right">{{ number_format($kilang->shuttle->nilai_harta, 2) }}</td>

                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
