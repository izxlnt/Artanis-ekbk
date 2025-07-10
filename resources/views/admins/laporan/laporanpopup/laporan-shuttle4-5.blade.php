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


                    @if ($title == '5. Top 10 Pengeluar Papan Lapis di Kilang Papan Lapis/Venir')
                        <a href="{{ route('laporan_shuttle_4_5.excel', ['5', $tahun, ($file_type = 'excel'), ($spesies = 'no_species')]) }}"
                            class="btn btn-success">Excel</a>
                        <a href="{{ route('laporan_shuttle_4_5.excel', ['5', $tahun, ($file_type = 'pdf'), ($spesies = 'no_species')]) }}"
                            class="btn btn-danger">PDF</a>
                        <a href="{{ route('laporan_shuttle_4_5.excel', ['5', $tahun, ($file_type = 'print'), ($spesies = 'no_species')]) }}"
                            class="btn btn-warning">Print</a>
                    @elseif($title == '6. Top 10 Pengeluar Venir di Kilang Papan Lapis/Venir')
                        <a href="{{ route('laporan_shuttle_4_5.excel', ['6', $tahun, ($file_type = 'excel'), $spesies]) }}"
                            class="btn btn-success">Excel</a>
                        <a href="{{ route('laporan_shuttle_4_5.excel', ['6', $tahun, ($file_type = 'pdf'), $spesies]) }}"
                            class="btn btn-danger">PDF</a>
                        <a href="{{ route('laporan_shuttle_4_5.excel', ['6', $tahun, ($file_type = 'print'), ($spesies)]) }}"
                            class="btn btn-warning">Print</a>
                    @endif
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
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Jenis')
                                                <th class="text-center" colspan="2" rowspan="1">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan')
                                                <th class="text-center" colspan="2" rowspan="1">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Papan Venir Mengikut Jenis')
                                                <th class="text-center" colspan="2" rowspan="1">{{ $data }}</th>
                                            @else
                                                <th class="text-center" rowspan="3">{{ $data }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>

                                            <th class="text-center">MR</th>
                                            <th class="text-center">WBP</th>
                                            <th class="text-center">Nipis</th>
                                            <th class="text-center">Tebal</th>

                                    </tr>
                                    <tr>

                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>
                                            <th class="text-center">m³</th>

                                    </tr>
                                </thead>
                                <tbody>

                                    @foreach ($datas_formc as $kilang)
                                    @if($kilang->jumlah_penggunaan > 0)


                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $kilang->nama_kilang }}</td>
                                            <td class="text-left">{{ $kilang->no_ssm }}</td>
                                            <td class="text-left">{{ $kilang->no_lesen }}</td>
                                            <td class="text-left">{{ $kilang->no_telefon }}</td>
                                            <td class="text-left">{{ $kilang->no_faks ?? '-' }}</td>
                                            <td class="text-left">{{ $kilang->email }}</td>
                                            <td class="text-left">{{ $kilang->alamat_kilang_1 }}</td>
                                            <td class="text-left">{{ $kilang->alamat_kilang_2 }}</td>
                                            <td class="text-left">{{ $kilang->alamat_kilang_poskod }}</td>
                                            <td class="text-left">{{ $kilang->daerah_id }}</td>
                                            <td class="text-left">{{ $kilang->negeri_id }}</td>
                                            <td class="text-left">{{ $kilang->alamat_surat_menyurat_1 }}
                                            </td>
                                            <td class="text-left">{{ $kilang->alamat_surat_menyurat_2 }}
                                            </td>
                                            <td class="text-left">
                                                {{ $kilang->alamat_surat_menyurat_poskod }}</td>
                                            <td class="text-left">
                                                {{ $kilang->alamat_surat_menyurat_daerah }}</td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($kilang->tarikh_tubuh)->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($kilang->tarikh_operasi)->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">{{ $kilang->taraf_syarikat_catatan }}
                                            </td>
                                            <td class="text-left">{{ $kilang->status_hak_milik }}</td>

                                            @php
                                            $jumlah_penggunaan = 0;
                                            $baki_stok_kehadapan = 0;
                                            $jumlah_besar_mr = 0;
                                            $jumlah_besar_wbp = 0;
                                            $export_papan_lapis = 0;
                                            $export_venier = 0;
                                            $domestik_papan_lapis = 0;
                                            $domestik_venier = 0;


                                            $export = 0;
                                            $domestik = 0;
                                        @endphp

                                            @foreach ($produk_pengeluaran as $produk)
                                                @if ($produk->shuttle_id == $kilang->id)
                                                    @php
                                                        $jumlah_besar_mr += $produk->jumlah_besar_mr;
                                                        $jumlah_besar_wbp += $produk->jumlah_besar_wbp;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            <td class="text-right">{{ number_format($jumlah_besar_mr, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_besar_wbp, 0) }}</td>

                                            @foreach ($produk_pengeluaran as $produk)
                                                @if ($produk->shuttle_id == $kilang->id)
                                                    @php
                                                        $nipis = $produk->jumlah_kecil_1_mr + $produk->jumlah_kecil_1_wbp ;
                                                        $tebal = $produk->jumlah_kecil_2_mr + $produk->jumlah_kecil_2_wbp ;

                                                    @endphp
                                                @endif
                                            @endforeach

                                            <td class="text-right">{{ number_format($nipis, 0) }}</td>
                                            <td class="text-right">{{ number_format($tebal, 0) }}</td>
                                        </tr>
                                        @endif

                                    @endforeach

                                </tbody>
                            </table>



                        </div>
                    </div>
                </div>


            </div>
        </div>
        <div class="col-5 align-self-center">
            <a href="{{ $returnArr['kembali'] }}" class="btn btn-primary">Kembali</a>
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
                scrollY: 680,
                scrollX: true,
                scrollCollapse: true,
                ordering: false,
                searching: false,
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
