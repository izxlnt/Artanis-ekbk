@extends('layouts.layout-ipjpsm-nicepage')

@section('content')
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <link rel="stylesheet" href="https://cdn.datatables.net/buttons/2.0.1/css/buttons.dataTables.min.css">

    <script src="https://code.jquery.com/jquery-3.5.1.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/dataTables.buttons.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
    <script src="https://cdn.datatables.net/buttons/2.0.1/js/buttons.html5.min.js"></script>


    <div class="container-fluid">
        <div class="page-breadcrumb" style="padding: 0px">
            <div class="pb-2 row">
                <div class="col-5 align-self-center">
                    <a href="{{ $returnArr['kembali'] }}" class="btn btn-primary">Kembali</a>
                    <a href="{{ route('laporan_shuttle_3_23.excel', ['23', $tahun, ($file_type = 'excel')]) }}"
                        class="btn btn-success">Excel</a>
                    <a href="{{ route('laporan_shuttle_3_23.excel', ['23', $tahun, ($file_type = 'pdf')]) }}"
                        class="btn btn-danger">PDF</a>
                    <a href="{{ route('laporan_shuttle_3_23.excel', ['23', $tahun, ($file_type = 'print')]) }}"
                        class="btn btn-warning">Print</a>
                </div>
                <div class="col-7 align-self-center">
                    <div class="d-flex align-items-center justify-content-end">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                @foreach ($returnArr['breadcrumbs'] as $breadcrumb)
                                    @if (!$loop->last)
                                        <li class="breadcrumb-item">
                                            <a href="{{ $breadcrumb['link'] }}" style="color: white !important;"
                                                onMouseOver="this.style.color='lightblue'"
                                                onMouseOut="this.style.color='white'"> {{ $breadcrumb['name'] }}
                                            </a>
                                        </li>
                                    @else
                                        <li class="breadcrumb-item active" aria-current="page"
                                            style="color: yellow !important;">
                                            {{ $breadcrumb['name'] }}
                                        </li>
                                    @endif
                                @endforeach

                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">



                <div class="card">
                    <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title }} Bagi Tahun
                        {{ $tahun }}</div>
                    <div class="card-body">


                        <div class="table-responsive">
                            <table id="example" class="text-center table-bordered" style="width: 100%">
                                <thead style="background-color: #f3ce8f;">
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
                                            <td class="text-left">{{ $kayu->singkatan }}</td>
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
                                                        <tr class="text-right">
                                                            <td class="text-center">{{ $loop->iteration }}</td>
                                                            <td class="text-left">{{ $nama_species }}</td>
                                                            @foreach ($species as $negeri => $get_data)
                                                                {{-- {{ dd($species) }} --}}
                                                                <td>

                                                                    @if ($negeri == 'Johor')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_johor += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_johor += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'Kedah')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_kedah += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_kedah += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'Kelantan')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_kedah += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_kedah += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'Melaka')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_melaka += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_melaka += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'Negeri Sembilan')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_n9 += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_n9 += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'Pahang')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_pahang += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_pahang += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'Perak')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_perak += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_perak += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'Perlis')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_perlis += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_perlis += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'Pulau Pinang')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_penang += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_penang += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'Selangor')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_selangor += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_selangor += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'Terengganu')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_tganu += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_tganu += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @elseif ($negeri == 'W.P Kuala Lumpur')
                                                                        {{ number_format($get_data[0]->jumlah_penggunaan, 0) }}
                                                                        @php
                                                                            $jumlah_row += $get_data[0]->jumlah_penggunaan;

                                                                            $jumlah_kl += $get_data[0]->jumlah_penggunaan;
                                                                            $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan;

                                                                            $keseluruhan_kl += $get_data[0]->jumlah_penggunaan;
                                                                            $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan;
                                                                        @endphp
                                                                    @endif
                                                                </td>
                                                            @endforeach
                                                            <td class="text-right">
                                                                {{ number_format($jumlah_row, 0) }}</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach

                                        <tr class="text-bold" style="background-color: lightgray; font-weight: bold;">
                                            <td></td>
                                            <td class="text-left">Jumlah {{ $kayu->singkatan }}</td>
                                            <td class="text-right">{{ number_format($jumlah_johor, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_kedah, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_kelantan, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_melaka, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_n9, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_pahang, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_perak, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_perlis, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_penang, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_selangor, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_tganu, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_kl, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_kumpulan, 0) }}</td>
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
                                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td class="text-left">JUMLAH BESAR (m³)</td>

                                        <td class="text-right">{{ number_format($keseluruhan_johor, 0) }}</td>
                                        <td class="text-right">{{ number_format($keseluruhan_kedah, 0) }}</td>
                                        <td class="text-right">{{ number_format($keseluruhan_kelantan, 0) }}</td>
                                        <td class="text-right">{{ number_format($keseluruhan_melaka, 0) }}</td>

                                        <td class="text-right">{{ number_format($keseluruhan_n9, 0) }}</td>
                                        <td class="text-right">{{ number_format($keseluruhan_pahang, 0) }}</td>
                                        <td class="text-right">{{ number_format($keseluruhan_perak, 0) }}</td>
                                        <td class="text-right">{{ number_format($keseluruhan_perlis, 0) }}</td>

                                        <td class="text-right">{{ number_format($keseluruhan_penang, 0) }}</td>
                                        <td class="text-right">{{ number_format($keseluruhan_selangor, 0) }}</td>
                                        <td class="text-right">{{ number_format($keseluruhan_tganu, 0) }}</td>
                                        <td class="text-right">{{ number_format($keseluruhan_kl, 0) }}</td>

                                        <td class="text-right">{{ number_format($keseluruhan_kumpulan, 0) }}</td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>


            </div>
        </div>


    </div>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                paging: false,
                scrollY: 750,
                scrollX: false,
                scrollCollapse: true,
                ordering: false,
                searching: false,
                "language": {
                    "lengthMenu": "Memaparkan _MENU_ rekod per  ",
                    "zeroRecords": "Maaf, tiada rekod.",
                    "info": "",
                    "infoEmpty": "Tidak ada rekod yang tersedia",
                    "infoFiltered": "(Ditapis dari _MAX_ jumlah rekod)",
                    "search": "Carian",
                    "previous": "Sebelum",
                    "paginate": {
                        "first": "Pertama",
                        "last": "Terakhir",
                        "next": "Seterusnya",
                        "previous": "Sebelumnya"
                    },
                },
            });
        });
    </script>
@endsection
