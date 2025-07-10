@extends('layouts.layout-ipjpsm-nicepage')

@section('content')
    <style type="text/css" media="print">
        @page {
            size: landscape;
        }

    </style>

    <link href="{{ asset('https://cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css') }}" rel="stylesheet" />


    <script src="{{ asset('https://code.jquery.com/jquery-3.5.1.js') }}"></script>
    <script src="{{ asset('https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js') }}"></script>


    <div class="container-fluid">
        <div class="page-breadcrumb" style="padding: 0px">
            <div class="pb-2 row">
                <div class="col-5 align-self-center">
                    <a href="{{ $returnArr['kembali'] }}" class="btn btn-primary">Kembali</a>
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
                    <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title }}</div>
                    <div class="text-center card-body">
                        <div class="row">
                            <div class="col-md">
                                <div class="table-responsive">
                                    <table id="example" class="table-bordered">
                                        <thead style="background-color: #f3ce8f; font-weight: bold;">
                                            <tr>
                                                @foreach ($columns as $data)
                                                    @if ($data == 'Guna Tenaga')
                                                        <th class="text-center" colspan="6">{{ $data }}</th>
                                                    @elseif($data == 'Nilai Harta Tetap Pada Tahun Berakhir')
                                                        <th class="text-center" rowspan="2">{{ $data }}</th>
                                                    @elseif($data == 'Jumlah Penggunaan Kayu Balak')
                                                        <th class="text-center" rowspan="2">{{ $data }}</th>
                                                    @elseif($data == 'Jumlah Pengeluaran Kayu Gergaji')
                                                        <th class="text-center" rowspan="2">{{ $data }}</th>
                                                    @elseif($data == 'Penjualan Kayu Gergaji Eksport')
                                                        <th class="text-center" rowspan="2">{{ $data }}</th>
                                                    @elseif($data == 'Penjualan Kayu Gergaji Tempatan')
                                                        <th class="text-center" rowspan="2">{{ $data }}</th>
                                                    @else
                                                        <th class="text-center" rowspan="3">{{ $data }}</th>
                                                    @endif
                                                @endforeach
                                            </tr>
                                            <tr>
                                                <th class="text-center" colspan="2">Bumiputera</th>
                                                <th class="text-center" colspan="2">Bukan Bumiputera</th>
                                                <th class="text-center" colspan="2">Bukan Warganegara</th>


                                            </tr>
                                            <tr class="text-center">
                                                <th>RM</th>
                                                <th>L</th>
                                                <th>P</th>
                                                <th>L</th>
                                                <th>P</th>
                                                <th>L</th>
                                                <th>P</th>
                                                <th>m3</th>
                                                <th>m3</th>
                                                <th>m3</th>
                                                <th>m3</th>
                                            </tr class="text-center">

                                        </thead>
                                        <tbody>

                                            @foreach ($shuttle as $kilang)
                                                <tr class="text-center">
                                                    <td> {{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $kilang->shuttle->nama_kilang }}</td>
                                                    <td>{{ $kilang->shuttle->no_ssm }}</td>
                                                    <td>{{ $kilang->shuttle->no_lesen }}</td>
                                                    <td>{{ $kilang->shuttle->no_telefon }}</td>
                                                    <td>{{ $kilang->shuttle->no_faks ?? '-' }}</td>
                                                    <td>{{ $kilang->shuttle->email }}</td>
                                                    <td>{{ $kilang->shuttle->alamat_kilang_1 }}</td>
                                                    <td>{{ $kilang->shuttle->alamat_kilang_2 }}</td>
                                                    <td>{{ $kilang->shuttle->alamat_kilang_poskod }}</td>
                                                    <td>{{ $kilang->shuttle->daerah_id }}</td>
                                                    <td>{{ $kilang->shuttle->negeri_id }}</td>
                                                    <td>{{ Carbon\Carbon::parse($kilang->shuttle->tarikh_tubuh)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ Carbon\Carbon::parse($kilang->shuttle->tarikh_operasi)->format('d-m-Y') }}
                                                    </td>
                                                    <td>{{ $kilang->shuttle->taraf_syarikat_catatan }}</td>
                                                    <td>{{ $kilang->shuttle->status_hak_milik }}</td>
                                                    <td>{{ number_format($kilang->shuttle->nilai_harta, 2) }}</td>
                                                    <td>{{ Carbon\Carbon::parse($kilang->shuttle->updated_at)->format('d-m-Y') }}
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
                                                                            if ($workload->pekerja_wargabumi_lelaki_cleaning != 0) {
                                                                                $bumi_l = $bumi_l + $workload->pekerja_wargabumi_lelaki_cleaning;
                                                                            } else {
                                                                                $bumi_l = $bumi_l + $workload->pekerja_wargabumi_lelaki;
                                                                            }

                                                                            if ($workload->pekerja_wargabumi_perempuan_cleaning != 0) {
                                                                                $bumi_p = $bumi_p + $workload->pekerja_wargabumi_perempuan_cleaning;
                                                                            } else {
                                                                                $bumi_p = $bumi_p + $workload->pekerja_wargabumi_perempuan;
                                                                            }

                                                                            //bukan wargabumi
                                                                            if ($workload->pekerja_bukan_wargabumi_lelaki_cleaning != 0) {
                                                                                $non_bumi_l = $non_bumi_l + $workload->pekerja_bukan_wargabumi_lelaki_cleaning;
                                                                            } else {
                                                                                $non_bumi_l = $non_bumi_l + $workload->pekerja_bukan_wargabumi_lelaki;
                                                                            }

                                                                            if ($workload->pekerja_bukan_wargabumi_perempuan_cleaning != 0) {
                                                                                $non_bumi_p = $non_bumi_p + $workload->pekerja_bukan_wargabumi_perempuan_cleaning;
                                                                            } else {
                                                                                $non_bumi_p = $non_bumi_p + $workload->pekerja_bukan_wargabumi_perempuan;
                                                                            }

                                                                            //bukan warganegara
                                                                            if ($workload->pekerja_asing_lelaki_cleaning != 0) {
                                                                                $non_warga_l = $non_warga_l + $workload->pekerja_asing_lelaki_cleaning;
                                                                            } else {
                                                                                $non_warga_l = $non_warga_l + $workload->pekerja_asing_lelaki;
                                                                            }

                                                                            if ($workload->pekerja_asing_perempuan_cleaning != 0) {
                                                                                $non_warga_p = $non_warga_p + $workload->pekerja_asing_perempuan_cleaning;
                                                                            } else {
                                                                                $non_warga_p = $non_warga_p + $workload->pekerja_asing_perempuan;
                                                                            }
                                                                        }
                                                                    }
                                                                }
                                                            }
                                                        }

                                                    @endphp

                                                    <td>{{ $bumi_l }}</td>
                                                    <td>{{ $bumi_p }}</td>
                                                    <td>{{ $non_bumi_l }}</td>
                                                    <td>{{ $non_bumi_p }}</td>
                                                    <td>{{ $non_warga_l }}</td>
                                                    <td>{{ $non_warga_p }}</td>

                                                    @php
                                                        $jumlah_guna_balak = 0;
                                                        $jumlah_keluar_gergaji = 0;
                                                        $jumlah_jual_gergaji_eksport = 0;
                                                        $jumlah_jual_gergaji_local = 0;

                                                        if ($form_d->count() != 0) {
                                                            foreach ($form_d as $borang_d) {
                                                                if ($borang_d->shuttle_id == $kilang->shuttle->id) {
                                                                    $jumlah_jual_gergaji_eksport = $jumlah_jual_gergaji_eksport + $borang_d->total_export;
                                                                    $jumlah_jual_gergaji_local = $jumlah_jual_gergaji_local + $borang_d->jumlah_pasaran_tempatan;

                                                                    // foreach($penjualan_pembeli as $sell){
                                                                    //     if($sell->formds_id == $borang_d->id){

                                                                    //     }
                                                                    // }
                                                                }
                                                            }
                                                        }
                                                    @endphp

                                                    <td>{{ $jumlah_guna_balak }}</td>
                                                    <td>{{ $jumlah_keluar_gergaji }}</td>
                                                    <td>{{ $jumlah_jual_gergaji_eksport }}</td>
                                                    <td>{{ $jumlah_jual_gergaji_local }}</td>

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
        </div>
    </div>

    <script>
        // document.addEventListener("DOMContentLoaded", () => {
        //     Livewire.hook('component.initialized', (component) => {
        //         console.log(component);
        //         $(document).ready(function() {
        //             $('#example').DataTable();
        //         });
        //     })
        // });
    </script>

    <script>
        $(document).ready(function() {
            var table = $('#example').DataTable({
                ordering: false,
                "language": {
                    "lengthMenu": "Memaparkan _MENU_ rekod per halaman",
                    "zeroRecords": "Maaf, tiada rekod.",
                    "info": "Memaparkan halaman _PAGE_ dari _PAGES_",
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

        $(window).on('changed', (e) => {
            // if($('#example').DataTable().clear().destroy()){
            // $('#example').DataTable();
            // }
        });

        // document.getElementById("form_type").onchange = function() {
        //     myFunction()
        // };

        // function myFunction() {
        //     console.log('asasa');
        //     table.clear().draw();
        // }
    </script>

    <script src="{{ asset('nice-admin/dist/js/pages/samplepages/jquery.PrintArea.js') }}"></script>


    <script>
        $(function() {
            $("#print").click(function() {
                var mode = 'iframe'; //popup
                var close = mode == "popup";
                var options = {
                    mode: mode,
                    popClose: close
                };
                $("div.printablearea").printArea(options);
            });
        });
    </script>

    <script src="https://cdn.datatables.net/buttons/1.6.5/js/dataTables.buttons.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.flash.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.html5.min.js"></script>
    <script src="https://cdn.datatables.net/buttons/1.6.5/js/buttons.print.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>

    {{-- data table --}}
    <script type="text/javascript">
        // Responsive Data Table
        let laporan = $("#laporan")
        var t = $(laporan).DataTable({
            "responsive": true,

            //start sini untuk print
            "dom": 'Bfrtip',
            "buttons": [
                'excel',
                {
                    extend: 'pdfHtml5',
                    orientation: 'landscape',
                    pageSize: 'A4',
                    title: '{{ $title }}',
                },
                {
                    extend: 'print',
                    orientation: 'landscape',

                    text: 'Cetak',
                    pageSize: 'LEGAL',
                    title: '{{ $title }}',
                    customize: function(win) {

                        var last = null;
                        var current = null;
                        var bod = [];

                        var css = '@page { size: landscape; }',
                            head = win.document.head || win.document.getElementsByTagName('head')[0],
                            style = win.document.createElement('style');

                        style.type = 'text/css';
                        style.media = 'print';

                        if (style.styleSheet) {
                            style.styleSheet.cssText = css;
                        } else {
                            style.appendChild(win.document.createTextNode(css));
                        }

                        head.appendChild(style);
                    },
                },
            ],

            //end sini

            //ini untuk paparkan rekod per halaman
            "scrollX": true,
            "columnDefs": [{
                "searchable": false,
                "orderable": false,
                "targets": 0
            }],
            "order": [
                [1, 'asc']
            ],
            "language": {
                "lengthMenu": "Memaparkan _MENU_ rekod per halaman",
                "zeroRecords": "Maaf, tiada rekod.",
                "info": "Memaparkan halaman _PAGE_ dari _PAGES_",
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
            responsive: true,
            columnDefs: [{
                "targets": "_all", // your case first column
                "className": "text-center",
            }, ],
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
    </script>
@endsection
