@extends('layouts.layout-ibk-nicepage')


@section('content')

    <div>
        <div>
            <div>
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
                                                            <a href="{{ $breadcrumb['link'] }}"
                                                                style="color: white !important;"
                                                                onMouseOver="this.style.color='lightblue'"
                                                                onMouseOut="this.style.color='white'">
                                                                {{ $breadcrumb['name'] }}
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
                                    <div class="card-header"
                                        style="text-align:center; background-color: #a0e4ff !important; font-size: 130%; font-weight: bold;">
                                        BORANG 4E - PENYATA PENJUALAN PAPAN LAPIS/VENIR DALAM PASARAN TEMPATAN DAN
                                        EKSPORT
                                    </div>
                                    <div class="card-body">

                                        <!-- Tab panes -->
                                        <div class="tab-content">

                                            <div class="tab-pane active" id="hotel" role="tabpanel"
                                                aria-labelledby="hotel-tab">
                                                <br>
                                                <div class="">
                                                    <table class="table table-striped table-bordered" id=""
                                                        style="width: 100%;">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card">

                                                                    <div class="card-body">



                                                                        <div class="row"
                                                                            style="justify-content: center;margin-bottom:-2%;">
                                                                            <div class="col-md-2">
                                                                                <label><b>Tahun:</b></label>
                                                                                <input type="text" class="form-control"
                                                                                    style="background-color: #ccebf96b; "
                                                                                    value="{{ $form4e->tahun }}"
                                                                                    readonly />
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <label><b>Bulan:</b></label>
                                                                                @if ($form4e->bulan <= '1')

                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="Januari" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '2' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="Februari" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '3' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="Mac" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '4' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="April" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '5' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="Mei" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '6' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="Jun" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '7' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="Julai" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '8' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="Ogos" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '9' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="September" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '10' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="Oktober" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '11' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="November" readonly />
                                                                                @elseif($form4e->bulan
                                                                                    <= '12' ) <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #ccebf96b;;"
                                                                                        value="Disember" readonly />
                                                                                @endif

                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <label><b>Nama Kilang:</b></label>
                                                                                <input type="text" class="form-control"
                                                                                    style="background-color: #ccebf96b;"
                                                                                    value="{{ $form4e->nama_kilang }}"
                                                                                    readonly />
                                                                            </div>
                                                                            {{-- <div class="col-md-2"></div> --}}
                                                                            <div class="col-md-2">
                                                                                <label><b>No. Pendaftaran Syarikat
                                                                                        (SSM):</b></label>
                                                                                <input type="text" class="form-control"
                                                                                    style="background-color: #ccebf96b;"
                                                                                    value="{{ $form4e->no_ssm }}"
                                                                                    readonly />
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <label><b>No. Lesen:</b></label>
                                                                                <input type="text" class="form-control"
                                                                                    style="background-color: #ccebf96b;"
                                                                                    value="{{ $form4e->no_lesen }}"
                                                                                    readonly />
                                                                            </div>


                                                                        </div>

                                                                        <table style="margin-left:120px">
                                                                            <tr style="height:50px;">
                                                                                <td style="width:50%" class="col-md-12">
                                                                                    Jumlah papan lapis yang dieksport (m³)</td>
                                                                                <td style="text-align:center;width:50%"><input
                                                                                        style="text-align:center"
                                                                                        type="text" size="10"
                                                                                        class="text-right"
                                                                                        value="{{ number_format($form4e->total_export ?? 0,2) }}"
                                                                                        readonly>
                                                                                </td>
                                                                            </tr>

                                                                            <tr style="height:50px;">
                                                                                <td style="" class="col-md-12">
                                                                                    Jumlah papan lapis yang dijual dalam
                                                                                    pasaran tempatan (m³)</td>
                                                                                <td style="text-align:center;"><input
                                                                                        style="background-color: #9ac4f7;text-align:center"
                                                                                        type="text" size="10"
                                                                                        class="text-right"
                                                                                        value="{{ number_format($form4e->jumlah_pasaran_tempatan ?? 0,2) }}"
                                                                                        readonly>
                                                                                </td>
                                                                            </tr>

                                                                            <tr style="height:50px;">
                                                                                <td style="" class="col-md-12">
                                                                                    Jumlah venir yang dieksport (m³)</td>
                                                                                <td style="text-align:center;"><input
                                                                                        style="text-align:center"
                                                                                        type="text" size="10"
                                                                                        class="text-right"
                                                                                        value="{{ number_format($form4e->jumlah_venier_eksport ?? 0,2) }}"
                                                                                        readonly>
                                                                                </td>
                                                                            </tr>

                                                                            <tr style="height:50px;">
                                                                                <td style="" class="col-md-12">
                                                                                    Jumlah venir yang dijual dalam
                                                                                    pasaran tempatan (m³)</span>
                                                                                </td>
                                                                                <td style="text-align:center;"><input
                                                                                        style="text-align:center"
                                                                                        type="text" size="10"
                                                                                        class="text-right"
                                                                                        value="{{ number_format($form4e->jumlah_venier_tempatan ?? 0,2) }}"
                                                                                        readonly>
                                                                                </td>
                                                                            </tr>

                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;background-color: #9ac4f7;"
                                                                                    class="col-md-12" colspan="2">
                                                                                    Penjualan Papan Lapis Dalam Pasaran
                                                                                    Tempatan</th>
                                                                            </tr>

                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;background-color: #9ac4f7;width:50%"
                                                                                    class="col-md-12">Jenis Pembeli
                                                                                    Tempatan</th>
                                                                                <th style="text-align:center;background-color: #9ac4f7;"
                                                                                    class="col-md-12">Isipadu (
                                                                                    &#x33A5; )</th>
                                                                            </tr>

                                                                            @foreach ($jenis_pembeli as $key => $data)
                                                                                <tr style="height:50px;">
                                                                                    <td style="" class="col-md-12">
                                                                                        {{ $data->keterangan }}

                                                                                        @if ($data->keterangan == 'Lain-lain (Nyatakan)')
                                                                                            <br>
                                                                                            <span type="text"
                                                                                                style="margin:10px"
                                                                                                size="100">{{ $form4_e[$key]->catatan ?? 'Tiada Catatan' }}
                                                                                            </span>

                                                                                        @endif

                                                                                        </td>
                                                                                    <td style="text-align:center;">
                                                                                        <input readonly class="text-right"
                                                                                            style="" type="text"
                                                                                            size="10" value= {{ number_format($form4_e[$key]->jumlah_jualan ?? 0,2) }}>
                                                                                    </td>
                                                                                </tr>


                                                                            @endforeach


                                                                            <tr style="height:50px;">
                                                                                <th style="background-color: #9ac4f7;"
                                                                                    class="text-right"
                                                                                    class="col-md-12">Jumlah</th>
                                                                                <td
                                                                                    style="text-align:center;background-color: #9ac4f7;">
                                                                                    <input readonly
                                                                                        style="background-color: #9ac4f7;"
                                                                                        type="text" size="10" class="text-right"
                                                                                        wire:model='total_jumlah_jualan'
                                                                                        onkeypress="return isNumberKey(event)" value ={{ number_format($form4_e[0]->total_jumlah_jualan ?? 0,2)}}>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <br>

                                                                    </div>
                                                                </div>
                                                            </div>


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
                                <script>
                                    function onlyNumberKey(evt) {

                                        // Only ASCII charactar in that range allowed
                                        var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                                        if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                                            return false;
                                        return true;
                                    }
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

                                <style>
                                    table,
                                    th,
                                    td {
                                        border: 1px solid black;
                                    }

                                </style>

                            </div>

                        </div>

                    </div>

                </div>


            @endsection
