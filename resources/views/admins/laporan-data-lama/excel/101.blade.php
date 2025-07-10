<table>
    <thead>
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        @if ($shuttle == 'shuttle3')
            <tr>
                @foreach ($columns as $data)
                    @if ($data == 'Guna Tenaga')
                        <th colspan="6">{{ $data }}</th>
                    @elseif($data == 'Nilai Harta Tetap Pada Tahun Berakhir')
                        <th rowspan="2">{{ $data }}</th>
                    @elseif($data == 'Jumlah Penggunaan Kayu Balak')
                        <th rowspan="2">{{ $data }}</th>
                    @elseif($data == 'Jumlah Pengeluaran Kayu Gergaji')
                        <th rowspan="2">{{ $data }}</th>
                    @elseif($data == 'Penjualan Kayu Gergaji Eksport')
                        <th rowspan="2">{{ $data }}</th>
                    @elseif($data == 'Penjualan Kayu Gergaji Tempatan')
                        <th rowspan="2">{{ $data }}</th>
                    @else
                        <th rowspan="3">{{ $data }}</th>
                    @endif
                @endforeach
            </tr>
            <tr>
                <th colspan="2">Bumiputera</th>
                <th colspan="2">Bukan Bumiputera</th>
                <th colspan="2">Bukan Warganegara</th>

            </tr>
            <tr>
                <th>RM</th>
                <th>L</th>
                <th>P</th>
                <th>L</th>
                <th>P</th>
                <th>L</th>
                <th>P</th>
                <th>m³</th>
                <th>m³</th>
                <th>m³</th>
                <th>m³</th>
            </tr>
        @endif
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
                <td>{{ $result->rekod_alamatkilang_jalan1 ?? '' }}</td>
                <td>{{ $result->rekod_alamatkilang_jalan2 ?? '' }}</td>
                <td>{{ $result->rekod_alamatkilang_poskod ?? '' }}</td>
                <td>{{ $result->rekod_daerah ?? ('' ?? '') }}</td>
                <td>{{ $result->rekod_negeri ?? '' }}</td>

                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>
                <td>N/A</td>

                <td>
                    {{ Carbon\Carbon::parse($result->rekod_tarikhtubuh ?? '')->format('d-m-Y') }}</td>
                <td>
                    {{ Carbon\Carbon::parse($result->rekod_tarikhoperasi ?? '')->format('d-m-Y') }}</td>
                <td>{{ $result->rekod_tarafsyarikat ?? '' }}</td>
                <td>{{ $result->rekod_statushakmilik ?? '' }}</td>
                <td>{{ number_format($result->rekod_nilaiharta, 2) }}</td>
                <td>{{ Carbon\Carbon::parse($result->rekod_modified_on ?? '')->format('d-m-Y') }}</td>
                <td>{{ $result->guna_tenaga->sum_wargabumi_l ?? '' }}</td>
                <td>{{ $result->guna_tenaga->sum_wargabumi_p ?? '' }}</td>
                <td>{{ $result->guna_tenaga->sum_wargabukanbumi_l ?? '' }}</td>
                <td>{{ $result->guna_tenaga->sum_wargabukanbumi_p ?? '' }}</td>
                <td>{{ $result->guna_tenaga->sum_bukanwarga_l ?? '' }}</td>
                <td>{{ $result->guna_tenaga->sum_bukanwarga_p ?? '' }}</td>
                <td>{{ number_format($result->jumlahpenggunaan, 0) }}</td>
                <td>{{ number_format($result->jumlahpengeluaran, 0) }}</td>
                <td>{{ number_format($result->jumlaheksport, 0) }}</td>
                <td>{{ number_format($result->jumlahtempatan, 0) }}</td>

            </tr>
        @endforeach


    </tbody>
</table>
