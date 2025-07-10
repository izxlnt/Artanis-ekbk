<table id="example" class="text-center table-bordered" style="width: 100%">
    @php
        $jumlah_keseluruhan = 0;
    @endphp
    <thead style="background-color: #f3ce8f; font-weight: bold;">
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach

        </tr>
    </thead>
    <tbody>

        @foreach ($negeri_list as $negeri)
            <tr class="text-right">
                <td class="text-center">{{ $loop->iteration }}</td>
                <td class="text-left">{{ $negeri->negeri }}</td>
                <td style="text-align: right">
                    @foreach ($datas as $key => $data)
                        @if ($key == $negeri->negeri)
                            {{ number_format($data[0]->export ?? 0) }}
                            @php
                                $jumlah_keseluruhan += $data[0]->export ?? 0;
                            @endphp
                        @endif
                    @endforeach
                </td>
            </tr>
        @endforeach
        <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td class="text-left">Jumlah (m³)</td>
            <td style="text-align: right">{{ number_format($jumlah_keseluruhan) }}</td>
        </tr>
    </tbody>
</table>
