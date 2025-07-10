<table>
    <thead style="background-color: #f3ce8f; font-weight: bold;">
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                @if ($data == 'Jumlah Pengeluaran Kayu Kumai')
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

        @foreach ($shuttle as $kilang)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->nama_kilang }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->no_ssm }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->no_lesen }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->no_telefon }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->no_faks ?? '-' }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->email }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->alamat_kilang_1 }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->alamat_kilang_2 }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->alamat_kilang_poskod }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->daerah_id }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->negeri_id }}</td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_tubuh)->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_operasi)->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">{{ $kilang->shuttle->taraf_syarikat_catatan }}
                                            </td>
                                            <td class="text-left">{{ $kilang->shuttle->status_hak_milik }}</td>

                                            <td style="text-align: right">
                                                @foreach ($datas_formc as $data)
                                                    @if ($data->shuttle_id == $kilang->shuttle->id)
                                                        {{ number_format($data->jumlah_pengeluaran ?? 0) }}
                                                    @endif
                                                @endforeach
                                            </td>

                                        </tr>
                                    @endforeach

    </tbody>
</table>
