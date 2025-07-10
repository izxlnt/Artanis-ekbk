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
                    <a href="{{ route('getreport_senaraikilang.excel', [$shuttle,$statuspemilik,($tahun = $tahun),$title,($file_type = 'excel')]) }}"
                        class="btn btn-success">Excel</a>
                    <a href="{{ route('getreport_senaraikilang.excel', [$shuttle,$statuspemilik,($tahun = $tahun),$title,($file_type = 'pdf')]) }}"
                        class="btn btn-danger">PDF</a>
                    <a href="{{ route('getreport_senaraikilang.excel', [$shuttle,$statuspemilik,($tahun = $tahun),$title,($file_type = 'pdf')]) }}"
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
                    <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title_laporan }} Bagi Tahun
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
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                        <th><span >m³</span></th>
                                    </tr>

                                </thead>
                                <tbody>


                                    @foreach ($results as $result)
                                        <tr class="text-center">
                                            <td> {{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $result->rekod_namakilang ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_nossm ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_nolesen ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_notel ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_nofaks ?? '-' }}</td>
                                            <td class="text-left">{{ $result->rekod_email ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_alamatkilang_jalan1 ?? '' }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_alamatkilang_jalan2 ?? '' }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_alamatkilang_poskod ?? '' }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_daerah ?? ('' ?? '') }}</td>
                                            <td class="text-left">{{ $result->rekod_negeri ?? '' }}</td>

                                            <td class="text-left">N/A</td>
                                            <td class="text-left">N/A</td>
                                            <td class="text-left">N/A</td>
                                            <td class="text-left">N/A</td>



                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($result->rekod_tarikhtubuh ?? '')->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($result->rekod_tarikhoperasi ?? '')->format('d-m-Y') }}
                                            </td>
                                            <td class="text-left">{{ $result->rekod_tarafsyarikat ?? '' }}</td>
                                            <td class="text-left">{{ $result->rekod_statushakmilik ?? '' }}</td>
                                            <td class="text-left">{{ number_format($result->rekod_nilaiharta, 2) }}
                                            </td>
                                            <td class="text-left">
                                                {{ Carbon\Carbon::parse($result->rekod_modified_on ?? '')->format('d-m-Y') }}
                                            </td>
                                            <td class="text-right">{{ $result->guna_tenaga->sum_wargabumi_l ?? 0 }}
                                            </td>
                                            <td class="text-right">{{ $result->guna_tenaga->sum_wargabumi_p ?? 0 }}
                                            </td>
                                            <td class="text-right">
                                                {{ $result->guna_tenaga->sum_wargabukanbumi_l ?? 0 }}</td>
                                            <td class="text-right">
                                                {{ $result->guna_tenaga->sum_wargabukanbumi_p ?? 0 }}</td>
                                            <td class="text-right">{{ $result->guna_tenaga->sum_bukanwarga_l ?? 0 }}
                                            </td>
                                            <td class="text-right">{{ $result->guna_tenaga->sum_bukanwarga_p ?? 0 }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($result->jumlahstoksemasa, 0) }}
                                            </td>
                                            <td class="text-right">{{ number_format($result->jumlahpenggunaan, 0) }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($result->jumlahpengeluaran->jumlahmr, 0) }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($result->jumlahpengeluaran->jumlahwbp, 0) }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($result->jumlahpengeluaran->nipis, 0) }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($result->jumlahpengeluaran->tebal, 0) }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($result->jumlahpengeluaran->muka, 0) }}
                                            </td>
                                            <td class="text-right">
                                                {{ number_format($result->jumlahpengeluaran->teras, 0) }}
                                            </td>
                                            <td class="text-right">{{ number_format($result->jumlaheksportlapis, 0) }}
                                            </td>
                                            <td class="text-right">{{ number_format($result->jumlaheksportvenier, 0) }}
                                            </td>
                                            <td class="text-right">{{ number_format($result->jumlahtempatanlapis, 0) }}
                                            </td>
                                            <td class="text-right">{{ number_format($result->jumlahtempatanvenier, 0) }}
                                            </td>

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

    <script>
        $(document).ready(function() {
            var title = {!! json_encode($title) !!};
            var tahun = {!! json_encode($tahun) !!};

            var title = title + " Bagi Tahun " + tahun;

            var t = $('#example').DataTable({
                dom: 'Bfrtip',
                paging: false,
                scrollY: 750,
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
