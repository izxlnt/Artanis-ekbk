<style>
    table {
        border-collapse: collapse;
        font-size: 7px;
    }

    td,
    th {
        border: 1px solid black;
    }

    th {
        background-color: lightgrey;
    }

</style>
@php
 $shuttle = $results['shuttle'] ?? [];
            $datas_formc = $results['datas_formc'] ?? [];
@endphp

<div class="text-center card-header" style="text-align: center;">{{ $title }} Bagi Tahun {{ $tahun }}</div> <br>

                            <table>
                                <thead style="background-color: #f3ce8f; font-weight: bold; font-size:10px">
                                    {{-- <tr>
                                        <th colspan="17">{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
                                    </tr> --}}
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
                                            <td >{{ $kilang->shuttle->nama_kilang }}</td>
                                            <td >{{ $kilang->shuttle->no_ssm }}</td>
                                            <td >{{ $kilang->shuttle->no_lesen }}</td>
                                            <td >{{ $kilang->shuttle->no_telefon }}</td>
                                            <td >{{ $kilang->shuttle->no_faks ?? '-' }}</td>
                                            <td >{{ $kilang->shuttle->email }}</td>
                                            <td >{{ $kilang->shuttle->alamat_kilang_1 }}</td>
                                            <td >{{ $kilang->shuttle->alamat_kilang_2 }}</td>
                                            <td >{{ $kilang->shuttle->alamat_kilang_poskod }}</td>
                                            <td >{{ $kilang->shuttle->daerah_id }}</td>
                                            <td >{{ $kilang->shuttle->negeri_id }}</td>
                                            <td >
                                                {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_tubuh)->format('d-m-Y') }}
                                            </td>
                                            <td >
                                                {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_operasi)->format('d-m-Y') }}
                                            </td>
                                            <td >{{ $kilang->shuttle->taraf_syarikat_catatan }}
                                            </td>
                                            <td >{{ $kilang->shuttle->status_hak_milik }}</td>

                                            <td >
                                                @foreach ($datas_formc as $data)
                                                    @if ($data->shuttle_id == $kilang->shuttle->id)
                                                        {{ number_format($data->jumlah_penggunaan ?? 0, 2) }}
                                                    @endif
                                                @endforeach
                                            </td>

                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
