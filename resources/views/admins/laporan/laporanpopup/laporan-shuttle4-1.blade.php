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
                    {{-- {{ dd($title) }} --}}
                    @if ($title == '1. Maklumat Penuh Senarai Kilang Papan Lapis/Venir')
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['1', $tahun, ($file_type = 'excel')]) }}"
                            class="btn btn-success">Excel</a>
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['1', $tahun, ($file_type = 'pdf')]) }}"
                            class="btn btn-danger">PDF</a>
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['1', $tahun, ($file_type = 'print')]) }}"
                            class="btn btn-warning">Print</a>
                    @elseif($title == '2. Senarai Pemilik Kilang Papan Lapis/Venir Bumiputera')
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['2', $tahun, ($file_type = 'excel')]) }}"
                            class="btn btn-success">Excel</a>
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['2', $tahun, ($file_type = 'pdf')]) }}"
                            class="btn btn-danger">PDF</a>
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['2', $tahun, ($file_type = 'print')]) }}"
                            class="btn btn-warning">Print</a>
                    @elseif($title == '3. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Bumiputera')
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['3', $tahun, ($file_type = 'excel')]) }}"
                            class="btn btn-success">Excel</a>
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['3', $tahun, ($file_type = 'pdf')]) }}"
                            class="btn btn-danger">PDF</a>
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['3', $tahun, ($file_type = 'print')]) }}"
                            class="btn btn-warning">Print</a>
                    @elseif($title == '4. Senarai Pemilik Kilang Papan Lapis/Venir Bukan Warganegara')
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['4', $tahun, ($file_type = 'excel')]) }}"
                            class="btn btn-success">Excel</a>
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['4', $tahun, ($file_type = 'pdf')]) }}"
                            class="btn btn-danger">PDF</a>
                        <a href="{{ route('laporan_shuttle_4_1.excel', ['4', $tahun, ($file_type = 'print')]) }}"
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
                                <thead class="text-center">
                                    <tr>
                                        @foreach ($columns as $data)
                                            @if ($data == 'Guna Tenaga')
                                                <th class="text-center" colspan="6">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Jenis')
                                                <th class="text-center" colspan="2" rowspan="2">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Papan Lapis Mengikut Ketebalan')
                                                <th class="text-center" colspan="2" rowspan="2">{{ $data }}</th>
                                            @elseif($data == 'Jumlah Pengeluaran Venir Mengikut Jenis')
                                                <th class="text-center" colspan="2" rowspan="2">{{ $data }}</th>
                                            @elseif($data == 'Jualan Eksport')
                                                <th class="text-center" colspan="2">{{ $data }}</th>
                                            @elseif($data == 'Jualan Tempatan')
                                                <th class="text-center" colspan="2">{{ $data }}</th>
                                            @else
                                                <th class="text-center" rowspan="3">{{ $data }}</th>
                                            @endif
                                        @endforeach
                                    </tr>
                                    <tr>
                                        <th colspan="2">Bumiputera</th>
                                        <th colspan="2">Bukan Bumiputera</th>
                                        <th colspan="2">Bukan Warganegara</th>

                                        <th rowspan="2">Penjualan Papan Lapis Eksport</th>
                                        <th rowspan="2">Penjualan Venir Eksport</th>

                                        <th rowspan="2">Penjualan Papan Lapis Tempatan</th>
                                        <th rowspan="2">Penjualan Venir Tempatan</th>
                                    </tr>
                                    <tr>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>
                                        <th>L</th>
                                        <th>P</th>

                                        <th>MR</th>
                                        <th>WBP</th>

                                        <th>Nipis</th>
                                        <th>Tebal</th>

                                        <th>Muka</th>
                                        <th>Teras</th>
                                    </tr>

                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th>RM</th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                        <th><span>m³</span></th>
                                    </tr>

                                </thead>
                                <tbody>


                                    @foreach ($data_shuttles as $data)
                                    <tr class="text-center">
                                        <td>{{ $loop->iteration }}</td>
                                        <td class="text-left">{{ $data->nama_kilang }}</td>
                                        <td class="text-left">{{ $data->no_ssm }}</td>
                                        <td class="text-left">{{ $data->no_lesen }}</td>
                                        <td class="text-left">{{ $data->no_telefon }}</td>
                                        <td class="text-left">{{ $data->no_faks ?? '-' }}</td>
                                        <td class="text-left">{{ $data->email }}</td>
                                        <td class="text-left">{{ $data->alamat_kilang_1 }}</td>
                                        <td class="text-left">{{ $data->alamat_kilang_2 }}</td>
                                        <td class="text-left">{{ $data->alamat_kilang_poskod }}</td>
                                        <td class="text-left">{{ $data->daerah_id }}</td>
                                        <td class="text-left">{{ $data->negeri_id }}</td>
                                        <td class="text-left">{{ $data->alamat_surat_menyurat_1 }}</td>
                                        <td class="text-left">{{ $data->alamat_surat_menyurat_2 }}</td>
                                        <td class="text-left">{{ $data->alamat_surat_menyurat_poskod }}</td>
                                        <td class="text-left">{{ $data->alamat_surat_menyurat_daerah }}</td>
                                        <td class="text-left">
                                            {{ Carbon\Carbon::parse($data->tarikh_tubuh)->format('d-m-Y') }}
                                        </td>
                                        <td class="text-left">
                                            {{ Carbon\Carbon::parse($data->tarikh_operasi)->format('d-m-Y') }}
                                        </td>
                                        <td class="text-left">{{ $data->taraf_syarikat_catatan }}
                                        </td>
                                        <td class="text-left">{{ $data->status_hak_milik }}</td>
                                        <td class="text-left">
                                            {{ number_format($data->nilai_harta, 2) }}</td>
                                        <td class="text-left">
                                            {{ Carbon\Carbon::parse($data->updated_at)->format('d-m-Y') }}
                                        </td>

                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_wargabumi_lelaki_laporan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_wargabumi_perempuan_laporan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_bukan_wargabumi_lelaki_laporan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_bukan_wargabumi_perempuan_laporan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_asing_lelaki_laporan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_guna_tenagas[$data->id]->pekerja_asing_perempuan_laporan, 0) }}</td>

                                        <td class="text-right">{{ number_format($data_kemasukan_bahans[$data->id]->baki_stok_kehadapan, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_kemasukan_bahans[$data->id]->jumlah_penggunaan, 0) }}</td>

                                        <td class="text-right">{{ number_format($produk_pengeluaran[$data->id]->jumlah_besar_mr, 0) }}</td>
                                        <td class="text-right">{{ number_format($produk_pengeluaran[$data->id]->jumlah_besar_wbp, 0) }}</td>

                                        @if ($produk_pengeluaran[$data->id])
                                        @php
                                            $nipis = $produk_pengeluaran[$data->id]->jumlah_kecil_1_mr + $produk_pengeluaran[$data->id]->jumlah_kecil_1_wbp ;
                                            $tebal = $produk_pengeluaran[$data->id]->jumlah_kecil_2_mr + $produk_pengeluaran[$data->id]->jumlah_kecil_2_wbp ;

                                        @endphp
                                         @endif

                                         <td class="text-right">{{ number_format($nipis, 0) }}</td>
                                         <td class="text-right">{{ number_format($tebal, 0) }}</td>

                                         <td class="text-right">{{ number_format($rekod_muka[$data->id]->rekod_veniermuka, 0) }}</td>
                                        <td class="text-right">{{ number_format($rekod_muka[$data->id]->rekod_venierteras, 0) }}</td>

                                        <td class="text-right">{{ number_format($data_form_d_s[$data->id]->export_papan_lapis, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_form_d_s[$data->id]->export_venier, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_form_d_s[$data->id]->domestik_papan_lapis, 0) }}</td>
                                        <td class="text-right">{{ number_format($data_form_d_s[$data->id]->domestik_venier, 0) }}</td>
                                    </tr>
                                    @endforeach


                                </tbody>
                            </table>

                        </div>
                    </div>
                </div>


            </div>
            <div class="col-5 align-self-center">
                <a href="{{ $returnArr['kembali'] }}" class="btn btn-primary">Kembali</a>
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
