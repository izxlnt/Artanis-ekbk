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
                    <a href="{{ route('laporan_shuttle_3_22.excel', ['22', 'shuttle3', $tahun_mula, $tahun_akhir, ($file_type = 'excel')]) }}"
                        class="btn btn-success">Excel</a>
                    <a href="{{ route('laporan_shuttle_3_22.excel', ['22', 'shuttle3', $tahun_mula, $tahun_akhir, ($file_type = 'pdf')]) }}"
                        class="btn btn-danger">PDF</a>
                    <a href="{{ route('laporan_shuttle_3_22.excel', ['22', 'shuttle3', $tahun_mula, $tahun_akhir, ($file_type = 'print')]) }}"
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
                    <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title }} Dari Tahun
                        {{ $tahun_mula }} Hingga {{ $tahun_akhir }}</div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="example" class="text-center table-bordered">
                                <thead style="background-color: #f3ce8f; font-weight: bold;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th>{{ $data }}</th>
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($datas as $negeri => $data_negeri)
                                        @php
                                            $jumlah_row = 0;
                                        @endphp

                                        <tr class="text-right">
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-left"> {{ $negeri }}</td>

                                            @foreach ($data_negeri as $tahun => $data)
                                                @php
                                                    $jumlah_col = 0;
                                                    $total[$tahun] = 0;
                                                @endphp
                                                <td>{{ number_format($data[0]->jumlah_penggunaan, 0) }}</td>
                                                @php
                                                    $jumlah_row = $jumlah_row + $data[0]->jumlah_penggunaan;
                                                    $total[$tahun] = $total[$tahun] + $data[0]->jumlah_penggunaan;
                                                @endphp
                                            @endforeach

                                            {{-- <td>{{ number_format($jumlah_row, 0) }}</td> --}}

                                        </tr>
                                    @endforeach

                                    <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                        <td class="text-center"></td>
                                        <td class="text-left">Jumlah</td>
                                        @foreach ($grandtotal as $jumlah)
                                            {{-- <td>{{ number_format($jumlah, 0) }}</td> --}}
                                        @endforeach
                                        <td>{{ number_format($jumlah, 0) }}</td>

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
