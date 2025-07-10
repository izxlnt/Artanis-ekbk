<table>
    <thead style="background-color: #f3ce8f; font-weight: bold;">
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                @if ($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Jenis')
                    <th colspan="2" rowspan="1">{{ $data }}</th>
                @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan')
                    <th colspan="2" rowspan="1">{{ $data }}</th>
                @elseif($data == 'Jumlah Pengeluaran Papan Venir Mengikut Jenis')
                    <th colspan="2" rowspan="1">{{ $data }}ss</th>
                @else
                    <th rowspan="3">{{ $data }}</th>
                @endif
            @endforeach
        </tr>
        <tr>
            @if ($title == '206')
                <th>Muka</th>
                <th>Teras</th>
            @else
                <th>MR</th>
                <th>WBP</th>
                <th>Nipis</th>
                <th>Tebal</th>
            @endif
        </tr>
        <tr>
            @if ($title == '206')
                <th>m³</th>
                <th>m³</th>
            @else
                <th>m³</th>
                <th>m³</th>
                <th>m³</th>
                <th>m³</th>
            @endif
        </tr>
    </thead>
    <tbody>

        @foreach ($results as $result)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td>{{ $result->rekod_namakilang ?? '' }}</td>
                <td>{{ $result->rekod_nossm ?? '' }}</td>
                <td>{{ $result->rekod_nolesen ?? '' }}</td>
                <td>{{ $result->rekod_notel ?? '' }}</td>
                <td>{{ $result->rekod_nofaks ?? '-' }}</td>
                <td>{{ $result->rekod_email ?? '' }}</td>
                <td>{{ $result->rekod_alamatkilang_jalan1 ?? '' }}
                </td>
                <td>{{ $result->rekod_alamatkilang_jalan2 ?? '' }}
                </td>
                <td>{{ $result->rekod_alamatkilang_poskod ?? '' }}
                </td>
                <td>{{ $result->rekod_daerah ?? ('' ?? '') }}</td>
                <td>{{ $result->rekod_negeri ?? '' }}</td>

                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>

                <td>
                    {{ Carbon\Carbon::parse($result->rekod_tarikhtubuh ?? '')->format('d-m-Y') }}
                </td>
                <td>
                    {{ Carbon\Carbon::parse($result->rekod_tarikhoperasi ?? '')->format('d-m-Y') }}
                </td>
                <td>{{ $result->rekod_tarafsyarikat ?? '' }}</td>
                <td>{{ $result->rekod_statushakmilik ?? '' }}</td>
                @if ($title == '206')
                    <td>
                        {{ number_format($result->jumlahpengeluaran->muka, 0) }}</td>
                    <td>
                        {{ number_format($result->jumlahpengeluaran->teras, 0) }}</td>
                @else
                    <td>
                        {{ number_format($result->jumlahpengeluaran->jumlahmr, 0) }}</td>
                    <td>
                        {{ number_format($result->jumlahpengeluaran->jumlahwbp, 0) }}</td>
                    <td>
                        {{ number_format($result->jumlahpengeluaran->nipis, 0) }}</td>
                    <td>
                        {{ number_format($result->jumlahpengeluaran->tebal, 0) }}</td>
                @endif
            </tr>
        @endforeach


    </tbody>
</table>
