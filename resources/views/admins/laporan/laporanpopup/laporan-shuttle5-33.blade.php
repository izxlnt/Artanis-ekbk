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
                    <a href="{{ route('laporan_shuttle_5_33.excel', ['44', $tahun, ($file_type = 'excel')]) }}"
                        class="btn btn-success">Excel</a>
                    <a href="{{ route('laporan_shuttle_5_33.excel', ['44', $tahun, ($file_type = 'pdf')]) }}"
                        class="btn btn-danger">PDF</a>
                    <a href="{{ route('laporan_shuttle_5_33.excel', ['44', $tahun, ($file_type = 'print')]) }}"
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
                                <thead style="background-color: #f3ce8f; font-weight: bold;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th>{{ $data }}</th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $jenis_kayu_key => $data)
                                        @php
                                            $jumlah_keseluruhan = 0;
                                            $total_jualan[$jenis_kayu_key] = 0;
                                            for ($i = 1; $i <= 12; $i++) {
                                                $total_jualan_bulan[$i] = 0;
                                            }
                                        @endphp
                                    @endforeach
                                    @foreach ($datas as $jenis_kayu_key => $data)
                                        <tr class="text-right">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $jenis_kayu_key }}</td>
                                            @for ($i = 1; $i <= 12; $i++)
                                                <td>{{ number_format($data[$i][0]->jumlah_jualan ?? 0) }}</td>
                                                @php
                                                    $total_jualan[$jenis_kayu_key] += $data[$i][0]->jumlah_jualan ?? 0;
                                                    $total_jualan_bulan[$i] += $data[$i][0]->jumlah_jualan ?? 0;
                                                @endphp
                                            @endfor
                                            <td>{{ number_format($total_jualan[$jenis_kayu_key]) }}</td>
                                        </tr>
                                    @endforeach
                                    <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td class="text-left">Jumlah (m³)</td>

                                        @for ($i = 1; $i <= 12; $i++)
                                            <td>{{ number_format($total_jualan_bulan[$i]) }}</td>
                                            @php
                                                $jumlah_keseluruhan += $total_jualan_bulan[$i];
                                            @endphp
                                        @endfor
                                        <td>{{ number_format($jumlah_keseluruhan) }}</td>
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
