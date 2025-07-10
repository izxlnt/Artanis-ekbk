                            <table id="example" class="text-center table-bordered">
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
                                    @php
                                        for ($month_counter = 1; $month_counter <= 12; $month_counter++) {
                                            $jumlah[$month_counter] = 0;
                                        }
                                        $jumlah_keseluruhan = 0;
                                    @endphp

                                    @foreach ($datas as $negeri => $data_bulan)
                                        @php
                                            $jumlah_row = 0;
                                        @endphp
                                        <tr >
                                            <td >{{ $loop->iteration }}</td>
                                            <td >{{ $negeri }}</td>
                                            @foreach ($data_bulan as $bulan => $data)
                                                <td style="text-align: right">
                                                    {{ number_format($data[0]->jumlah_besar_mr + $data[0]->jumlah_besar_wbp, 0) }}</td>
                                                @php
                                                    $jumlah_row += round($data[0]->jumlah_besar_mr + $data[0]->jumlah_besar_wbp);
                                                    $jumlah[$bulan] += round($data[0]->jumlah_besar_mr + $data[0]->jumlah_besar_wbp);
                                                    $jumlah_keseluruhan += round($data[0]->jumlah_besar_mr + $data[0]->jumlah_besar_wbp);
                                                @endphp
                                            @endforeach
                                            <td style="text-align: right">{{ number_format($jumlah_row, 0) }}</td>

                                        </tr>
                                    @endforeach
                                    <tr  style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td >Jumlah (m³)</td>

                                        @for ($month_counter = 1; $month_counter <= 12; $month_counter++)
                                            <td style="text-align: right">{{ number_format($jumlah[$month_counter], 0) }}
                                            </td>
                                        @endfor

                                        <td style="text-align: right">{{ number_format($jumlah_keseluruhan, 0) }}</td>

                                    </tr>
                                </tbody>
                            </table>
