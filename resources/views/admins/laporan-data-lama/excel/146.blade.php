<table>
    <thead style="background-color: #f3ce8f">
        <tr>
            <th>
                {{ $title }} Bagi Tahun
                {{ $tahun }} Hingga Tahun {{ $tahunakhir }}
            </th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody>

        @foreach ($results as $result)
            <tr>
                <td> {{ $loop->iteration }}</td>
                <td>{{ $result->kod_keterangan }}</td>
                @for ($gi = $tahun; $gi <= $tahunakhir + 1; $gi++)
                    <td>
                        @if ($shuttle == 'shuttle4')
                            {{ number_format($result->jualantempatan->papanlapis->$gi, 0) }}
                        @else
                            {{ number_format($result->jualantempatan->kayugergaji->$gi, 0) }}
                        @endif
                    </td>
                @endfor
            </tr>
        @endforeach
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>
            @for ($gi = $tahun; $gi <= $tahunakhir + 1; $gi++)
                <td>
                    {{ number_format($grandtotal->jualantempatan[$gi], 0) }}</td>
            @endfor
        </tr>

    </tbody>
</table>
