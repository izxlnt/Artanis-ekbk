
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
                                        $jumlah_jualan_keseluruhan_papan_lapis = 0;
                                        $jumlah_jualan_keseluruhan_venier = 0;
                                    @endphp

                                    @foreach ($datas as $bulan => $data)
                                        <tr >
                                            <td >{{ $loop->iteration }}</td>
                                            <td >
                                                @if($bulan == '1')
                                                Januari
                                                @elseif($bulan == '2')
                                                Februari
                                                @elseif($bulan == '3')
                                                Mac
                                                @elseif($bulan == '4')
                                                April
                                                @elseif($bulan == '5')
                                                Mei
                                                @elseif($bulan == '6')
                                                Jun
                                                @elseif($bulan == '7')
                                                Julai
                                                @elseif($bulan == '8')
                                                Ogos
                                                @elseif($bulan == '9')
                                                September
                                                @elseif($bulan == '10')
                                                Oktober
                                                @elseif($bulan == '11')
                                                November
                                                @else
                                                Disember
                                                @endif
                                            </td>
                                            <td style="text-align: right">
                                                {{ number_format($data[0]->domestik_papan_lapis, 0) }}</td>
                                            <td style="text-align: right">{{ number_format($data[0]->domestik_venier, 0) }}
                                            </td>
                                            @php
                                                $jumlah_jualan_keseluruhan_papan_lapis += $data[0]->domestik_papan_lapis;
                                                $jumlah_jualan_keseluruhan_venier += $data[0]->domestik_venier;
                                            @endphp
                                        </tr>
                                    @endforeach
                                    <tr  >
                                        <td></td>
                                        <td >Jumlah (m³)</td>
                                        <td style="text-align: right">{{ number_format($jumlah_jualan_keseluruhan_papan_lapis) }}</td>
                                        <td style="text-align: right">{{ number_format($jumlah_jualan_keseluruhan_venier) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
