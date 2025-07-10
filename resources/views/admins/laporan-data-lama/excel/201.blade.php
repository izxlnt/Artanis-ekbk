<table>
    <thead>
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                @if ($data == 'Guna Tenaga')
                    <th colspan="6">{{ $data }}</th>
                @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Jenis')
                    <th colspan="2" rowspan="2">{{ $data }}</th>
                @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan')
                    <th colspan="2" rowspan="2">{{ $data }}</th>
                @elseif($data == 'Jumlah Pengeluaran Venir Mengikut Jenis')
                    <th colspan="2" rowspan="2">{{ $data }}</th>
                @elseif($data == 'Jualan Eksport')
                    <th colspan="2">{{ $data }}</th>
                @elseif($data == 'Jualan Tempatan')
                    <th colspan="2">{{ $data }}</th>
                @else
                    <th rowspan="3">{{ $data }}</th>
                @endif
            @endforeach
        </tr>
        <tr>
            <th colspan="2">Bumiputera</th>
            <th colspan="2">Bukan Bumiputera</th>
            <th colspan="2">Bukan Warganegara</th>

            <th rowspan="2">Penjualan Papan Lapis Eksport</th>
            <th rowspan="2">Penjualan Venir Eksport</th>

            <th rowspan="2">Penjualan Papan Lapis Tempatan</th>
            <th rowspan="2">Penjualan Venir Tempatan</th>
        </tr>
        <tr>
            <th>L</th>
            <th>P</th>
            <th>L</th>
            <th>P</th>
            <th>L</th>
            <th>P</th>

            <th>MR</th>
            <th>WBP</th>

            <th>Nipis</th>
            <th>Tebal</th>

            <th>Muka</th>
            <th>Teras</th>
        </tr>

        <tr>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th>RM</th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
            <th><span style="font-size:25px;">m³</span></th>
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
                <td>{{ number_format($result->rekod_nilaiharta, 2) }}
                </td>
                <td>
                    {{ Carbon\Carbon::parse($result->rekod_modified_on ?? '')->format('d-m-Y') }}
                </td>
                <td>{{ $result->guna_tenaga->sum_wargabumi_l ?? 0 }}
                </td>
                <td>{{ $result->guna_tenaga->sum_wargabumi_p ?? 0 }}
                </td>
                <td>
                    {{ $result->guna_tenaga->sum_wargabukanbumi_l ?? 0 }}</td>
                <td>
                    {{ $result->guna_tenaga->sum_wargabukanbumi_p ?? 0 }}</td>
                <td>{{ $result->guna_tenaga->sum_bukanwarga_l ?? 0 }}
                </td>
                <td>{{ $result->guna_tenaga->sum_bukanwarga_p ?? 0 }}
                </td>
                <td>
                    {{ number_format($result->jumlahstoksemasa, 0) }}
                </td>
                <td>{{ number_format($result->jumlahpenggunaan, 0) }}
                </td>
                <td>
                    {{ number_format($result->jumlahpengeluaran->jumlahmr, 0) }}
                </td>
                <td>
                    {{ number_format($result->jumlahpengeluaran->jumlahwbp, 0) }}
                </td>
                <td>
                    {{ number_format($result->jumlahpengeluaran->nipis, 0) }}
                </td>
                <td>
                    {{ number_format($result->jumlahpengeluaran->tebal, 0) }}
                </td>
                <td>
                    {{ number_format($result->jumlahpengeluaran->muka, 0) }}
                </td>
                <td>
                    {{ number_format($result->jumlahpengeluaran->teras, 0) }}
                </td>
                <td>{{ number_format($result->jumlaheksportlapis, 0) }}
                </td>
                <td>{{ number_format($result->jumlaheksportvenier, 0) }}
                </td>
                <td>{{ number_format($result->jumlahtempatanlapis, 0) }}
                </td>
                <td>{{ number_format($result->jumlahtempatanvenier, 0) }}
                </td>

            </tr>
        @endforeach


    </tbody>
</table>
