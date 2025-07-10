
                            <table id="example" class="table-bordered">
                                <thead style="background-color: #f3ce8f; font-weight: bold;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Jumlah Pengeluaran Kayu Balak')
                                                <th  rowspan="1">{{ $data }}</th>
                                            @else
                                                <th  rowspan="2">{{ $data }}</th>
                                            @endif
                                        @endforeach
                                    </tr>

                                    <tr >
                                        {{-- <th><span style="font-size:25px;">&#x33A5;</span></th> --}}
                                        <th>m³</th>
                                    </tr >

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
                                                @foreach ($datas_formc as $dataeee)
                                                    @if ($dataeee->shuttle_id == $kilang->shuttle->id)
                                                        {{ number_format($dataeee->jumlah_penggunaan ?? 0, 2) }}
                                                    @endif
                                                @endforeach
                                            </td>

                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>

