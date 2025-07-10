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
                    <a href="{{ route('laporan_shuttle_4_33.excel', ['33', $tahun, $file_type = 'excel']) }}" class="btn btn-success">Excel</a>
                    <a href="{{ route('laporan_shuttle_4_33.excel', ['33', $tahun, $file_type = 'pdf']) }}" class="btn btn-danger">PDF</a>
                    <a href="{{ route('laporan_shuttle_4_33.excel', ['33', $tahun, $file_type = 'print']) }}" class="btn btn-warning">Print</a>
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
                            <table id="example" class="table-bordered" style="width:100%">
                                <thead style="background-color: #f3ce8f;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th class="text-center">{{ $data }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($datas as $negeri => $data)
                                        @php
                                            $jumlah_row_mr = 0;
                                            $jumlah_row_wbp = 0;
                                            $total_jumlah_row_mr = 0;
                                            $total_jumlah_row_wbp = 0;
                                        @endphp
                                        <tr class="text-center">
                                            <td> {{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $negeri }}</td>
                                            <td class="text-left">MR</td>
                                            @foreach ($data as $result)
                                                <td class="text-right">
                                                    {{ number_format($result[0]->jumlah_besar_mr, 0) }}</td>

                                                @php
                                                    $jumlah_row_mr = $jumlah_row_mr + $result[0]->jumlah_besar_mr;
                                                @endphp
                                            @endforeach
                                            <td class="text-right">{{ number_format($jumlah_row_mr) }}</td>
                                        </tr>

                                        <tr class="text-center">
                                            <td></td>
                                            <td class="text-left"></td>
                                            <td class="text-left">WBP</td>
                                            @foreach ($data as $result)
                                                <td class="text-right">
                                                    {{ number_format($result[0]->jumlah_besar_wbp, 0) }}</td>
                                                @php
                                                    $jumlah_row_wbp = $jumlah_row_wbp + $result[0]->jumlah_besar_wbp;
                                                @endphp
                                            @endforeach
                                            <td class="text-right">{{ number_format($jumlah_row_wbp) }}</td>
                                        </tr>
                                    @endforeach


                                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                        <td class="text-left"></td>
                                        <td class="text-left">Jumlah (m³)</td>
                                        <td class="text-left">MR</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['mr'] as $data)
                                            @php
                                                $total_jumlah_row_mr += $data;
                                            @endphp
                                            <td class="text-right">{{ number_format($data, 0) }}</td>
                                        @endforeach
                                        <td class="text-right">{{ number_format($total_jumlah_row_mr, 0) }}</td>
                                    </tr>
                                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td class="text-left"></td>
                                        <td class="text-left">WBP</td>
                                        @foreach ($grandtotal->jumlahpengeluaran['wbp'] as $data)
                                            @if (is_numeric($data))
                                                @php
                                                    $total_jumlah_row_wbp += $data;
                                                @endphp
                                                <td class="text-right">{{ number_format($data, 0) }}</td>
                                            @endif
                                        @endforeach
                                        <td class="text-right">{{ number_format($total_jumlah_row_wbp, 0) }}</td>
                                    </tr>

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
                // dom: 'Bfrtip',
                paging: false,
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
            });

        });
    </script>
@endsection
