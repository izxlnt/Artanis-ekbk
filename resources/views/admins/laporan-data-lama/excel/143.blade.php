<table>
    <thead style="background-color: #f3ce8f">
        <tr>
            <th>
                {{ $title }} Bagi Tahun
                {{ $tahun }}
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
                <td>{{ $loop->iteration }}</td>
                <td>{{ $result->negeri_keterangan }}</td>
                @for ($i = 1; $i <= 13; $i++)
                    <td>
                        @if ($title == '43. Jualan Domestik Papan Lapis Mengikut Negeri Dan Bulan')
                            {{ number_format($result->papanlapis->$i->jualantempatan, 0) }}
                        @elseif($title == '44. Jualan Domestik Venir Mengikut Negeri Dan Bulan')
                            {{ number_format($result->venier->$i->jualantempatan, 0) }}
                        @elseif($title == '43. Jualan Domestik Kayu Kumai Mengikut Negeri Dan Bulan')
                            {{ number_format($result->kayukumai->$i->jualantempatan, 0) }}
                        @else
                            {{ number_format($result->kayugergaji->$i->jualantempatan, 0) }}
                        @endif
                    </td>
                @endfor
            </tr>
        @endforeach

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>Jumlah (m³)</td>
            @foreach ($grandtotal->jualantempatan as $total)
                <td>{{ number_format($total, 0) }}</td>
            @endforeach
        </tr>

    </tbody>
</table>
