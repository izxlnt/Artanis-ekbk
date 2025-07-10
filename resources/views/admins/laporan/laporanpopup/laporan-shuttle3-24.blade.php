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
                    <a href="{{ route('laporan_shuttle_3_24.excel', ['24', $tahun, $file_type = 'excel']) }}" class="btn btn-success">Excel</a>
                    <a href="{{ route('laporan_shuttle_3_24.excel', ['24', $tahun, $file_type = 'pdf']) }}" class="btn btn-danger">PDF</a>
                    <a href="{{ route('laporan_shuttle_3_24.excel', ['24', $tahun, $file_type = 'print']) }}" class="btn btn-warning">Print</a>
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

                                <thead style="background-color: #f3ce8f;">
                                    <tr>
                                        @foreach ($columns as $data)
                                            <th>{{ $data }}</th>
                                        @endforeach
                                    </tr>
                                </thead>

                                <tbody style="text-align: center">
                                    @php
                                        for ($i = 1; $i < 13; $i++) {
                                            $keseluruhan[$i] = 0;
                                        }
                                        $keseluruhan_kumpulan = 0;
                                    @endphp
                                    @foreach ($kumpulan_kayu as $kayu)
                                        <tr style="background-color: lightgray; font-weight: bold;">
                                            <td></td>
                                            <td class="text-left">{{ $kayu->singkatan }}</td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                        @php
                                            for ($i = 1; $i < 13; $i++) {
                                                $jumlah[$i] = 0;
                                            }
                                            $jumlah_kumpulan = 0;
                                        @endphp
                                        @foreach ($datas as $keterangan => $data)
                                            @if ($keterangan == $kayu->singkatan)
                                                {{-- {{ dd($data) }} --}}

                                                @foreach ($data as $nama_species => $species)
                                                    {{-- {{ dd($species) }} --}}

                                                    @php
                                                        $jumlah_row = 0;
                                                    @endphp

                                                    @if ($species)
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td class="text-left">{{ $nama_species }}</td>
                                                            @forelse ($species as $bulan => $get_data)
                                                                <td class="text-right">
                                                                    {{ number_format($get_data[0]->jumlah_penggunaan ?? 0, 0) }}

                                                                </td>
                                                                @php
                                                                    $jumlah_row += $get_data[0]->jumlah_penggunaan ?? 0;

                                                                    $jumlah[$bulan] += $get_data[0]->jumlah_penggunaan ?? 0;
                                                                    $jumlah_kumpulan += $get_data[0]->jumlah_penggunaan ?? 0;

                                                                    $keseluruhan[$bulan] += $get_data[0]->jumlah_penggunaan ?? 0;
                                                                    $keseluruhan_kumpulan += $get_data[0]->jumlah_penggunaan ?? 0;
                                                                @endphp
                                                            @empty
                                                                0
                                                            @endforelse
                                                            <td class="text-right">
                                                                {{ number_format($jumlah_row, 0) }}</td>
                                                        </tr>
                                                    @else
                                                        <tr>
                                                            <td>{{ $loop->iteration }}</td>
                                                            <td class="text-left">{{ $nama_species }}</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                            <td class="text-right">0</td>
                                                        </tr>
                                                    @endif
                                                @endforeach
                                            @endif
                                        @endforeach

                                        <tr class="text-bold" style="background-color: lightgray; font-weight: bold;">
                                            <td></td>
                                            <td class="text-left">Jumlah {{ $kayu->singkatan }}</td>
                                            @for ($i = 1; $i < 13; $i++)
                                                <td class="text-right">{{ number_format($jumlah[$i], 0) }}</td>
                                            @endfor
                                            <td class="text-right">{{ number_format($jumlah_kumpulan, 0) }}</td>
                                        </tr>

                                        <tr>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    @endforeach

                                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td class="text-left">JUMLAH BESAR (m³)</td>

                                        @for ($i = 1; $i < 13; $i++)
                                            <td class="text-right">{{ number_format($keseluruhan[$i], 0) }}</td>
                                        @endfor

                                        <td class="text-right">{{ number_format($keseluruhan_kumpulan, 0) }}</td>
                                    </tr>
                                </tbody>



                                {{-- <tfoot>
                                    <tr class="text-center" style="background-color: lightgray; font-weight: bold;">
                                        <td></td>
                                        <td class="text-left">JUMLAH BESAR (m³)</td>

                                        @for ($i = 1; $i < 13; $i++)
                                            <td class="text-right">{{ number_format($keseluruhan[$i], 0) }}</td>
                                        @endfor

                                        <td class="text-right">{{ number_format($keseluruhan_kumpulan, 0) }}</td>
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
            var table = $('#example').DataTable({
                paging: false,
                scrollY: 750,
                scrollX: false,
                scrollCollapse: true,
                ordering: false,
                searching: false,
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
