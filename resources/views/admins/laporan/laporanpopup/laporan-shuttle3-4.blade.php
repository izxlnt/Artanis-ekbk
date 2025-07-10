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
                    <div class="card-body">
                        <h4 class="card-title">{{ $title }}</h4>
                    </div>
                    {{-- <div class="" style="text-align: center">
                        <a href="{{ route('ShuttleExcel', 'xls') }}"><button class="mdi mdi-file-excel">Jana
                                Laporan</button></a>
                        <button class="mdi mdi-printer" id="print">Print</button>
                    </div> --}}
                    <br>
                    <div class="row">
                        <div class="col-md-1"></div>
                        <div class="col-md-10">
                            <div class="printablearea">
                                <div class="table-responsive">
                                    <table id="laporan" class="table-bordered">
                                        <thead style="background-color: #f3ce8f; font-weight: bold;">
                                            <tr>
                                                @foreach ($columns as $data)
                                                    @if ($data == 'Guna Tenaga')
                                                        <th colspan="6">{{ $data }}</th>
                                                    @else
                                                        <th>{{ $data }}</th>
                                                    @endif
                                                @endforeach
                                            </tr>
                                            <tr>

                                                <th colspan="18">
                                                    </td>
                                                <th colspan="2">Bumiputera</th>
                                                <th colspan="2">Bukan Bumiputera</th>
                                                <th colspan="2">Bukan Warganegara</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>

                                            </tr>
                                            <tr>
                                                <th colspan="18"></th>
                                                <th>L</th>
                                                <th>P</th>
                                                <th>L</th>
                                                <th>P</th>
                                                <th>L</th>
                                                <th>P</th>
                                                <th></th>
                                                <th></th>
                                                <th></th>
                                                <th></th>

                                            </tr>
                                        </thead>
                                        <tbody>

                                            @foreach ($shuttles as $key => $data)
                                                @if ($data->shuttle->status_warganegara == 'Bukan Warganegara')
                                                    <tr class="text-center">
                                                        <td> {{ $i = $loop->iteration }}</td>
                                                        <td>{{ $data->shuttle->nama_kilang }}</td>
                                                        <td>{{ $data->shuttle->no_ssm }}</td>
                                                        <td>{{ $data->shuttle->no_lesen }}</td>
                                                        <td>{{ $data->shuttle->no_telefon }}</td>
                                                        <td>{{ $data->shuttle->no_faks }}</td>
                                                        <td>{{ $data->shuttle->email }}</td>
                                                        <td>{{ $data->shuttle->alamat_kilang_1 }}</td>
                                                        <td>{{ $data->shuttle->alamat_kilang_2 }}</td>
                                                        <td>{{ $data->shuttle->alamat_kilang_poskod }}</td>
                                                        <td>{{ $data->shuttle->daerah_id }}</td>
                                                        <td>{{ $data->shuttle->negeri_id }}</td>
                                                        <td>{{ $data->shuttle->tarikh_tubuh }}</td>
                                                        <td>{{ $data->shuttle->tarikh_operasi }}</td>
                                                        <td>{{ $data->shuttle->taraf_syarikat_catatan }}</td>
                                                        <td>{{ $data->shuttle->status_hak_milik }}</td>
                                                        <td>{{ $data->shuttle->nilai_harta }}</td>
                                                        <td>{{ $data->shuttle->updated_at }}</td>

                                                        <td>{{ $guna_tenaga[$key]->total_bumi_lelaki }}</td>
                                                        <td>{{ $guna_tenaga[$key]->total_bumi_perempuan }}</td>
                                                        <td>{{ $guna_tenaga[$key]->total_bukanbumi_lelaki }}</td>
                                                        <td>{{ $guna_tenaga[$key]->total_bukanbumi_perempuan }}</td>
                                                        <td>{{ $guna_tenaga[$key]->total_asing_lelaki }}</td>
                                                        <td>{{ $guna_tenaga[$key]->total_asing_perempuan }}</td>
                                                        <td>{{ $pengeluaran[$key]->total_jumlah_jualan }}</td>
                                                        <td>{{ $jumlah_pengeluaran[$key]->jumlah_besar_pengeluaran_kayu_daripada_jentera ?? 'Borang C masih belum diisi' }}
                                                        </td>
                                                        <td>{{ $formD[$key]->total_export }}</td>
                                                        <td>{{ $formD[$key]->jumlah_pasaran_tempatan }}</td>

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
            var table = $('#example').DataTable();
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
