                            <table >
                                <thead>
                                    <tr>
                                        <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
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
                                            $jumlah_row_nipis = 0;
                                            $jumlah_row_wbp = 0;
                                            $total_jumlah_row_nipis = 0;
                                            $total_jumlah_row_tebal = 0;
                                        @endphp
                                        <tr >
                                            <td> {{ $loop->iteration }}</td>
                                            <td >{{ $negeri }}</td>
                                            <td >Nipis</td>
                                            @foreach ($data as $result)
                                            <td style="text-align: right">
                                                {{ number_format($result[0]->jumlah_kecil_1_mr + $result[0]->jumlah_kecil_1_wbp, 0) }}</td>

                                                @php
                                                $jumlah_row_nipis =$jumlah_row_nipis + $result[0]->jumlah_kecil_1_mr + $result[0]->jumlah_kecil_1_wbp;
                                            @endphp
                                        @endforeach
                                            <td style="text-align: right">{{ number_format($jumlah_row_nipis) }}</td>
                                        </tr>

                                        <tr >
                                            <td></td>
                                            <td ></td>
                                            <td >Tebal</td>
                                            @foreach ($data as $result)
                                                <td style="text-align: right">
                                                    {{ number_format($result[0]->jumlah_kecil_2_mr + $result[0]->jumlah_kecil_2_wbp , 0) }}</td>
                                                    @php
                                                    $jumlah_row_wbp = $jumlah_row_wbp + $result[0]->jumlah_kecil_2_mr + $result[0]->jumlah_kecil_2_wbp;
                                                @endphp
                                            @endforeach
                                            <td style="text-align: right">{{ number_format($jumlah_row_wbp) }}</td>
                                        </tr>
                                    @endforeach


                                    <tr  >
                                        <td ></td>
                                        <td >Jumlah (m³)</td>
                                        <td >Nipis</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['nipis'] as $data)
                                        @php
                                            $total_jumlah_row_nipis += $data;
                                        @endphp
                                        <td >{{ number_format($data, 0) }}</td>
                                    @endforeach
                                    <td style="text-align: right">{{ number_format($total_jumlah_row_nipis, 0) }}</td>
                                    </tr>
                                    <tr  >
                                        <td></td>
                                        <td ></td>
                                        <td >Tebal</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['tebal'] as $data)
                                            @if (is_numeric($data))
                                                @php
                                                    $total_jumlah_row_tebal += $data;
                                                @endphp
                                                <td style="text-align: right">{{ number_format($data, 0) }}</td>
                                            @endif
                                        @endforeach
                                        <td style="text-align: right">{{ number_format($total_jumlah_row_tebal, 0) }}</td>
                                    </tr>
                                </tbody>
                            </table>
