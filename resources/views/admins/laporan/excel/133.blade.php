<table>
    <thead style="background-color: #f3ce8f;">
        <tr>
            <th>{{ strtoupper($title) }} BAGI TAHUN {{ $tahun }}</th>
        </tr>
        <tr>
            @foreach ($columns as $data)
                <th>{{ $data }}</th>
            @endforeach
        </tr>
    </thead>
    <tbody style="text-align: center">
        @php
            $keseluruhan_johor = 0;
            $keseluruhan_kedah = 0;
            $keseluruhan_kelantan = 0;
            $keseluruhan_melaka = 0;
            $keseluruhan_n9 = 0;
            $keseluruhan_pahang = 0;
            $keseluruhan_perak = 0;
            $keseluruhan_perlis = 0;
            $keseluruhan_penang = 0;
            $keseluruhan_selangor = 0;
            $keseluruhan_tganu = 0;
            $keseluruhan_kl = 0;
            $keseluruhan_kumpulan = 0;
        @endphp
        @foreach ($kumpulan_kayu as $kayu)
            <tr style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td>{{ $kayu->singkatan }}</td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
            @php
                $jumlah_johor = 0;
                $jumlah_kedah = 0;
                $jumlah_kelantan = 0;
                $jumlah_melaka = 0;
                $jumlah_n9 = 0;
                $jumlah_pahang = 0;
                $jumlah_perak = 0;
                $jumlah_perlis = 0;
                $jumlah_penang = 0;
                $jumlah_selangor = 0;
                $jumlah_tganu = 0;
                $jumlah_kl = 0;
                $jumlah_kumpulan = 0;
            @endphp
            @foreach ($datas as $keterangan => $data)
                @if ($keterangan == $kayu->singkatan)
                    @foreach ($data as $nama_species => $species)
                        @php
                            $jumlah_row = 0;
                        @endphp

                        @if ($species)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $nama_species }}</td>
                                @foreach ($species as $negeri => $get_data)
                                    {{-- {{ dd($species) }} --}}
                                    <td style="text-align: right">

                                        @if ($negeri == 'Johor')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_johor += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_johor += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'Kedah')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_kedah += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_kedah += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'Kelantan')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_kedah += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_kedah += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'Melaka')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_melaka += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_melaka += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'Negeri Sembilan')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_n9 += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_n9 += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'Pahang')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_pahang += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_pahang += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'Perak')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_perak += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_perak += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'Perlis')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_perlis += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_perlis += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'Pulau Pinang')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_penang += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_penang += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'Selangor')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_selangor += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_selangor += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'Terengganu')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_tganu += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_tganu += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @elseif ($negeri == 'W.P Kuala Lumpur')
                                            {{ number_format($get_data[0]->jumlah_pengeluaran, 0) }}
                                            @php
                                                $jumlah_row += $get_data[0]->jumlah_pengeluaran;

                                                $jumlah_kl += $get_data[0]->jumlah_pengeluaran;
                                                $jumlah_kumpulan += $get_data[0]->jumlah_pengeluaran;

                                                $keseluruhan_kl += $get_data[0]->jumlah_pengeluaran;
                                                $keseluruhan_kumpulan += $get_data[0]->jumlah_pengeluaran;
                                            @endphp
                                        @endif
                                    </td>
                                @endforeach
                                <td style="text-align: right">
                                    {{ number_format($jumlah_row, 0) }}</td>
                            </tr>
                        @endif
                    @endforeach
                @endif
            @endforeach

            <tr class="text-right text-bold" style="background-color: lightgray; font-weight: bold;">
                <td></td>
                <td>Jumlah {{ $kayu->singkatan }}</td>
                <td style="text-align: right">{{ number_format($jumlah_johor) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_kedah) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_kelantan) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_melaka) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_n9) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_pahang) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_perak) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_perlis) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_penang) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_selangor) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_tganu) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_kl) }}</td>
                <td style="text-align: right">{{ number_format($jumlah_kumpulan) }}</td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        @endforeach

        <tr style="background-color: lightgray; font-weight: bold;">
            <td></td>
            <td>JUMLAH BESAR</td>

            <td style="text-align: right">{{ number_format($keseluruhan_johor) }}</td>
            <td style="text-align: right">{{ number_format($keseluruhan_kedah) }}</td>
            <td style="text-align: right">{{ number_format($keseluruhan_kelantan) }}</td>
            <td style="text-align: right">{{ number_format($keseluruhan_melaka) }}</td>

            <td style="text-align: right">{{ number_format($keseluruhan_n9) }} </td>
            <td style="text-align: right">{{ number_format($keseluruhan_pahang) }}</td>
            <td style="text-align: right">{{ number_format($keseluruhan_perak) }}</td>
            <td style="text-align: right">{{ number_format($keseluruhan_perlis) }}</td>

            <td style="text-align: right">{{ number_format($keseluruhan_penang) }}</td>
            <td style="text-align: right">{{ number_format($keseluruhan_selangor) }}</td>
            <td style="text-align: right">{{ number_format($keseluruhan_tganu) }}</td>
            <td style="text-align: right">{{ number_format($keseluruhan_kl) }}</td>

            <td style="text-align: right">{{ number_format($keseluruhan_kumpulan) }}</td>
        </tr>
    </tbody>
</table>
