
                            <table id="example" class="text-center table-bordered">
                                <thead >
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
                                    @foreach ($datas as $negeri => $data)
                                        <tr >
                                            <td >{{ $loop->iteration }}</td>
                                            <td >{{ $negeri }}</td>
                                            <td style="text-align: right">
                                                {{ number_format($data[0]->domestik_papan_lapis) }}
                                                @php
                                                    $jumlah_jualan_keseluruhan_papan_lapis += $data[0]->domestik_papan_lapis;
                                                @endphp
                                            </td>
                                            <td style="text-align: right">
                                                {{ number_format($data[0]->domestik_venier) }}
                                                @php
                                                    $jumlah_jualan_keseluruhan_venier += $data[0]->domestik_venier;
                                                @endphp
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr  >
                                        <td></td>
                                        <td >JUMLAH</td>
                                        <td style="text-align: right">{{ number_format($jumlah_jualan_keseluruhan_papan_lapis) }}</td>
                                        <td style="text-align: right">{{ number_format($jumlah_jualan_keseluruhan_venier) }}</td>
                                    </tr>
                                </tbody>
                                <tfoot>

                                </tfoot>
                            </table>
