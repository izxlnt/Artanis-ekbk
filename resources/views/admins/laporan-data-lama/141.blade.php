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
                    <a href="{{ route('getreport_jualan_bybulan.excel', [$shuttle, $tahun, $title, ($file_type = 'excel')]) }}"
                        class="btn btn-success">Excel</a>
                    <a href="{{ route('getreport_jualan_bybulan.excel', [$shuttle, $tahun, $title, ($file_type = 'pdf')]) }}"
                        class="btn btn-danger">PDF</a>
                    <a href="{{ route('getreport_jualan_bybulan.excel', [$shuttle, $tahun, $title, ($file_type = 'pdf')]) }}"
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
                            <table id="example" class="table-bordered" style="width:100%">
                                <thead style="background-color: #f3ce8f">
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th class="text-center">{{ $data }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($results as $result)
                                        @if ($shuttle == 'shuttle4')
                                            <tr class="text-center">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $result->kayugergaji->bulan }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->papanlapis->jualantempatan, 0) }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->venier->jualantempatan, 0) }}</td>
                                            </tr>
                                        @elseif ($shuttle == 'shuttle5')
                                            <tr class="text-center">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $result->kayukumai->bulan }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->kayukumai->jualantempatan, 0) }}</td>
                                            </tr>
                                        @else
                                            <tr class="text-center">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $result->kayugergaji->bulan }}</td>
                                                <td class="text-right">
                                                    {{ number_format($result->kayugergaji->jualantempatan, 0) }}</td>
                                            </tr>
                                        @endif
                                    @endforeach

                                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                        <td class="text-center"></td>
                                        <td class="text-left">Jumlah (m³)</span></td>
                                        @if ($shuttle == 'shuttle4')
                                            @foreach ($grandtotal->jualantempatan as $total)
                                                <td class="text-right">{{ number_format($total, 0) }}</td>
                                            @endforeach

                                        @elseif ($shuttle == 'shuttle5')
                                            @foreach ($grandtotal->jualantempatan as $total)
                                                <td class="text-right">{{ number_format($total, 0) }}</td>
                                                @break
                                            @endforeach
                                        @else
                                            @foreach ($grandtotal->jualantempatan as $total)
                                                @if (is_numeric($total))
                                                    <td class="text-right">{{ number_format($total, 0) }}</td>
                                                @endif
                                            @break
                                            @endforeach
                                        @endif
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
        var title = {!! json_encode($title) !!};
        var tahun = {!! json_encode($tahun) !!};

        var title = title + " Bagi Tahun " + tahun;


        var t = $('#example').DataTable({
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
