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
                    @if ($title == '1. Maklumat Penuh Senarai Kilang Papan')
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['1', $tahun, ($file_type = 'excel')]) }}"
                            class="btn btn-success">Excel</a>
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['1', $tahun, ($file_type = 'pdf')]) }}"
                            class="btn btn-danger">PDF</a>
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['1', $tahun, ($file_type = 'print')]) }}"
                            class="btn btn-warning">Print</a>
                    @elseif($title == '2. Senarai Pemilik Kilang Papan Bumiputera')
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['2', $tahun, ($file_type = 'excel')]) }}"
                            class="btn btn-success">Excel</a>
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['2', $tahun, ($file_type = 'pdf')]) }}"
                            class="btn btn-danger">PDF</a>
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['2', $tahun, ($file_type = 'print')]) }}"
                            class="btn btn-warning">Print</a>
                    @elseif($title == '3. Senarai Pemilik Kilang Papan Bukan Bumiputera')
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['3', $tahun, ($file_type = 'excel')]) }}"
                            class="btn btn-success">Excel</a>
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['3', $tahun, ($file_type = 'pdf')]) }}"
                            class="btn btn-danger">PDF</a>
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['3', $tahun, ($file_type = 'print')]) }}"
                            class="btn btn-warning">Print</a>
                    @elseif($title == '4. Senarai Pemilik Kilang Papan Bukan Warganegara')
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['4', $tahun, ($file_type = 'excel')]) }}"
                            class="btn btn-success">Excel</a>
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['4', $tahun, ($file_type = 'pdf')]) }}"
                            class="btn btn-danger">PDF</a>
                        <a href="{{ route('laporan_shuttle_3_1.excel', ['4', $tahun, ($file_type = 'print')]) }}"
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


                                    @foreach ($shuttle as $kilang)
                                        <tr class="text-center">
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->nama_kilang }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->no_ssm }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->no_lesen }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->no_telefon }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->no_faks ?? '-' }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->email }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->alamat_kilang_1 }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->alamat_kilang_2 }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->alamat_kilang_poskod }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->daerah_id }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->negeri_id }}</td>
                                            <td class="text-left">{{ $kilang->shuttle->alamat_surat_menyurat_1 }}
                                            </td>
                                            <td class="text-left">{{ $kilang->shuttle->alamat_surat_menyurat_2 }}
                                            </td>
                                            <td class="text-left">
                                                {{ $kilang->shuttle->alamat_surat_menyurat_poskod }}</td>
                                            <td class="text-left">
                                                {{ $kilang->shuttle->alamat_surat_menyurat_daerah }}</td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_tubuh)->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($kilang->shuttle->tarikh_operasi)->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">{{ $kilang->shuttle->taraf_syarikat_catatan }}
                                            </td>
                                            <td class="text-left">{{ $kilang->shuttle->status_hak_milik }}</td>
                                            <td class="text-left">
                                                {{ number_format($kilang->shuttle->nilai_harta, 2) }}</td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($kilang->shuttle->updated_at)->format('d-m-Y') }}
                                            </td>

                                            @php

                                                $bumi_l = 0;
                                                $bumi_p = 0;

                                                $non_bumi_l = 0;
                                                $non_bumi_p = 0;

                                                $non_warga_l = 0;
                                                $non_warga_p = 0;

                                                if ($form_b->count() != 0) {
                                                    foreach ($form_b as $borang_b) {
                                                        if ($borang_b->shuttle_id == $kilang->shuttle->id) {
                                                            foreach ($guna_tenaga as $workload) {
                                                                if ($workload->formbs_id == $borang_b->id) {
                                                                    //wargabumi
                                                                    // if ($workload->pekerja_wargabumi_lelaki_laporan != 0) {
                                                                    $bumi_l = $bumi_l + $workload->pekerja_wargabumi_lelaki_laporan;
                                                                    // } else {
                                                                    //     $bumi_l = $bumi_l + $workload->pekerja_wargabumi_lelaki_laporan;
                                                                    // }

                                                                    // if ($workload->pekerja_wargabumi_perempuan_laporan != 0) {
                                                                    $bumi_p = $bumi_p + $workload->pekerja_wargabumi_perempuan_laporan;
                                                                    // } else {
                                                                    //     $bumi_p = $bumi_p + $workload->pekerja_wargabumi_perempuan_laporan;
                                                                    // }

                                                                    //bukan wargabumi
                                                                    // if ($workload->pekerja_bukan_wargabumi_lelaki_laporan != 0) {
                                                                    $non_bumi_l = $non_bumi_l + $workload->pekerja_bukan_wargabumi_lelaki_laporan;
                                                                    // } else {
                                                                    //     $non_bumi_l = $non_bumi_l + $workload->pekerja_bukan_wargabumi_lelaki_laporan;
                                                                    // }

                                                                    if ($workload->pekerja_bukan_wargabumi_perempuan_laporan != 0) {
                                                                        $non_bumi_p = $non_bumi_p + $workload->pekerja_bukan_wargabumi_perempuan_laporan;
                                                                    } else {
                                                                        $non_bumi_p = $non_bumi_p + $workload->pekerja_bukan_wargabumi_perempuan_laporan;
                                                                    }

                                                                    //bukan warganegara
                                                                    // if ($workload->pekerja_asing_lelaki_laporan != 0) {
                                                                    $non_warga_l = $non_warga_l + $workload->pekerja_asing_lelaki_laporan;
                                                                    // } else {
                                                                    //     $non_warga_l = $non_warga_l + $workload->pekerja_asing_lelaki_laporan;
                                                                    // }

                                                                    // if ($workload->pekerja_asing_perempuan_laporan != 0) {
                                                                    $non_warga_p = $non_warga_p + $workload->pekerja_asing_perempuan_laporan;
                                                                    // } else {
                                                                    //     $non_warga_p = $non_warga_p + $workload->pekerja_asing_perempuan_laporan;
                                                                    // }
                                                                }
                                                            }
                                                        }
                                                    }
                                                }

                                            @endphp

                                            <td class="text-right">{{ number_format($bumi_l, 0) }}</td>
                                            <td class="text-right">{{ number_format($bumi_p, 0) }}</td>
                                            <td class="text-right">{{ number_format($non_bumi_l, 0) }}</td>
                                            <td class="text-right">{{ number_format($non_bumi_p, 0) }}</td>
                                            <td class="text-right">{{ number_format($non_warga_l, 0) }}</td>
                                            <td class="text-right">{{ number_format($non_warga_p, 0) }}</td>


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

                                            @foreach ($datas_formc as $data_c)
                                                @if ($data_c->shuttle_id == $kilang->shuttle->id)
                                                    @php
                                                        $baki_stok_kehadapan += $data_c->baki_stok_kehadapan;
                                                        $jumlah_penggunaan += $data_c->jumlah_penggunaan;
                                                    @endphp
                                                @endif
                                            @endforeach
                                            <td class="text-right">{{ number_format($baki_stok_kehadapan, 0) }}</td>

                                            <td class="text-right">{{ number_format($jumlah_penggunaan, 0) }}</td>

                                            @foreach ($produk_pengeluaran as $produk)
                                                @if ($produk->shuttle_id == $kilang->shuttle->id)
                                                    @php
                                                        $jumlah_besar_mr += $produk->jumlah_besar_mr;
                                                        $jumlah_besar_wbp += $produk->jumlah_besar_wbp;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            <td class="text-right">{{ number_format($jumlah_besar_mr, 0) }}</td>
                                            <td class="text-right">{{ number_format($jumlah_besar_wbp, 0) }}</td>

                                            @foreach ($produk_pengeluaran as $produk)
                                                @if ($produk->shuttle_id == $kilang->shuttle->id)
                                                    @php
                                                        $nipis = $produk->jumlah_kecil_1_mr + $produk->jumlah_kecil_1_wbp ;
                                                        $tebal = $produk->jumlah_kecil_2_mr + $produk->jumlah_kecil_2_wbp ;

                                                    @endphp
                                                @endif
                                            @endforeach

                                            <td class="text-right">{{ number_format($nipis, 0) }}</td>
                                            <td class="text-right">{{ number_format($tebal, 0) }}</td>

                                            @foreach ($rekod_muka as $jenis)
                                                @if ($jenis->shuttle_id == $kilang->shuttle->id)
                                                    @php
                                                        $muka = $jenis->rekod_veniermuka ;
                                                        $teras = $jenis->rekod_venierteras ;

                                                    @endphp
                                                @endif
                                            @endforeach

                                            <td class="text-right">{{ number_format($muka, 0) }}</td>
                                            <td class="text-right">{{ number_format($teras, 0) }}</td>


                                            @foreach ($datas_formd as $data_d)
                                                @if ($data_d->shuttle_id == $kilang->shuttle->id)
                                                    @php
                                                        $export_papan_lapis += $data_d->export_papan_lapis;
                                                        $export_venier += $data_d->export_venier;
                                                        $domestik_papan_lapis += $data_d->domestik_papan_lapis;
                                                        $domestik_venier += $data_d->domestik_venier;
                                                    @endphp
                                                @endif
                                            @endforeach

                                            <td class="text-right">{{ number_format($export_papan_lapis, 0) }}</td>
                                            <td class="text-right">{{ number_format($export_venier, 0) }}</td>
                                            <td class="text-right">{{ number_format($domestik_papan_lapis, 0) }}</td>
                                            <td class="text-right">{{ number_format($domestik_venier, 0) }}</td>

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
