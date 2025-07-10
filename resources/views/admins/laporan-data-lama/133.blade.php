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

{{-- FIXED HEADER --}}
<script src="https://cdn.datatables.net/responsive/2.2.9/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/fixedheader/3.2.2/js/dataTables.fixedHeader.min.js"></script>

    <div class="container-fluid">
        <div class="page-breadcrumb" style="padding: 0px">
            <div class="pb-2 row">
                <div class="col-5 align-self-center">
                    <a href="{{ $returnArr['kembali'] }}" class="btn btn-primary">Kembali</a>
                    <a href="{{ route('getreport_pengeluaran_bykumpulankayu_bynegeri.excel', [$shuttle, $tahun, $title, $file_type = 'excel']) }}" class="btn btn-success">Excel</a>
                    <a href="{{ route('getreport_pengeluaran_bykumpulankayu_bynegeri.excel', [$shuttle, $tahun, $title, $file_type = 'pdf']) }}" class="btn btn-danger">PDF</a>
                    <a href="{{ route('getreport_pengeluaran_bykumpulankayu_bynegeri.excel', [$shuttle, $tahun, $title, $file_type = 'pdf']) }}" class="btn btn-warning">Print</a>
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
                    <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title_laporan }} Bagi Tahun
                        {{ $tahun }}</div>
                    <div class="card-body">


                        <div class="table-responsive">
                            <table id="example" class="text-center table-bordered" style="width: 100%;">
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

                                        @foreach ($results as $data)
                                            @if ($data->spesies_kumpulankayu == $kayu->singkatan)
                                                @php
                                                    $jumlah_row = 0;
                                                @endphp

                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $data->spesies_namatempatan }}</td>

                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[0], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[0];
                                                        $jumlah_johor += $data->jumlahpengeluaran[0];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[0];

                                                        $keseluruhan_johor += $data->jumlahpengeluaran[0];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[0];
                                                    @endphp
                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[1], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[1];
                                                        $jumlah_kedah += $data->jumlahpengeluaran[1];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[1];

                                                        $keseluruhan_kedah += $data->jumlahpengeluaran[1];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[1];
                                                    @endphp
                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[2], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[2];
                                                        $jumlah_kelantan += $data->jumlahpengeluaran[2];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[2];

                                                        $keseluruhan_kelantan += $data->jumlahpengeluaran[2];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[2];
                                                    @endphp
                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[3], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[3];
                                                        $jumlah_melaka += $data->jumlahpengeluaran[3];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[3];

                                                        $keseluruhan_melaka += $data->jumlahpengeluaran[3];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[3];
                                                    @endphp

                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[4], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[4];
                                                        $jumlah_n9 += $data->jumlahpengeluaran[4];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[4];

                                                        $keseluruhan_n9 += $data->jumlahpengeluaran[4];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[4];
                                                    @endphp
                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[5], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[5];
                                                        $jumlah_pahang += $data->jumlahpengeluaran[5];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[5];

                                                        $keseluruhan_pahang += $data->jumlahpengeluaran[5];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[5];
                                                    @endphp
                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[6], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[6];
                                                        $jumlah_perak += $data->jumlahpengeluaran[6];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[6];

                                                        $keseluruhan_perak += $data->jumlahpengeluaran[6];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[6];
                                                    @endphp
                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[7], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[7];
                                                        $jumlah_perlis += $data->jumlahpengeluaran[7];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[7];

                                                        $keseluruhan_perlis += $data->jumlahpengeluaran[7];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[7];
                                                    @endphp

                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[8], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[8];
                                                        $jumlah_penang += $data->jumlahpengeluaran[8];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[8];

                                                        $keseluruhan_penang += $data->jumlahpengeluaran[8];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[8];
                                                    @endphp
                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[9], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[9];
                                                        $jumlah_selangor += $data->jumlahpengeluaran[9];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[9];

                                                        $keseluruhan_selangor += $data->jumlahpengeluaran[9];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[9];
                                                    @endphp
                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[10], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[10];
                                                        $jumlah_tganu += $data->jumlahpengeluaran[10];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[10];

                                                        $keseluruhan_tganu += $data->jumlahpengeluaran[10];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[10];
                                                    @endphp
                                                    <td class="text-right">
                                                        {{ number_format($data->jumlahpengeluaran[11], 0) }}</td>
                                                    @php
                                                        $jumlah_row += $data->jumlahpengeluaran[11];
                                                        $jumlah_kl += $data->jumlahpengeluaran[11];
                                                        $jumlah_kumpulan += $data->jumlahpengeluaran[11];

                                                        $keseluruhan_kl += $data->jumlahpengeluaran[11];
                                                        $keseluruhan_kumpulan += $data->jumlahpengeluaran[11];
                                                    @endphp

                                                    <td class="text-right">{{ number_format($jumlah_row, 0) }}</td>

                                                </tr>
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
                                {{-- <tfoot>
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
                                </tfoot> --}}
                            </table>
                        </div>


                    </div>
                </div>


            </div>
        </div>


    </div>
    <script>
        $(document).ready(function() {
            var title = {!! json_encode($title) !!};
            var tahun = {!! json_encode($tahun) !!};

            var title = title + " Bagi Tahun " + tahun;


            var table = $('#example').DataTable({
            ordering : false,
                // dom: 'Bfrtip',
                paging: false,
                scrollY: 750,
                scrollX: false,
                scrollCollapse: true,
                ordering:false,
                searching: false,
                buttons: [{
                        extend: 'excelHtml5',
                        title: title,
                        footer: true,
                    },
                    {
                        extend: 'pdfHtml5',
                        title: title,
                        footer: true,
                        header: true,
                        orientation: 'landscape',
                        pageSize: 'A4',
                    },
                ],
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

        new $.fn.dataTable.FixedHeader( table );

        });
    </script>
@endsection
