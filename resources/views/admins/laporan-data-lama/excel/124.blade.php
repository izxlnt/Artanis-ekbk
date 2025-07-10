<table>
    <thead>
        <tr>
            <th>{{ $title }} Bagi Tahun
                {{ $tahun }} (m³)</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach
        </tr>
    </thead>
    @foreach ($results as $data)
        @foreach ($data->jumlahpenggunaan as $key => $value)
            @php
                $jumlah_besar[$key] = 0;
                $jumlah_besar_kumpulan = 0;
            @endphp
        @endforeach
    @break
@endforeach
<tbody style="text-align: center">
    @foreach ($kumpulan_kayu as $kayu)
        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>{{ $kayu->singkatan }}</td>
            @foreach ($results as $data)
                @foreach ($data->jumlahpenggunaan as $key => $value)
                    <td></td>
                    @php
                        $jumlah[$key] = 0;
                    @endphp
                @endforeach
            @break
        @endforeach
    </tr>
    @php
        $jumlah_kumpulan = 0;
    @endphp

    @foreach ($results as $data)
        @if (strtolower($data->spesies_kumpulankayu) == strtolower($kayu->singkatan))
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td>{{ $data->spesies_namatempatan }}</td>

                @foreach ($data->jumlahpenggunaan as $key => $value)
                    <td>
                        {{ number_format($value, 0) }}</td>
                    @php
                        $jumlah[$key] += $value ?? 0;
                        $jumlah_besar[$key] += $value ?? 0;
                    @endphp
                @endforeach

                {{-- <td > --}}
                @php
                    $jumlah_kumpulan += $data->jumlahkeseluruhan ?? 0;
                    $jumlah_besar_kumpulan += $data->jumlahkeseluruhan ?? 0;
                @endphp
                {{-- {{ number_format($data->jumlahkeseluruhan ?? 0, 0) }} --}}
                {{-- </td> --}}
            </tr>
        @endif
    @endforeach

    <tr style="background-color: lightgray; font-weight: bold;">
        <td></td>
        <td>Jumlah {{ $kayu->singkatan }} (m³)</td>
        @foreach ($results as $data)
            @foreach ($data->jumlahpenggunaan as $key => $value)
                <td>{{ number_format($jumlah[$key], 0) }}</td>
            @endforeach
        @break
    @endforeach

<tr>
    <td></td>
    <td></td>
    @foreach ($results as $data)
        @foreach ($data->jumlahpenggunaan as $value)
            <td></td>
        @endforeach
    @break
@endforeach
@endforeach
</tbody>
<tfoot>
<tr style="background-color: lightgray; font-weight: bold;">
<td></td>
<td>JUMLAH BESAR (m³)</td>

@foreach ($results as $data)
@foreach ($data->jumlahpenggunaan as $key => $value)
    <td>{{ number_format($jumlah_besar[$key], 0) }}</td>
@endforeach
@break
@endforeach
</tr>
</tfoot>
</table>
