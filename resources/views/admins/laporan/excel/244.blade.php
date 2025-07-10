
                            <table id="example" class="text-center table-bordered">
                                <thead >
                                    <tr>
                                        <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
                                    </tr>
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Jumlah')
                                                <th>{{ $data }} (m³)</th>
                                            @else
                                                <th>{{ $data }}</th>
                                            @endif
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody >

                                    @php
                                        for ($bulan_counter = 1; $bulan_counter <= 12; $bulan_counter++) {
                                            $jumlah_column[$bulan_counter] = 0;
                                        }

                                        $jumlah_keseluruhan = 0;
                                    @endphp

                                    @foreach ($datas as $negeri => $data)
                                        @php
                                            $jumlah_m3 = 0;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td > {{ $negeri }}</td>
                                            @foreach ($data as $bulan => $data_negeri)
                                                <td style="text-align: right">
                                                    {{ number_format($data_negeri[0]->domestik, 0) }}
                                                </td>

                                                @php
                                                    $jumlah_m3 = $jumlah_m3 + $data_negeri[0]->domestik;
                                                    $jumlah_column[$bulan] += $data_negeri[0]->domestik;
                                                    $jumlah_keseluruhan += $data_negeri[0]->domestik;
                                                @endphp
                                            @endforeach

                                            <td style="text-align: right">{{ number_format($jumlah_m3, 0) }}</td>

                                        </tr>
                                    @endforeach

                                    <tr >
                                        <td></td>
                                        <td >Jumlah (m³)</td>

                                        @for ($bulan_counter = 1; $bulan_counter <= 12; $bulan_counter++)
                                            <td style="text-align: right">
                                                {{ number_format($jumlah_column[$bulan_counter], 0) }}</td>
                                        @endfor


                                        <td style="text-align: right">{{ number_format($jumlah_keseluruhan, 0) }}</td>
                                    </tr>
                                </tbody>
                            </table>
