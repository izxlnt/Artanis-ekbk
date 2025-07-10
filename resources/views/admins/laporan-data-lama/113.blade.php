@extends('layouts.layout-ipjpsm-nicepage')

@section('content')
    <style type="text/css" media="print">
        @page {
            size: landscape;
        }

    </style>

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
                    <a href="{{ route('getreport_gunatenaga_bykategori.excel', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title, $file_type = 'excel']) }}" class="btn btn-success">Excel</a>
                    <a href="{{ route('getreport_gunatenaga_bykategori.excel', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title, $file_type = 'pdf']) }}" class="btn btn-danger">PDF</a>
                    <a href="{{ route('getreport_gunatenaga_bykategori.excel', [$shuttle, $tahun, $suku_tahun, $suku_tahun_akhir, $title, $file_type = 'pdf']) }}" class="btn btn-warning">Print</a>
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
                    {{-- <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title }}</div> --}}

                    @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                        <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title_laporan }} : Suku
                            Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                            {{ $tahun }}</div>
                    @else
                        <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title_laporan }} : Suku
                            Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                    @endif

                    <div class="card-body">
                        @foreach ($results as $key => $suku)
                            @if (!$loop->first)
                                <hr>
                            @endif
                            <div class="table-responsive">
                                @if ($key == 1)
                                    <div class="text-center" style="font-weight: bold;">Suku
                                        Tahun Pertama</div>
                                @elseif($key == 2)
                                    <div class="text-center" style="font-weight: bold;">Suku
                                        Tahun Kedua</div>
                                @elseif($key == 3)
                                    <div class="text-center" style="font-weight: bold;">Suku
                                        Tahun Ketiga</div>
                                @else
                                    <div class="text-center" style="font-weight: bold;">Suku
                                        Tahun Keempat</div>
                                @endif
                                <table id="example_{{ $key }}" class="table-bordered" style="width: 100%">
                                    @php

                                        $jumlah_bumi_lelaki = 0;
                                        $jumlah_bumi_perempuan = 0;
                                        $jumlah_bumiputera = 0;

                                        $jumlah_bukan_bumi_lelaki = 0;
                                        $jumlah_bukan_bumi_perempuan = 0;
                                        $jumlah_bukan_bumiputera = 0;

                                        $jumlah_bukan_warga_lelaki = 0;
                                        $jumlah_bukan_warga_perempuan = 0;
                                        $jumlah_bukan_warganegara = 0;

                                        $jumlah_jumlah_lelaki = 0;
                                        $jumlah_jumlah_perempuan = 0;
                                        $jumlah_jumlah_jumlah = 0;

                                    @endphp
                                    <thead style="background-color: #f3ce8f;">
                                        <tr>

                                            @foreach ($columns as $data)
                                                @if ($data == 'Bumiputera')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Bukan Bumiputera')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Bukan Warganegara')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Bukan Warganegara')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Jumlah')
                                                    <th class="text-center" colspan="3">{{ $data }}</th>
                                                @else
                                                    <th class="text-center" rowspan="2">{{ $data }}</th>
                                                @endif
                                            @endforeach

                                        </tr>
                                        <tr>
                                            <th class="text-center">L</th>
                                            <th class="text-center">P</th>
                                            <th class="text-center">Jumlah (L+P)</th>

                                            <th class="text-center">L</th>
                                            <th class="text-center">P</th>
                                            <th class="text-center">Jumlah (L+P)</th>

                                            <th class="text-center">L</th>
                                            <th class="text-center">P</th>
                                            <th class="text-center">Jumlah (L+P)</th>

                                            <th class="text-center">L</th>
                                            <th class="text-center">P</th>
                                            <th class="text-center">Jumlah (L+P)</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach ($suku as $result)
                                            <tr class="text-center">

                                                <td> {{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $result->kod_keterangan }}</td>
                                                <td class="text-right">{{ number_format($result->wargabumi->l, 0) }}
                                                </td>
                                                <td class="text-right">{{ number_format($result->wargabumi->p, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->wargabumi->jumlah, 0) }}
                                                </td>

                                                <td class="text-right">
                                                    {{ number_format($result->wargabukanbumi->l, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->wargabukanbumi->p, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->wargabukanbumi->jumlah, 0) }}</td>

                                                <td class="text-right">{{ number_format($result->bukanwarga->l, 0) }}
                                                </td>
                                                <td class="text-right">{{ number_format($result->bukanwarga->p, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->bukanwarga->jumlah, 0) }}</td>

                                                <td class="text-right">
                                                    {{ number_format($result->keseluruhan->l, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->keseluruhan->p, 0) }}
                                                </td>
                                                <td class="text-right">
                                                    {{ number_format($result->keseluruhan->jumlah, 0) }}</td>

                                                @php
                                                    $jumlah_bumi_lelaki += $result->wargabumi->l;
                                                    $jumlah_bumi_perempuan += $result->wargabumi->p;
                                                    $jumlah_bumiputera += $result->wargabumi->jumlah;

                                                    $jumlah_bukan_bumi_lelaki += $result->wargabukanbumi->l;
                                                    $jumlah_bukan_bumi_perempuan += $result->wargabukanbumi->p;
                                                    $jumlah_bukan_bumiputera += $result->wargabukanbumi->jumlah;

                                                    $jumlah_bukan_warga_lelaki += $result->bukanwarga->l;
                                                    $jumlah_bukan_warga_perempuan += $result->bukanwarga->p;
                                                    $jumlah_bukan_warganegara += $result->bukanwarga->jumlah;

                                                    $jumlah_jumlah_lelaki += $result->keseluruhan->l;
                                                    $jumlah_jumlah_perempuan += $result->keseluruhan->p;
                                                    $jumlah_jumlah_jumlah += $result->keseluruhan->jumlah;

                                                @endphp

                                            </tr>
                                        @endforeach
                                        <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                            <td></td>
                                            <td class="text-left">Jumlah</td>

                                            <td>{{ number_format($jumlah_bumi_lelaki, 0) }}</td>
                                            <td>{{ number_format($jumlah_bumi_perempuan, 0) }}</td>
                                            <td>{{ number_format($jumlah_bumiputera, 0) }}</td>

                                            <td>{{ number_format($jumlah_bukan_bumi_lelaki, 0) }}</td>
                                            <td>{{ number_format($jumlah_bukan_bumi_perempuan, 0) }}</td>
                                            <td>{{ number_format($jumlah_bukan_bumiputera, 0) }}</td>

                                            <td>{{ number_format($jumlah_bukan_warga_lelaki, 0) }}</td>
                                            <td>{{ number_format($jumlah_bukan_warga_perempuan, 0) }}</td>
                                            <td>{{ number_format($jumlah_bukan_warganegara, 0) }}</td>

                                            <td>{{ number_format($jumlah_jumlah_lelaki, 0) }}</td>
                                            <td>{{ number_format($jumlah_jumlah_perempuan, 0) }}</td>
                                            <td>{{ number_format($jumlah_jumlah_jumlah, 0) }}</td>

                                        </tr>

                                    </tbody>
                                </table>



                            </div>
                        @endforeach
                    </div>

                </div>


            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            var title = {!! json_encode($title) !!};
            var nama_suku_tahun = {!! json_encode($nama_suku_tahun) !!};
            var nama_suku_tahun_akhir = {!! json_encode($nama_suku_tahun_akhir) !!};

            var tahun = {!! json_encode($tahun) !!};

            if (nama_suku_tahun != nama_suku_tahun_akhir) {
                var title = title + " - Suku Tahun " + nama_suku_tahun + " Hingga Suku Tahun " +
                    nama_suku_tahun_akhir + " Bagi Tahun " + tahun;
            } else {
                var title = title + " - Suku Tahun " + nama_suku_tahun + " Bagi Tahun " + tahun;
            }

            for (let index = 1; index <= 4; index++) {
                var t_index = $('#example_' + index).DataTable({
                    // dom: 'Bfrtip',
                    paging: false,
                    ordering: false,
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
                        "lengthMenu": "Memaparkan _MENU_ rekod per halaman",
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
            }
        });
    </script>
@endsection
