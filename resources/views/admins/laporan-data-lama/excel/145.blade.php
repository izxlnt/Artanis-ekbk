<table>
    <thead style="background-color: #f3ce8f">
        <tr>
            <th>{{ $title }} Bagi Tahun
                {{ $tahun }}</th>
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
                @for ($i = 0; $i < 12; $i++)
                    <td>
                        @if ($shuttle == 'shuttle4')
                            {{ number_format($result->jualantempatan->papanlapis[$i], 0) }}
                        @else
                            {{ number_format($result->jualantempatan->kayugergaji[$i], 0) }}
                        @endif
                    </td>
                @endfor
                <td>
                    @if ($shuttle == 'shuttle4')
                        {{ number_format($result->jumlahkeseluruhan->papanlapis, 0) }}
                    @else
                        {{ number_format($result->jumlahkeseluruhan->kayugergaji, 0) }}
                    @endif
                </td>
            </tr>
        @endforeach
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>
            @foreach ($total as $data)
                <td>{{ number_format($data->jualantempatan, 0) }}</td>
            @endforeach
            <td>{{ number_format($grandtotal->jualantempatan, 0) }}
            </td>
        </tr>
    </tbody>
</table>
