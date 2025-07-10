
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
                                <tbody >
                                    @php
                                        $jumlah_jualan_keseluruhan_papan_lapis = 0;
                                        $jumlah_jualan_keseluruhan_venier = 0;
                                    @endphp
                                    @foreach ($bulan_senarai as $bulan)
                                        @php
                                            $month_counter = $loop->iteration;
                                        @endphp

                                        <tr class="text-right">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $bulan }}</td>
                                            <td style="text-align: right">
                                                @foreach ($datas as $data)
                                                    @if ($data[0]->bulan == $month_counter)
                                                        {{ number_format($data[0]->export_papan_lapis)}}
                                                        @php
                                                            $jumlah_jualan_keseluruhan_papan_lapis += $data[0]->export_papan_lapis;
                                                        @endphp

                                                    @endif
                                                @endforeach
                                            </td>
                                            <td style="text-align: right">
                                                {{-- {{ $month_counter }} --}}
                                                @foreach ($datas as $key => $data)
                                                {{-- {{ $data->bulan }} --}}
                                                    @if ($data[0]->bulan == $month_counter)
                                                        {{ number_format($data[0]->export_venier) }}
                                                        @php
                                                            $jumlah_jualan_keseluruhan_venier += $data[0]->export_venier;
                                                        @endphp
                                                    @endif
                                                @endforeach
                                            </td>
                                        </tr>
                                    @endforeach
                                    <tr >
                                        <td></td>
                                        <td >Jumlah (m³)</td>
                                        <td style="text-align: right">{{ number_format($jumlah_jualan_keseluruhan_papan_lapis) }}</td>
                                        <td style="text-align: right">{{ number_format($jumlah_jualan_keseluruhan_venier) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
