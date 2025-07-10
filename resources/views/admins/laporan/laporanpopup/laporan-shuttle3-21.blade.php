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
                    <a href="{{ route('laporan_shuttle_3_21.excel', ['21', $tahun, ($file_type = 'excel')]) }}"
                        class="btn btn-success">Excel</a>
                    <a href="{{ route('laporan_shuttle_3_21.excel', ['21', $tahun, ($file_type = 'pdf')]) }}"
                        class="btn btn-danger">PDF</a>
                    <a href="{{ route('laporan_shuttle_3_21.excel', ['21', $tahun, ($file_type = 'print')]) }}"
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
                            <table id="example" class="text-center table-bordered">
                                <thead style="background-color: #f3ce8f; font-weight: bold;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Jumlah')
                                                <th>{{ $data }} (m³)</th>
                                            @else
                                                <th>{{ $data }}</th>
                                            @endif
                                        @endforeach

                                    </tr>
                                </thead>
                                <tbody style="text-align: center">

                                    @php
                                        for ($bulan_counter = 1; $bulan_counter <= 12; $bulan_counter++) {
                                            $jumlah_column[$bulan_counter] = 0;
                                        }

                                        $jumlah_keseluruhan = 0;
                                    @endphp

                                    @foreach ($datas as $negeri => $data)
                                        @php
                                            $jumlah_m3 = 0;
                                        @endphp
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-left"> {{ $negeri }}</td>
                                            @foreach ($data as $bulan => $data_negeri)
                                                <td class="text-right">
                                                    {{ number_format($data_negeri[0]->jumlah_penggunaan, 0) }}
                                                </td>

                                                @php
                                                    $jumlah_m3 = $jumlah_m3 + $data_negeri[0]->jumlah_penggunaan;
                                                    $jumlah_column[$bulan] += $data_negeri[0]->jumlah_penggunaan;
                                                    $jumlah_keseluruhan += $data_negeri[0]->jumlah_penggunaan;
                                                @endphp
                                            @endforeach

                                            <td class="text-right">{{ number_format($jumlah_m3, 0) }}</td>

                                        </tr>
                                    @endforeach

                                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td class="text-left">Jumlah (m³)</td>

                                        @for ($bulan_counter = 1; $bulan_counter <= 12; $bulan_counter++)
                                            <td class="text-right">
                                                {{ number_format($jumlah_column[$bulan_counter], 0) }}</td>
                                        @endfor


                                        <td class="text-right">{{ number_format($jumlah_keseluruhan, 0) }}</td>
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
