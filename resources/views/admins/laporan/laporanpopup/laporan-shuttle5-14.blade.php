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
                    <a href="{{ route('laporan_shuttle_5_14.excel', ['14', $tahun, $suku_tahun, $suku_tahun_akhir, $file_type = 'excel']) }}" class="btn btn-success">Excel</a>
                    <a href="{{ route('laporan_shuttle_5_14.excel', ['14', $tahun, $suku_tahun, $suku_tahun_akhir, $file_type = 'pdf']) }}" class="btn btn-danger">PDF</a>
                    <a href="{{ route('laporan_shuttle_5_14.excel', ['14', $tahun, $suku_tahun, $suku_tahun_akhir, $file_type = 'print']) }}" class="btn btn-warning">Print</a>
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
                    {{-- <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title }} : Suku Tahun {{ $nama_suku_tahun }} ({{ $tahun }})</div> --}}

                    @if ($nama_suku_tahun != $nama_suku_tahun_akhir)
                        <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title_laporan }} : Suku
                            Tahun {{ $nama_suku_tahun }} Hingga Suku Tahun {{ $nama_suku_tahun_akhir }} Bagi Tahun
                            {{ $tahun }}</div>
                    @else
                        <div class="text-center card-header" style="background-color: #f3ce8f">{{ $title_laporan }} : Suku
                            Tahun {{ $nama_suku_tahun }} Bagi Tahun{{ $tahun }}</div>
                    @endif


                    <div class="card-body">
                        <div class="table-responsive">
                            @foreach ($datas as $key => $data_jumlah)
                                @if (!$loop->first)
                                    <hr>
                                @endif
                                @if ($key == 1)
                                    <div class="text-center" style="font-weight: bold;">Suku
                                        Tahun Pertama</div>
                                @elseif($key == 2)
                                    <div class="text-center" style="font-weight: bold;">Suku
                                        Tahun Kedua</div>
                                @elseif($key == 3)
                                    <div class="text-center" style="font-weight: bold;">Suku
                                        Tahun Ketiga</div>
                                @else
                                    <div class="text-center" style="font-weight: bold;">Suku
                                        Tahun Keempat</div>
                                @endif
                                <table id="example_{{ $key }}" class="text-center table-bordered"
                                    style="width: 100%">
                                    <thead style="background-color: #f3ce8f; font-weight: bold;">
                                        <tr>
                                            @foreach ($columns as $data)
                                                @if ($data == 'Bumiputera' || $data == 'Bukan Bumiputera' || $data == 'Bukan Warganegara' || $data == 'Jumlah')
                                                    <th colspan="3">{{ $data }}</th>
                                                @else
                                                    <th rowspan="2">{{ $data }}</th>
                                                @endif
                                            @endforeach

                                        </tr>

                                        <tr>

                                            <th>L</th>
                                            <th>P</th>
                                            <th>Jumlah (L+P)</th>

                                            <th>L</th>
                                            <th>P</th>
                                            <th>Jumlah (L+P)</th>

                                            <th>L</th>
                                            <th>P</th>
                                            <th>Jumlah (L+P)</th>

                                            <th>L</th>
                                            <th>P</th>
                                            <th>Jumlah (L+P)</th>
                                        </tr>

                                    </thead>
                                    <tbody style="text-align: center">

                                        @php

                                            $jumlah_bumi_lelaki = 0;
                                            $jumlah_bumi_perempuan = 0;
                                            $jumlah_bumiputera = 0;

                                            $jumlah_bukan_bumi_lelaki = 0;
                                            $jumlah_bukan_bumi_perempuan = 0;
                                            $jumlah_bukan_bumiputera = 0;

                                            $jumlah_bukan_warga_lelaki = 0;
                                            $jumlah_bukan_warga_perempuan = 0;
                                            $jumlah_bukan_warganegara = 0;

                                            $jumlah_jumlah_lelaki = 0;
                                            $jumlah_jumlah_perempuan = 0;
                                            $jumlah_jumlah_jumlah = 0;

                                        @endphp

                                        @foreach ($data_jumlah as $key2 => $data)
                                            @if ($data)
                                                <tr class="text-right">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $data[0]->negeri }}</td>


                                                    {{-- bumiputera --}}
                                                    <td>
                                                        {{ number_format($data[0]->jumlah_bumiputera_lelaki) }}
                                                        @php
                                                            $jumlah_bumi_lelaki = $jumlah_bumi_lelaki + $data[0]->jumlah_bumiputera_lelaki;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{ number_format($data[0]->jumlah_bumiputera_perempuan) }}
                                                        @php
                                                            $jumlah_bumi_perempuan = $jumlah_bumi_perempuan + $data[0]->jumlah_bumiputera_perempuan;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{ number_format($data[0]->jumlah_bumiputera_lelaki + $data[0]->jumlah_bumiputera_perempuan) }}
                                                        @php
                                                            $jumlah_bumiputera = $jumlah_bumiputera + ($data[0]->jumlah_bumiputera_lelaki + $data[0]->jumlah_bumiputera_perempuan);
                                                        @endphp
                                                    </td>


                                                    {{-- bukan bumiputera --}}
                                                    <td>
                                                        {{ number_format($data[0]->jumlah_bukan_bumiputera_lelaki) }}
                                                        @php
                                                            $jumlah_bukan_bumi_lelaki = $jumlah_bukan_bumi_lelaki + $data[0]->jumlah_bukan_bumiputera_lelaki;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{ number_format($data[0]->jumlah_bukan_bumiputera_perempuan) }}
                                                        @php
                                                            $jumlah_bukan_bumi_perempuan = $jumlah_bukan_bumi_perempuan + $data[0]->jumlah_bukan_bumiputera_perempuan;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{ number_format($data[0]->jumlah_bukan_bumiputera_lelaki + $data[0]->jumlah_bukan_bumiputera_perempuan) }}
                                                        @php
                                                            $jumlah_bukan_bumiputera = $jumlah_bukan_bumiputera + ($data[0]->jumlah_bukan_bumiputera_lelaki + $data[0]->jumlah_bukan_bumiputera_perempuan);
                                                        @endphp
                                                    </td>

                                                    {{-- bukan warganegara --}}
                                                    <td>
                                                        {{ number_format($data[0]->jumlah_bukan_warganegara_lelaki) }}
                                                        @php
                                                            $jumlah_bukan_warga_lelaki = $jumlah_bukan_warga_lelaki + $data[0]->jumlah_bukan_warganegara_lelaki;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{ number_format($data[0]->jumlah_bukan_warganegara_perempuan) }}
                                                        @php
                                                            $jumlah_bukan_warga_perempuan = $jumlah_bukan_warga_perempuan + $data[0]->jumlah_bukan_warganegara_perempuan;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        {{ number_format($data[0]->jumlah_bukan_warganegara_lelaki + $data[0]->jumlah_bukan_warganegara_perempuan) }}
                                                        @php
                                                            $jumlah_bukan_warganegara = $jumlah_bukan_warganegara + ($data[0]->jumlah_bukan_warganegara_lelaki + $data[0]->jumlah_bukan_warganegara_perempuan);
                                                        @endphp
                                                    </td>

                                                    {{-- Jumlah --}}
                                                    <td>
                                                        @php
                                                            $papar_jumlah_jumlah_lelaki = $data[0]->jumlah_bumiputera_lelaki + $data[0]->jumlah_bukan_bumiputera_lelaki + $data[0]->jumlah_bukan_warganegara_lelaki;
                                                        @endphp
                                                        {{ number_format($papar_jumlah_jumlah_lelaki) }}
                                                        @php
                                                            $jumlah_jumlah_lelaki = $jumlah_jumlah_lelaki + $papar_jumlah_jumlah_lelaki;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $papar_jumlah_jumlah_perempuan = $data[0]->jumlah_bumiputera_perempuan + $data[0]->jumlah_bukan_bumiputera_perempuan + $data[0]->jumlah_bukan_warganegara_perempuan;
                                                        @endphp
                                                        {{ number_format($papar_jumlah_jumlah_perempuan) }}
                                                        @php
                                                            $jumlah_jumlah_perempuan = $jumlah_jumlah_perempuan + $papar_jumlah_jumlah_perempuan;
                                                        @endphp
                                                    </td>
                                                    <td>
                                                        @php
                                                            $papar_jumlah_jumlah_jumlah = $papar_jumlah_jumlah_lelaki + $papar_jumlah_jumlah_perempuan;
                                                        @endphp
                                                        {{ number_format($papar_jumlah_jumlah_jumlah) }}
                                                        @php
                                                            $jumlah_jumlah_jumlah = $jumlah_jumlah_jumlah + $papar_jumlah_jumlah_jumlah;
                                                        @endphp
                                                    </td>
                                                </tr>
                                            @else
                                                <tr class="text-right">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $key2 }}</td>

                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>

                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>

                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>

                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                </tr>
                                            @endif
                                        @endforeach
                                        <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                            <td class="text-center"></td>
                                            <td class="text-left">Jumlah</td>

                                            <td>{{ number_format($jumlah_bumi_lelaki) }}</td>
                                            <td>{{ number_format($jumlah_bumi_perempuan) }}</td>
                                            <td>{{ number_format($jumlah_bumiputera) }}</td>

                                            <td>{{ number_format($jumlah_bukan_bumi_lelaki) }}</td>
                                            <td>{{ number_format($jumlah_bukan_bumi_perempuan) }}</td>
                                            <td>{{ number_format($jumlah_bukan_bumiputera) }}</td>

                                            <td>{{ number_format($jumlah_bukan_warga_lelaki) }}</td>
                                            <td>{{ number_format($jumlah_bukan_warga_perempuan) }}</td>
                                            <td>{{ number_format($jumlah_bukan_warganegara) }}</td>

                                            <td>{{ number_format($jumlah_jumlah_lelaki) }}</td>
                                            <td>{{ number_format($jumlah_jumlah_perempuan) }}</td>
                                            <td>{{ number_format($jumlah_jumlah_jumlah) }}</td>

                                        </tr>
                                    </tbody>
                                </table>
                            @endforeach


                        </div>
                    </div>
                </div>



            </div>
        </div>
    </div>

    <script>
        $(document).ready(function() {
            for (let index = 1; index <= 4; index++) {
                var t_index = $('#example_' + index).DataTable({
                    // dom: 'Bfrtip',
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
            }

        });
    </script>
@endsection
