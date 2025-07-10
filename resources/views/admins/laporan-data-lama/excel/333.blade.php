<table>
    <thead style="background-color: #f3ce8f;">
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
            <tr class="text-center">
                <td> {{ $loop->iteration }}</td>
                <td class="text-left">{{ $result->kod_keterangan }}</td>
                @for ($gi = 1; $gi <= 13; $gi++)
                    <td class="text-right">
                        {{ number_format($result->jumlahpengeluaran->$gi, 0) }}

                    </td>
                @endfor
            </tr>
        @endforeach
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td class="text-left">Jumlah (m³)</td>
            @for ($gi = 1; $gi <= 13; $gi++)
                <td class="text-right">
                    {{ number_format($grandtotal->jumlahpengeluaran[$gi], 0) }}</td>
            @endfor
        </tr>

    </tbody>
</table>

