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
                    <a href="{{ route('getreport_top10pengeluar.excel', [$shuttle,($tahun = $tahun),$lapisvenier,$title,($file_type = 'excel')]) }}"
                        class="btn btn-success">Excel</a>
                    <a href="{{ route('getreport_top10pengeluar.excel', [$shuttle,($tahun = $tahun),$lapisvenier,$title,($file_type = 'pdf')]) }}"
                        class="btn btn-danger">PDF</a>
                    <a href="{{ route('getreport_top10pengeluar.excel', [$shuttle,($tahun = $tahun),$lapisvenier,$title,($file_type = 'pdf')]) }}"
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
                    <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title_laporan }} Bagi Tahun
                        {{ $tahun }}</div>
                    <div class="card-body">

                        <div class="table-responsive">
                            <table id="example" class="table-bordered">

                                <thead style="background-color: #f3ce8f; font-weight: bold;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Jenis')
                                                <th class="text-center" colspan="2" rowspan="1">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan')
                                                <th class="text-center" colspan="2" rowspan="1">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Papan Venir Mengikut Jenis')
                                                <th class="text-center" colspan="2" rowspan="1">{{ $data }}ss</th>
                                            @else
                                                <th class="text-center" rowspan="3">{{ $data }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        @if ($title == '206')
                                            <th class="text-center">Muka</th>
                                            <th class="text-center">Teras</th>
                                        @else
                                            <th class="text-center">MR</th>
                                            <th class="text-center">WBP</th>
                                            <th class="text-center">Nipis</th>
                                            <th class="text-center">Tebal</th>
                                        @endif
                                    </tr>
                                    <tr>
                                        @if ($title == '206')
                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>
                                        @else
                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>
                                        @endif
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($results as $result)
                                        <tr class="text-center">
                                            <td> {{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $result->rekod_namakilang ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_nossm ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_nolesen ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_notel ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_nofaks ?? '-' }}</td>
                                            <td class="text-left">{{ $result->rekod_email ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_alamatkilang_jalan1 ?? '' }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_alamatkilang_jalan2 ?? '' }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_alamatkilang_poskod ?? '' }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_daerah ?? ('' ?? '') }}</td>
                                            <td class="text-left">{{ $result->rekod_negeri ?? '' }}</td>

                                            <td class="text-left">N/A</td>
                                            <td class="text-left">N/A</td>
                                            <td class="text-left">N/A</td>
                                            <td class="text-left">N/A</td>

                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($result->rekod_tarikhtubuh ?? '')->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($result->rekod_tarikhoperasi ?? '')->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_tarafsyarikat ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_statushakmilik ?? '' }}</td>
                                            @if ($title == '206')
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->muka, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->teras, 0) }}</td>
                                            @else
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->jumlahmr, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->jumlahwbp, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->nipis, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->jumlahpengeluaran->tebal, 0) }}</td>
                                            @endif
                                        </tr>
                                    @endforeach


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
            var title = {!! json_encode($title) !!};
            var tahun = {!! json_encode($tahun) !!};

            var title = title + " Bagi Tahun " + tahun;

            var t = $('#example').DataTable({
                dom: 'Bfrtip',
                paging: false,
                scrollY: 750,
                scrollX: true,
                scrollCollapse: true,
                searching: false,
                ordering: false,
                buttons: [{
                    extend: 'excelHtml5',
                    title: title,
                    footer: true,

                }, ],
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
                dom: 'Bfrtip',
                buttons: [
                    // 'excelHtml5',
                ]
            });

            t.on('order.dt search.dt', function() {
                t.column(0, {
                    search: 'applied',
                    order: 'applied'
                }).nodes().each(function(cell, i) {
                    cell.innerHTML = i + 1;
                    t.cell(cell).invalidate('dom');
                });
            }).draw();

        });
    </script>
@endsection
