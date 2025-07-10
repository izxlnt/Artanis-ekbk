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
                    <a href="{{ route('getreport_pengeluaran_bykumpulankayu_bytahun.excel', [$shuttle, $tahun, $tahunakhir, $title, $file_type = 'excel']) }}" class="btn btn-success">Excel</a>
                    <a href="{{ route('getreport_pengeluaran_bykumpulankayu_bytahun.excel', [$shuttle, $tahun, $tahunakhir, $title, $file_type = 'pdf']) }}" class="btn btn-danger">PDF</a>
                    <a href="{{ route('getreport_pengeluaran_bykumpulankayu_bytahun.excel', [$shuttle, $tahun, $tahunakhir, $title, $file_type = 'pdf']) }}" class="btn btn-warning">Print</a>
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
                        {{ $tahun }} Hingga {{ $tahunakhir }}</div>
                    <div class="card-body">


                        <div class="table-responsive">
                            <table id="example" class="text-center table-bordered" style="width: 100%;">
                                <thead style="background-color: #f3ce8f;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th>{{ $data }}</th>
                                        @endforeach
                                    </tr>
                                </thead>
                                @foreach ($results as $data)
                                    @foreach ($data->jumlahpengeluaran as $key => $value)
                                        @php
                                            $jumlah_besar[$key] = 0;
                                            $jumlah_besar_kumpulan = 0;
                                        @endphp
                                    @endforeach
                                @break
                            @endforeach
                            <tbody style="text-align: center">
                                @foreach ($kumpulan_kayu as $kayu)
                                    <tr style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td class="text-left">{{ $kayu->singkatan }}</td>
                                        @foreach ($results as $data)
                                            @foreach ($data->jumlahpengeluaran as $key => $value)
                                                <td></td>
                                                @php
                                                    $jumlah[$key] = 0;
                                                @endphp
                                            @endforeach
                                        @break
                                    @endforeach
                                    <td></td>
                                </tr>
                                @php
                                    $jumlah_kumpulan = 0;
                                @endphp

                                @foreach ($results as $data)
                                    @if ($data->spesies_kumpulankayu == $kayu->singkatan)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td class="text-left">{{ $data->spesies_namatempatan }}</td>

                                            @foreach ($data->jumlahpengeluaran as $key => $value)
                                                <td class="text-right">
                                                    {{ number_format($value, 0) }}</td>
                                                @php
                                                    $jumlah[$key] += $value ?? 0;
                                                    $jumlah_besar[$key] += $value ?? 0;
                                                @endphp
                                            @endforeach

                                            <td class="text-right">
                                                @php
                                                    $jumlah_kumpulan += current($data->jumlahkeseluruhan) ?? 0;
                                                    $jumlah_besar_kumpulan += current($data->jumlahkeseluruhan) ?? 0;
                                                @endphp
                                                {{ number_format(current($data->jumlahkeseluruhan) ?? 0, 0) }}
                                            </td>
                                        </tr>
                                    @endif
                                @endforeach

                                <tr class="text-bold" style="background-color: lightgray; font-weight: bold;">
                                    <td></td>
                                    <td class="text-left">Jumlah {{ $kayu->singkatan }} (m³)</td>
                                    @foreach ($results as $data)
                                        @foreach ($data->jumlahpengeluaran as $key => $value)
                                            <td class="text-right">{{ number_format($jumlah[$key], 0) }}</td>
                                        @endforeach
                                    @break
                                @endforeach
                                <td class="text-right">{{ number_format($jumlah_kumpulan, 0) }}</td>

                            <tr>
                                <td></td>
                                <td></td>
                                @foreach ($results as $data)
                                    @foreach ($data->jumlahpengeluaran as $value)
                                        <td></td>
                                    @endforeach
                                @break
                            @endforeach
                            <td></td>
                    @endforeach
                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                        <td></td>
                        <td class="text-left">JUMLAH BESAR (m³)</td>

                        @foreach ($results as $data)
                            @foreach ($data->jumlahpengeluaran as $key => $value)
                                <td class="text-right">{{ number_format($jumlah_besar[$key], 0) }}</td>
                            @endforeach
                        @break
                    @endforeach

                    <td class="text-right">{{ number_format($jumlah_besar_kumpulan, 0) }}</td>
                </tr>
                </tbody>
                {{-- <tfoot>
                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                        <td></td>
                        <td class="text-left">JUMLAH BESAR (m³)</td>

                        @foreach ($results as $data)
                            @foreach ($data->jumlahpengeluaran as $key => $value)
                                <td class="text-right">{{ number_format($jumlah_besar[$key], 0) }}</td>
                            @endforeach
                        @break
                    @endforeach

                    <td class="text-right">{{ number_format($jumlah_besar_kumpulan, 0) }}</td>
                </tr>
            </tfoot> --}}
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


        $('#example').DataTable({
            paging: false,
            scrollY: 750,
            scrollX: false,
            scrollCollapse: true,
            ordering:false,
            searching: false,
            buttons: [{
                    extend: 'excelHtml5',
                    title: title,
                    footer: true,
                },
                {
                    extend: 'pdfHtml5',
                    title: title,
                    footer: true,
                    header: true,
                    orientation: 'landscape',
                    pageSize: 'A4',
                },
            ],
            "language": {
                "lengthMenu": "Memaparkan _MENU_ rekod per  ",
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
