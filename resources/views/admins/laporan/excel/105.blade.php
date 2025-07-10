<table>
    <thead style="background-color: #f3ce8f; font-weight: bold;">
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                @if ($data == 'Jumlah Pengeluaran Kayu Gergaji')
                    <th rowspan="1">{{ $data }}</th>
                @else
                    <th rowspan="2">{{ $data }}</th>
                @endif
            @endforeach
        </tr>

        <tr>
            <th>m³</th>
        </tr>

    </thead>
    <tbody>

        @foreach ($datas_formc as $kilang)
                                    @if($kilang->jumlah_pengeluaran > 0)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td style="text-align: left">{{ $kilang->nama_kilang }}</td>
                                            <td style="text-align: left">{{ $kilang->no_ssm }}</td>
                                            <td style="text-align: left">{{ $kilang->no_lesen }}</td>
                                            <td style="text-align: left">{{ $kilang->no_telefon }}</td>
                                            <td style="text-align: left">{{ $kilang->no_faks ?? '-' }}</td>
                                            <td style="text-align: left">{{ $kilang->email }}</td>
                                            <td style="text-align: left">{{ $kilang->alamat_kilang_1 }}</td>
                                            <td style="text-align: left">{{ $kilang->alamat_kilang_2 }}</td>
                                            <td style="text-align: left">{{ $kilang->alamat_kilang_poskod }}</td>
                                            <td style="text-align: left">{{ $kilang->daerah_id }}</td>
                                            <td style="text-align: left">{{ $kilang->negeri_id }}</td>
                                            <td >
                                                {{ Carbon\Carbon::parse($kilang->tarikh_tubuh)->format('d-m-Y') }}
                                            </td>
                                            <td style="text-align: left">
                                                {{ Carbon\Carbon::parse($kilang->tarikh_operasi)->format('d-m-Y') }}
                                            </td>
                                            <td style="text-align: left">{{ $kilang->taraf_syarikat_catatan }}
                                            </td>
                                            <td style="text-align: left">{{ $kilang->status_hak_milik }}</td>

                                            <td style="text-align: right" >
                                                {{ number_format(round($kilang->jumlah_pengeluaran) ?? 0) }}
                                            </td>

                                        </tr>
                                    @endif
                                    @endforeach

    </tbody>
</table>
