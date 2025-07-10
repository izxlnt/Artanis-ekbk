                            <table >
                                <thead>
                                    <tr>
                                        <th>{{ strtoupper($title) }} DARI TAHUN
                                            {{ $tahun_mula }} HINGGA {{ $tahun_akhir }}</th>
                                    </tr>
                                    <tr>

                                        @foreach ($columns as $data)
                                            <th >{{ $data }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($datas as $negeri => $data)
                                        @php
                                            $jumlah_row_mr = 0;
                                            $jumlah_row_wbp = 0;
                                            $total_jumlah_row_mr = 0;
                                            $total_jumlah_row_wbp = 0;

                                        @endphp
                                        <tr >
                                            <td> {{ $loop->iteration }}</td>
                                            <td >{{ $negeri }}</td>
                                            <td >MR</td>
                                            @foreach ($data as $result)
                                                <td style="text-align: right">
                                                    {{ number_format($result[0]->jumlah_besar_mr, 0) }}</td>

                                                    @php
                                                    $jumlah_row_mr = $jumlah_row_mr + $result[0]->jumlah_besar_mr;
                                                @endphp
                                            @endforeach
                                            <td style="text-align: right">{{ number_format($jumlah_row_mr) }}</td>
                                        </tr>

                                        <tr >
                                            <td></td>
                                            <td ></td>
                                            <td >WBP</td>
                                            @foreach ($data as $result)
                                                <td style="text-align: right">
                                                    {{ number_format($result[0]->jumlah_besar_wbp, 0) }}</td>
                                                    @php
                                                    $jumlah_row_wbp = $jumlah_row_wbp + $result[0]->jumlah_besar_wbp;
                                                @endphp
                                            @endforeach
                                            <td style="text-align: right">{{ number_format($jumlah_row_wbp) }}</td>
                                        </tr>
                                    @endforeach


                                    <tr  >
                                        <td ></td>
                                        <td >Jumlah (m³)</td>
                                        <td >MR</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['mr'] as $data)
                                            @php
                                                $total_jumlah_row_mr += $data;
                                            @endphp
                                            <td style="text-align: right">{{ number_format($data, 0) }}</td>
                                        @endforeach
                                        <td style="text-align: right">{{ number_format($total_jumlah_row_mr, 0) }}</td>
                                    </tr>
                                    <tr  >
                                        <td></td>
                                        <td ></td>
                                        <td >WBP</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['wbp'] as $data)
                                            @if (is_numeric($data))
                                                @php
                                                    $total_jumlah_row_wbp += $data;
                                                @endphp
                                                <td style="text-align: right">{{ number_format($data, 0) }}</td>
                                            @endif
                                        @endforeach
                                        <td style="text-align: right">{{ number_format($total_jumlah_row_wbp, 0) }}</td>
                                    </tr>


                                </tbody>
                            </table>

