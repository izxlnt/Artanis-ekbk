{{-- @extends(Auth()->user()->kategori_pekerja == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : (Auth()->user()->kategori_pekerja == 'BPM' ? 'layouts.layout-bpm-nicepage' : (Auth()->user()->kategori_pekerja == 'PHD' ? 'layouts.layout-phd-nicepage' : ''))) --}}

{{-- @extends(auth()->user()->kategori_pengguna == 'PHD' ? 'layouts.layout-phd-nicepage' : (auth()->user()->kategori_pengguna == 'BPM' ? 'layouts.layout-bpm-nicepage' : (auth()->user()->kategori_pengguna == 'BPE' ? 'layouts.layout-ipjpsm-nicepage' : ''))) --}}

@extends($layout)

@section('content')
    <div>

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

                <div class="col-md-12">
                    <div class="rounded-lg card" style="border-color: #000000 !important;">

                        @if ($formb->shuttle_type == '3')
                            <div class="card-header"
                                style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                                BORANG 3B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                            </div>

                        @elseif($formb->shuttle_type == '4')
                            <div class="card-header"
                                style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                                BORANG 4B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                            </div>

                        @else
                            <div class="card-header"
                                style="text-align:center; background-color: #ee8dcd !important; font-size: 130%; font-weight: bold;">
                                BORANG 5B - JUMLAH GUNA TENAGA PADA AKHIR BULAN
                            </div>
                        @endif

                        <div class="card-body">
                            <!-- Tab panes -->
                            <div class="tab-content">

                                <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab"><br>
                                    <div class="">
                                        <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">
                                                        <div class="card-body" style="padding-top: 0%;">

                                                            <div class="row"
                                                                style="justify-content: center;margin-bottom:-3%;">
                                                                <div class="col-md-2">
                                                                    <label><b>Tahun:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #f8dbee; border-color: #d89bc4"
                                                                        value="{{ $formb->tahun }}" readonly />
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label><b>Suku Tahun:</b></label>
                                                                    @if ($formb->suku_tahun <= '1')

                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #f8dbee; border-color: #d89bc4"
                                                                            value="Pertama (Mac)" readonly />
                                                                    @elseif($formb->suku_tahun
                                                                        <= '2' ) <input type="text" class="form-control"
                                                                            style="background-color: #f8dbee; border-color: #d89bc4"
                                                                            value="Kedua (Jun)" readonly />
                                                                    @elseif($formb->suku_tahun
                                                                        <= '3' ) <input type="text" class="form-control"
                                                                            style="background-color: #f8dbee; border-color: #d89bc4"
                                                                            value="Ketiga (September)" readonly />
                                                                    @elseif($formb->suku_tahun
                                                                        <= '4' ) <input type="text" class="form-control"
                                                                            style="background-color: #f8dbee; border-color: #d89bc4"
                                                                            value="Keempat (Disember)" readonly />
                                                                    @else
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #f8dbee;border-color: #d89bc4"
                                                                            value="Tiada Data" readonly />
                                                                    @endif

                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label><b>Nama Kilang:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #f8dbee;border-color: #d89bc4""
                                                                            value=" {{ $formb->nama_kilang }}"
                                                                        readonly />
                                                                </div>
                                                                {{-- <div class="col-md-2"></div> --}}
                                                                <div class="col-md-2">
                                                                    <label><b>No. Pendaftaran Syarikat (SSM):</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #f8dbee;border-color: #d89bc4""
                                                                            value=" {{ $formb->no_ssm }}" readonly />
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label><b>No. Lesen:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #f8dbee;border-color: #d89bc4""
                                                                            value=" {{ $formb->no_lesen }}" readonly />
                                                                </div>


                                                            </div>


                                                            <br>
                                                            <div style="overflow-x: auto;">
                                                            <table>

                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;" colspan="2" rowspan="4">
                                                                        Kategori Pekerja
                                                                    </th>
                                                                    <th style="text-align:center;" colspan="4">Warganegara
                                                                        Malaysia</th>
                                                                    <th style="text-align:center;" colspan="2" rowspan="3">
                                                                        Bukan <br>Warganegara <br>
                                                                        Malaysia</th>
                                                                    <th style="text-align:center;" colspan="3" rowspan="3">
                                                                        Jumlah Pekerja</th>
                                                                    <th style="text-align:center;" colspan="3" rowspan="3">
                                                                        Purata Bayaran Gaji dan <br>Upah
                                                                        Per Pekerja<br> (Sebulan) <br> (RM/ bulan / pekerja)</th>
                                                                    <th style="text-align:center;" colspan="3" rowspan="3">
                                                                        Jumlah Bayaran Gaji
                                                                        dan Upah <br>(Sebulan) <br>(RM)</th>
                                                                </tr>
                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;" colspan="2" rowspan="2">
                                                                        Bumiputera</th>
                                                                    <th style="text-align:center;" colspan="2" rowspan="2">
                                                                        Bukan Bumiputera</th>
                                                                </tr>
                                                                <tr style="height:50px;">

                                                                </tr>
                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L+P</th>
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L+P</th>
                                                                    <th style="text-align:center;">L</th>
                                                                    <th style="text-align:center;">P</th>
                                                                    <th style="text-align:center;">L+P</th>
                                                                </tr>

                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;" colspan="2">(01)</th>
                                                                    <th style="text-align:center;">(02)</th>
                                                                    <th style="text-align:center;">(03)</th>
                                                                    <th style="text-align:center;">(04)</th>
                                                                    <th style="text-align:center;">(05)</th>
                                                                    <th style="text-align:center;">(06)</th>
                                                                    <th style="text-align:center;">(07)</th>
                                                                    <th style="text-align:center;">(08)=(02)+(04)+(06)</th>
                                                                    <th style="text-align:center;">(09)=(03)+(05)+(07)</th>
                                                                    <th style="text-align:center;">(10)=(08)+(09)</th>
                                                                    <th style="text-align:center;">(11)</th>
                                                                    <th style="text-align:center;">(12)</th>
                                                                    <th style="text-align:center;">(13)=(11)+(12)</th>
                                                                    <th style="text-align:center;">(14)</th>
                                                                    <th style="text-align:center;">(15)</th>
                                                                    <th style="text-align:center;">(16)=(14)+(15)</th>
                                                                </tr>

                                                                @php
                                                                    $jml_bumi_l    = $form_b->sum('pekerja_wargabumi_lelaki');
                                                                    $jml_bumi_p    = $form_b->sum('pekerja_wargabumi_perempuan');
                                                                    $jml_bkbumi_l  = $form_b->sum('pekerja_bukan_wargabumi_lelaki');
                                                                    $jml_bkbumi_p  = $form_b->sum('pekerja_bukan_wargabumi_perempuan');
                                                                    $jml_asing_l   = $form_b->sum('pekerja_asing_lelaki');
                                                                    $jml_asing_p   = $form_b->sum('pekerja_asing_perempuan');
                                                                    $jml_l         = $form_b->sum('jumlah_lelaki');
                                                                    $jml_p         = $form_b->sum('jumlah_perempuan');
                                                                    $jml_lp        = $form_b->sum('jumlah_pekerja');
                                                                    $jml_gaji_l    = $form_b->sum('gaji_lelaki');
                                                                    $jml_gaji_p    = $form_b->sum('gaji_perempuan');
                                                                    $jml_gaji_lp   = $form_b->sum(fn($r) => $r->gaji_lelaki + $r->gaji_perempuan);
                                                                    $jml_tot_l     = $form_b->sum(fn($r) => $r->jumlah_lelaki * $r->gaji_lelaki);
                                                                    $jml_tot_p     = $form_b->sum(fn($r) => $r->jumlah_perempuan * $r->gaji_perempuan);
                                                                    $jml_tot_lp    = $jml_tot_l + $jml_tot_p;
                                                                @endphp
                                                                @forelse($form_b as $key=>$data)
                                                                    <tr style="height:50px;">

                                                                        <td style="text-align:left;">
                                                                            {{ $data->kategori_guna_tenaga->keterangan }}
                                                                        </td>
                                                                        <td style="text-align:center;width:30px;">
                                                                            {{ $i = $loop->iteration }}</td>
                                                                        <td style="text-align:right;padding:5px"><span
                                                                                type="text" size="3"
                                                                                value="{{ $data->pekerja_wargabumi_lelaki }}"
                                                                                wire:model='pekerja_wargabumi_lelaki.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaLelaki({{ $key }});"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_wargabumi_lelaki }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;padding:5px"><span
                                                                                type="text" size="3"
                                                                                value="{{ $data->pekerja_wargabumi_perempuan }}"
                                                                                wire:model='pekerja_wargabumi_perempuan.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_wargabumi_perempuan }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;padding:5px"><span
                                                                                type="text" size="3"
                                                                                value="{{ $data->pekerja_bukan_wargabumi_lelaki }}"
                                                                                wire:model='pekerja_bukan_wargabumi_lelaki.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaLelaki({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_bukan_wargabumi_lelaki }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;padding:5px"><span
                                                                                type="text" size="3"
                                                                                value="{{ $data->pekerja_bukan_wargabumi_perempuan }}"
                                                                                wire:model='pekerja_bukan_wargabumi_perempuan.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_bukan_wargabumi_perempuan }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;"><span type="text"
                                                                                size="3"
                                                                                value="{{ $data->pekerja_asing_lelaki }}"
                                                                                wire:model='pekerja_asing_lelaki.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaLelaki({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_asing_lelaki }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;"><span type="text"
                                                                                size="3"
                                                                                value="{{ $data->pekerja_asing_perempuan }}"
                                                                                wire:model='pekerja_asing_perempuan.{{ $key }}'
                                                                                wire:change="calcJumlahPekerjaPerempuan({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ $data->pekerja_asing_perempuan }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;background-color: #f8dbee;">
                                                                            <span readonly type="text"
                                                                                value="{{ $data->jumlah_lelaki }}"
                                                                                size="3"
                                                                                wire:model='jumlah_lelaki.{{ $key }}'
                                                                                onkeypress="return isNumberKey(event)">{{ $data->jumlah_lelaki }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;background-color: #f8dbee;">
                                                                            <span readonly type type="text"
                                                                                value="{{ $data->jumlah_perempuan }}"
                                                                                size="3"
                                                                                wire:model='jumlah_perempuan.{{ $key }}'
                                                                                onkeypress="return isNumberKey(event)">{{ $data->jumlah_perempuan }}</span>
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;background-color: #f8dbee;">
                                                                            <span readonly type type="text"
                                                                                value="{{ $data->jumlah_pekerja }}"
                                                                                size="3"
                                                                                wire:model='jumlah_pekerja.{{ $key }}'
                                                                                onkeypress="return isNumberKey(event)">{{ $data->jumlah_pekerja }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;"><span type="text"
                                                                                size="3" value="{{ $data->gaji_lelaki }}"
                                                                                wire:model='gaji_lelaki.{{ $key }}'
                                                                                wire:change="calcTotalAllBayaranGajiPerPekerjaLelaki({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ number_format($data->gaji_lelaki, 2) }}</span>
                                                                        </td>
                                                                        <td style="text-align:right;"><span type="text"
                                                                                size="3"
                                                                                value="{{ $data->gaji_perempuan }}"
                                                                                wire:model='gaji_perempuan.{{ $key }}'
                                                                                wire:change="calcTotalAllBayaranGajiPerPekerjaPerempuan({{ $key }})"
                                                                                onkeypress="return isNumberKey(event)">{{ number_format($data->gaji_perempuan, 2) }}</span>
                                                                        </td>

                                                                        <td
                                                                            style="text-align:right;background-color: #f8dbee;">
                                                                            {{ number_format($data->gaji_lelaki + $data->gaji_perempuan, 2) }}
                                                                        </td>

                                                                        <td style="text-align:right;">
                                                                            {{ number_format($data->jumlah_lelaki * $data->gaji_lelaki, 2) }}
                                                                        </td>
                                                                        <td style="text-align:right;">
                                                                            {{ number_format($data->jumlah_perempuan * $data->gaji_perempuan, 2) }}
                                                                        </td>
                                                                        <td
                                                                            style="text-align:right;background-color: #f8dbee;">
                                                                            {{ number_format(($data->jumlah_lelaki * $data->gaji_lelaki) + ($data->jumlah_perempuan * $data->gaji_perempuan), 2) }}
                                                                        </td>

                                                                    </tr>
                                                                    @if ($loop->last)
                                                                        <tr style="height:50px;background-color:#f8dbee;font-weight:bold;">
                                                                            <td style="text-align:right;"><b>Jumlah</b></td>
                                                                            <td style="text-align:center;"><b>{{ $i = $i + 1 }}</b></td>
                                                                            <td style="text-align:right;">{{ $jml_bumi_l }}</td>
                                                                            <td style="text-align:right;">{{ $jml_bumi_p }}</td>
                                                                            <td style="text-align:right;">{{ $jml_bkbumi_l }}</td>
                                                                            <td style="text-align:right;">{{ $jml_bkbumi_p }}</td>
                                                                            <td style="text-align:right;">{{ $jml_asing_l }}</td>
                                                                            <td style="text-align:right;">{{ $jml_asing_p }}</td>
                                                                            <td style="text-align:right;">{{ $jml_l }}</td>
                                                                            <td style="text-align:right;">{{ $jml_p }}</td>
                                                                            <td style="text-align:right;">{{ $jml_lp }}</td>
                                                                            <td style="text-align:right;">{{ number_format($jml_gaji_l, 2) }}</td>
                                                                            <td style="text-align:right;">{{ number_format($jml_gaji_p, 2) }}</td>
                                                                            <td style="text-align:right;">{{ number_format($jml_gaji_lp, 2) }}</td>
                                                                            <td style="text-align:right;">{{ number_format($jml_tot_l, 2) }}</td>
                                                                            <td style="text-align:right;">{{ number_format($jml_tot_p, 2) }}</td>
                                                                            <td style="text-align:right;">{{ number_format($jml_tot_lp, 2) }}</td>
                                                                        </tr>
                                                                    @endif
                                                                @empty

                                                                @endforelse


                                                            </table>
                                                            </div>{{-- end overflow-x wrapper --}}
                                                            <br>

                                                        </div>
                                                    </div>

                                                </div>


                                                <br>
                                                {{-- <div class="text-right form-group m-b-0">
                                                    <button type="button" class="btn btn-primary">Kembali</button>

                                                </div> --}}
                                            </div>
                                    </div>
                                </div>

                                </table>
                            </div>
                        </div>









                    </div>



                    <!-- ============================================================== -->
                    <!-- End Container fluid  -->
                    <!-- ============================================================== -->


                </div>
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

                <style>
                    table,
                    th,
                    td {
                        border: 1px solid black;
                    }

                </style>

            @endsection
