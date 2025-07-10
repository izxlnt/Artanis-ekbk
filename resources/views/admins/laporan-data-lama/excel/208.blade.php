<table>
    <thead>
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                @if ($data == 'Nilai Harta Tetap Pada Tahun Berakhir')
                    <th rowspan="2">{{ $data }}</th>
                @else
                    <th rowspan="3">{{ $data }}</th>
                @endif
            @endforeach
        </tr>
        <tr>
            <th>RM</th>
        </tr>
    </thead>
    <tbody>
        @foreach ($results as $result)
            <tr>
                <td>{{ $loop->iteration }}</td>
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
                <td>
                    {{ number_format($result->rekod_nilaiharta, 0) }}</td>
            </tr>
        @endforeach
    </tbody>
</table>
