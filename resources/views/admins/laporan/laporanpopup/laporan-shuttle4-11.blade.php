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
                    <a href="{{ $returnArr['kembali'] }}" class="btn btn-primary">Kembali</a>]
                    <a href="{{ route('laporan_shuttle_4_11.excel', ['11', $tahun, $suku_tahun, $suku_tahun_akhir, $file_type = 'excel']) }}" class="btn btn-success">Excel</a>
                    <a href="{{ route('laporan_shuttle_4_11.excel', ['11', $tahun, $suku_tahun, $suku_tahun_akhir, $file_type = 'pdf']) }}" class="btn btn-danger">PDF</a>
                    <a href="{{ route('laporan_shuttle_4_11.excel', ['11', $tahun, $suku_tahun, $suku_tahun_akhir, $file_type = 'print']) }}" class="btn btn-warning">Print</a>
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
                                    @php

                                        $jumlah_lelaki = 0;
                                        $jumlah_perempuan = 0;
                                        $jumlah_guna_tenaga = 0;

                                        $jumlah_gaji_lelaki = 0;
                                        $jumlah_gaji_perempuan = 0;
                                        $jumlah_pendapatan = 0;

                                        $jumlah_purata_lelaki = 0;
                                        $jumlah_purata_perempuan = 0;
                                        $jumlah_purata_keseluruhan = 0;

                                    @endphp

                                    <thead style="background-color: #f3ce8f; font-weight: bold;">
                                        <tr>
                                            @foreach ($columns as $data)
                                                @if ($data == 'Guna Tenaga')
                                                    <th colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Pendapatan (RM)')
                                                    <th colspan="3">{{ $data }}</th>
                                                @elseif($data == 'Purata (RM)')
                                                    <th colspan="3">{{ $data }}</th>
                                                @else
                                                    <th rowspan="2">{{ $data }}</th>
                                                @endif
                                            @endforeach
                                        </tr>

                                        <tr>
                                            {{-- <th colspan="2"></th> --}}
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

                                        @forelse ($data_jumlah as $negeri => $data)
                                            @if ($data)
                                                <tr class="text-right">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $negeri }}</td>
                                                    @php
                                                        $data_total_pekerja_lelaki = 0;
                                                        $data_total_pekerja_perempuan = 0;
                                                        $data_jumlah_guna_tenaga = 0;

                                                        $data_jumlah_gaji_lelaki = 0;
                                                        $data_jumlah_gaji_perempuan = 0;
                                                        $data_jumlah_pendapatan = 0;

                                                        $data_total_pekerja_lelaki = 0;
                                                        $data_total_pekerja_perempuan = 0;
                                                    @endphp
                                                    @foreach($data as $value)
                                                        @php
                                                            $data_total_pekerja_lelaki += $value->total_pekerja_lelaki;

                                                            $data_total_pekerja_perempuan += $value->total_pekerja_perempuan;

                                                            $data_jumlah_guna_tenaga += $value->total_pekerja_lelaki + $value->total_pekerja_perempuan;

                                                            $data_jumlah_gaji_lelaki += $value->jumlah_gaji_lelaki;

                                                            $data_jumlah_gaji_perempuan += $value->jumlah_gaji_perempuan;

                                                            $data_jumlah_pendapatan = round($data_jumlah_gaji_lelaki) + round($data_jumlah_gaji_perempuan);

                                                            $purata_lelaki = $data_jumlah_gaji_lelaki / $data_total_pekerja_lelaki;
                                                            $purata_perempuan = $data_jumlah_gaji_perempuan / $data_total_pekerja_perempuan;
                                                            $purata_keseluruhan = $data_jumlah_pendapatan / $data_jumlah_guna_tenaga ;

                                                            $jumlah_lelaki += $value->total_pekerja_lelaki;
                                                            $jumlah_perempuan += $value->total_pekerja_perempuan;
                                                            $jumlah_guna_tenaga = $data_jumlah_guna_tenaga;

                                                            $jumlah_gaji_lelaki += $value->jumlah_gaji_lelaki;
                                                            $jumlah_gaji_perempuan += $value->jumlah_gaji_perempuan;
                                                            $jumlah_pendapatan = $data_jumlah_pendapatan;

                                                            $jumlah_purata_lelaki += $purata_lelaki;
                                                            $jumlah_purata_perempuan += $purata_perempuan;
                                                            $jumlah_purata_keseluruhan = $purata_keseluruhan;
                                                        @endphp
                                                    @endforeach

                                                    <td>
                                                        {{ number_format($data_total_pekerja_lelaki,0) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($data_total_pekerja_perempuan,0) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format($data_jumlah_guna_tenaga,0) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format(round($data_jumlah_gaji_lelaki, 2)) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format(round($data_jumlah_gaji_perempuan, 2)) }}
                                                    </td>
                                                    <td>
                                                        {{ number_format(round($data_jumlah_pendapatan, 2)) }}
                                                    </td>

                                                    <td>
                                                        {{ number_format(round($purata_lelaki, 2)) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format(round($purata_perempuan, 2)) }}
                                                    </td>
                                                    <td class="text-right">
                                                        {{ number_format(round($purata_keseluruhan, 2)) }}
                                                    </td>


                                                </tr>
                                            @else
                                                <tr class="text-right">
                                                    <td class="text-center">{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $negeri }}</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0</td>
                                                    <td>0.00</td>
                                                    <td>0.00</td>
                                                    <td>0.00</td>
                                                    <td>0.00</td>
                                                    <td>0.00</td>
                                                    <td>0.00</td>
                                                </tr>
                                            @endif
                                        @empty
                                            <tr class="text-right">
                                                <td class="text-center">{{ $loop->iteration }}</td>
                                                <td class="text-left">{{ $negeri }}</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0</td>
                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>0.00</td>
                                                <td>0.00</td>
                                            </tr>
                                        @endforelse

                                    </tbody>
                                    <tr class="text-right" style="background-color: lightgray; font-weight: bold;">
                                        <td class="text-center"></td>
                                        <td class="text-left">Jumlah</td>
                                        <td>{{ number_format($jumlah_lelaki,0) }}</td>
                                        <td>{{ number_format($jumlah_perempuan,0) }}</td>
                                        <td>{{ number_format($jumlah_guna_tenaga,0) }}</td>

                                        <td>{{ number_format(round($jumlah_gaji_lelaki, 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_gaji_perempuan, 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_pendapatan, 2)) }}</td>

                                        <td>{{ number_format(round($jumlah_purata_lelaki = ($jumlah_gaji_lelaki / max($jumlah_lelaki, 1)), 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_purata_perempuan = ($jumlah_gaji_perempuan / max($jumlah_perempuan, 1)), 2)) }}</td>
                                        <td>{{ number_format(round($jumlah_purata_keseluruhan = ($jumlah_pendapatan / max($jumlah_guna_tenaga, 1)), 2))  }}</td>

                                    </tr>
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
