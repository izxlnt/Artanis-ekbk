
                            <table id="example" class="table-bordered" style="width:100%">
                                <thead >
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
                                            $jumlah_row_muka = 0;
                                            $jumlah_row_teras = 0;
                                            $total_jumlah_row_muka = 0;
                                            $total_jumlah_row_teras = 0;

                                        @endphp
                                        <tr >
                                            <td> {{ $loop->iteration }}</td>
                                            <td >{{ $negeri }}</td>
                                            <td >Muka/Face</td>
                                            @foreach ($data as $result)
                                                <td style="text-align: right">
                                                    {{ number_format($result[0]->rekod_veniermuka, 0) }}</td>

                                                    @php
                                                    $jumlah_row_muka = $jumlah_row_muka + $result[0]->rekod_veniermuka;
                                                @endphp
                                            @endforeach
                                            <td style="text-align: right">{{ number_format($jumlah_row_muka) }}</td>
                                        </tr>

                                        <tr >
                                            <td></td>
                                            <td ></td>
                                            <td >Teras/Core</td>
                                            @foreach ($data as $result)
                                                <td style="text-align: right">
                                                    {{ number_format($result[0]->rekod_venierteras, 0) }}</td>
                                                    @php
                                                    $jumlah_row_teras = $jumlah_row_teras + $result[0]->rekod_venierteras;
                                                @endphp
                                            @endforeach
                                            <td style="text-align: right">{{ number_format($jumlah_row_teras) }}</td>
                                        </tr>
                                    @endforeach


                                    <tr  >
                                        <td ></td>
                                        <td >Jumlah (m³)</td>
                                        <td >Muka/Face</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['muka'] as $data)
                                            @php
                                                $total_jumlah_row_muka += $data;
                                            @endphp
                                            <td style="text-align: right">{{ number_format($data, 0) }}</td>
                                        @endforeach
                                        <td style="text-align: right">{{ number_format($total_jumlah_row_muka, 0) }}</td>
                                    </tr>
                                    <tr  >
                                        <td></td>
                                        <td ></td>
                                        <td >Teras/Core</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['teras'] as $data)
                                            @if (is_numeric($data))
                                                @php
                                                    $total_jumlah_row_teras += $data;
                                                @endphp
                                                <td style="text-align: right">{{ number_format($data, 0) }}</td>
                                            @endif
                                        @endforeach
                                        <td style="text-align: right">{{ number_format($total_jumlah_row_teras, 0) }}</td>
                                    </tr>
                                </tbody>
                            </table>
