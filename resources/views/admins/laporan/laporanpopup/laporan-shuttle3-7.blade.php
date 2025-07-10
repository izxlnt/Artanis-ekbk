@extends('layouts.layout-ipjpsm-nicepage')

@section('content')
    {{-- <style type="text/css" media="print">
        @page {
            size: landscape;
        }

    </style> --}}


    {{-- <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


    <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script> --}}

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
                    <a href="{{ route('laporan_shuttle_3_7.excel', ['7', $tahun, ($file_type = 'excel')]) }}"
                        class="btn btn-success">Excel</a>
                    <a href="{{ route('laporan_shuttle_3_7.excel', ['7', $tahun, ($file_type = 'pdf')]) }}"
                        class="btn btn-danger">PDF</a>
                    <a href="{{ route('laporan_shuttle_3_7.excel', ['7', $tahun, ($file_type = 'print')]) }}"
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
                            <table id="example" class="table-bordered">
                                <thead style="background-color: #f3ce8f; font-weight: bold;">
                                    <tr class="text-center">

                                        <th>Bil</th>
                                        <th>Negeri</th>
                                        <th>Harta Tetap</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($negeri_list as $key => $negeri)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-left">
                                                {{ $negeri->negeri }}
                                            </td>
                                            @php
                                                $jumlah_by_negeri = 0;
                                                foreach ($datas as $jumlah) {
                                                    if ($jumlah->negeri == $negeri->negeri) {
                                                        $jumlah_by_negeri = $jumlah->jumlah;
                                                    }
                                                }
                                            @endphp
                                            <td class="text-right">
                                                RM {{ number_format($jumlah_by_negeri, 2) }}
                                            </td>
                                        </tr>
                                    @endforeach

                                    <tr class="text-center" style="background-color: lightgray;">
                                        <td></td>
                                        <td class="text-left"><b>JUMLAH</b></td>
                                        <td class="text-right"><b>RM
                                                {{ number_format($jumlah_setiap_negeri, 2) }}</b>
                                        </td>
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
            var t = $('#example').DataTable({
                dom: 'Bfrtip',
                paging: false,
                // scrollY: 750,
                // scrollX: true,
                scrollCollapse: true,
                ordering: false,
                searching: false,
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
                    // 'copyHtml5',
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
