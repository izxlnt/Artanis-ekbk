
                            <table id="example" class="text-center table-bordered" style="width: 100%">
                                <thead >

                                    <tr>
                                        <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
                                    </tr>
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th>{{ $data }}</th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $keterangan_pembeli_key => $data)
                                        @php
                                            $jumlah_keseluruhan = 0;
                                            $total_jualan[$keterangan_pembeli_key] = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                $total_jualan_bulan[$i] = 0;
                                            }
                                        @endphp
                                    @endforeach
                                    @foreach ($datas as $keterangan_pembeli_key => $data)
                                        <tr class="text-right">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $keterangan_pembeli_key }}</td>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <td style="text-align: right">{{ number_format($data[$i][0]->jumlah_jualan ?? 0) }}</td>
                                                @php
                                                    $total_jualan[$keterangan_pembeli_key] += $data[$i][0]->jumlah_jualan ?? 0;
                                                    $total_jualan_bulan[$i] += round($data[$i][0]->jumlah_jualan ?? 0);
                                                @endphp
                                            @endfor
                                            <td style="text-align: right">{{ number_format($total_jualan[$keterangan_pembeli_key]) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td class="text-left">Jumlah (m³)</td>

                                        @for ($i = 1; $i <= 12; $i++)
                                            <td style="text-align: right">{{ number_format($total_jualan_bulan[$i]) }}</td>
                                            @php
                                                $jumlah_keseluruhan += $total_jualan_bulan[$i];
                                            @endphp
                                        @endfor
                                        <td style="text-align: right">{{ number_format($jumlah_keseluruhan) }}</td>
                                    </tr>
                                </tbody>
                            </table>
