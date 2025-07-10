@extends('layouts.layout-ibk-nicepage')

@section('content')

    <style>
        table,
        th,
        td {
            border: 1px solid black;
        }

        th {
            overflow: auto;
            /* height: 100px; */
            width: 200px;
        }

        thead th {
            position: sticky;
            top: 0;
            z-index: 1;
        }

        tbody th {
            position: sticky;
            left: 0;
        }

        /* Just common table stuff. Really. */
        table {
            border-collapse: collapse;
            width: 100%;
            max-width: 100%;
            table-layout: fixed;
        }

        th,
        td {
            padding: 8px 8px;
        }

        th {
            background: #eee;
        }

        thead,
        tbody {
            display: block;
        }

        tbody {
            height: 500px;
            /* Just for the demo          */
            overflow-y: auto;
            /* Trigger vertical scroll    */
            overflow-x: hidden;
            /* Hide the horizontal scroll */
            width: 100%;
        }

        ::-webkit-scrollbar {
            width: 10px;
            /* height: 2em */
        }
        th {
            position: fixed;
            top: 0; /* Don't forget this, required for the stickiness */
        }
    </style>

<div class="container-fluid">
    <!-- ============================================================== -->
    <!-- Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <div class="page-breadcrumb" style="padding: 0px">
        <div class="pb-2 row">
            <div class="col-4 align-self-center">
                <button type="button" wire:loading.attr="disabled" class="btn btn-primary" alt="default"
                    data-toggle="modal" data-target="#sebelumnya_borang_a" class="model_img img-fluid">
                    Kembali</button>
            </div>
            <div class="col-7 align-self-center">
                <div class="d-flex align-items-center justify-content-end">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            @foreach ($breadcrumbs as $breadcrumb)
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
                @if ($kilang_info->shuttle_type == '3')
                    <div class="card-header"
                        style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                        BORANG 3C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK DAN PENGELUARAN KAYU GERGAJI
                            MENGIKUT KUMPULAN KAYU-KAYAN
                    </div>
                @elseif($kilang_info->shuttle_type == '4')
                    <div class="card-header"
                        style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                        BORANG 4C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK MENGIKUT KUMPULAN KAYU-KAYAN

                    </div>
                @elseif($kilang_info->shuttle_type == '5')
                    <div class="card-header"
                        style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                        BORANG 5C - PENYATA KEMASUKAN & PEMPROSESAN KAYU GERGAJI DAN PENGELUARAN KAYU KUMAI
                            MENGIKUT KUMPULAN KAYU-KAYAN
                    </div>
                @endif
                <div class="card-body">


                    <!-- Tab panes -->
                    <div class="tab-content">
                        <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">


                            <table class="table table-striped table-bordered ex3" id="">
                                <div class="row">
                                    <div class="col-12">
                                        <div class="card">

                                            <form class="form-horizontal" action='{{ route('user.view.shuttle-4-formC.LainLain.store', $bulan_id) }}' onsubmit="return checkValidationuSubmit()"
                                                id="lain-lain-form" method="POST">
                                                @csrf
                                                <div class="card-body">

                                                    <div class="row"
                                                        style="justify-content: center;margin-bottom:-0%;">
                                                        <div class="col-md-2">
                                                            <label><b>Tahun:</b></label>
                                                            <input type="text" class="form-control"
                                                                style="background-color: #f0e10dbd; border-color: #a79c09"
                                                                value="{{ $kilang_info->tahun }}"
                                                                readonly />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label><b>Bulan:</b></label>
                                                            <input type="text" class="form-control"
                                                                style="background-color: #f0e10dbd; border-color: #a79c09"
                                                                value="{{ $bulan }}" readonly />

                                                        </div>
                                                        <div class="col-md-3">
                                                            <label><b>Nama Kilang:</b></label>
                                                            <input type="text" class="form-control"
                                                                style="background-color: #f0e10dbd; border-color: #a79c09"
                                                                value="{{ $kilang_info->nama_kilang }}"
                                                                readonly />
                                                        </div>
                                                        {{-- <div class="col-md-2"></div> --}}
                                                        <div class="col-md-2">
                                                            <label><b>No. Pendaftaran Syarikat
                                                                    (SSM):</b></label>
                                                            <input type="text" class="form-control"
                                                                style="background-color: #f0e10dbd; border-color: #a79c09"
                                                                value="{{ $kilang_info->no_ssm }}"
                                                                readonly />
                                                        </div>
                                                        <div class="col-md-2">
                                                            <label><b>No. Lesen:</b></label>
                                                            <input type="text" class="form-control"
                                                                style="background-color: #f0e10dbd; border-color: #a79c09"
                                                                value="{{ $kilang_info->no_lesen }}"
                                                                readonly />
                                                        </div>


                                                    </div>

                                                    <br>
                                                    <div class="row" style="margin-bottom:-2%;"">
                                                        <div class=" col-md-8"></div>
                                                    <div class="col-md-4">

                                                        <div class="legend"
                                                            style="border:2px solid;">

                                                            <b>KKB/HHW</b>: Kayu Keras Berat / <i>Heavy
                                                                Hardwood</i> <br>
                                                            <b>KKS/MHW</b>: Kayu Keras Sederhana / <i>Medium
                                                                Hardwood</i> <br>
                                                            <b>KKR/LHW</b>: Kayu Keras Ringan / <i>Light
                                                                Hardwood</i> <br><br>
                                                            Kadar pertukaran kayu bulat : 1 ton =
                                                            1.8027 m³

                                                            <br>
                                                            Kadar pertukaran kayu sudah proses : 1 ton =
                                                            1.416 m³

                                                            <br>
                                                            <br>
                                                            <b style="color:red">Sila tekan butang CTRL+F
                                                                untuk mencari jenis spesies kayu kayan</b>
                                                                <br>
                                                                <br>
                                                                Paparan terbaik untuk halaman ini adalah 1920x1080 resolusi piksel

                                                        </div>
                                                    </div>
                                                </div>


                                                <div class="row" style="margin-bottom:-2%;">
                                                    <div class="col-md-4"></div>
                                                    <div class="col-md-2"></div>

                                                    <div style="color: rgb(4, 0, 255)"> <b>HALAMAN 5/5</b>
                                                    </div>
                                                </div>

                                                <div class="">
                                                    <table>
                                                        <thead class="">
                                                            <tr style="height:50px;">
                                                                <th style="text-align:center; width: 589px;"
                                                                    colspan="2">Kumpulan Kayu Kayan</th>
                                                                <th style="text-align:center;" colspan="2">
                                                                    Baki Stok Dari Bulan
                                                                    Lepas</th>
                                                                <th style="text-align:center;" colspan="2">
                                                                    Kemasukan Kayu Balak Ke
                                                                    Dalam Kawasan Kilang</th>
                                                                <th style="text-align:center;" colspan="2">
                                                                    Jumlah Stok Kayu Balak
                                                                </th>
                                                                <th style="text-align:center;" colspan="2">Kemasukan
                                                                    Kayu Balak Ke
                                                                    Dalam Jentera Memproses<br>(dikupas)</th>
                                                                <th style="text-align:center;" colspan="2">
                                                                    Baki Stok Kayu Balak
                                                                    Dibawa Ke Bulan Hadapan</th>

                                                            </tr>

                                                            <tr style="height:50px;">
                                                                <th style="text-align:center;" colspan="2">
                                                                    (01)</th>
                                                                <th style="text-align:center;" colspan="2">
                                                                    (m³)<br>(02)
                                                                </th>
                                                                <th style="text-align:center;" colspan="2">
                                                                    (m³)<br>(03)
                                                                </th>
                                                                <th style="text-align:center;" colspan="2">
                                                                    (m³)<br>(04)=(02)+(03)
                                                                </th>
                                                                <th style="text-align:center;" colspan="2">
                                                                    (m³)<br>(05)
                                                                </th>
                                                                <th style="text-align:center;" colspan="2">
                                                                    (m³)<br>(06)=(04)-(05)
                                                                </th>
                                                            </tr>
                                                        </thead>

                                                        <tbody class="">
                                                            @foreach ($kumpulan_kayu as $keyKumpulanKayu => $data)
                                                                    <tr style="height:50px;">
                                                                        <th style="text-align:center;width: 489px;">
                                                                            {{ $data->singkatan }} </th>
                                                                        <th style="text-align:center;width:100px;">
                                                                            Kod</th>
                                                                        <th colspan="2"></th>
                                                                        <th colspan="2"></th>
                                                                        <th colspan="2"></th>
                                                                        <th colspan="2"></th>
                                                                        <th colspan="2"></th>
                                                                    </tr>

                                                                    @foreach ($species as $keySpecies => $data1)

                                                                        @if ($data1->kumpulan_kayu->singkatan == $data->singkatan)
                                                                            <tr style="height:50px;">
                                                                                <td style="text-align:left;">
                                                                                    {{ $data1->nama_tempatan }}
                                                                                </td>
                                                                                <td style="text-align:center;">
                                                                                    {{ $data1->kod }}
                                                                                </td>
                                                                                <td style="text-align:center;" colspan="2">
                                                                                    <input readonly type="text" size="10"
                                                                                        id="baki_stoks.{{ $keySpecies }}"
                                                                                        name="baki_stoks[]"
                                                                                        oninput="validate(this);calculateTotal({{ $keySpecies }})"
                                                                                        style="background-color: #e0ec3754; text-align:right"
                                                                                        onkeypress="return isNumberKey(event)"
                                                                                        value="{{ $baki_stoks[$keySpecies] }}">
                                                                                </td>
                                                                                <td style="text-align:center;" colspan="2">
                                                                                    <input
                                                                                        style="background-color: #ffffff; text-align:right"
                                                                                        id="kayu_masuk.{{ $keySpecies }}"
                                                                                        name="kayu_masuk[]"
                                                                                        type="text" size="10"
                                                                                        oninput="validate(this);calculateTotal({{ $keySpecies }});checkValidationMasuk({{ $keySpecies }})"
                                                                                        onkeypress="return isNumberKey(event)"
                                                                                        value="{{ $kayu_masuk[$keySpecies] }}">
                                                                                </td>
                                                                                <td style="text-align:center;" colspan="2">
                                                                                    <input readonly
                                                                                        style="background-color: #e0ec3754;  text-align:right"
                                                                                        id="jumlah_stok_kayu_balak.{{ $keySpecies }}"
                                                                                        name="jumlah_stok_kayu_balak[]"
                                                                                        type="text" oninput="validate(this);calculateTotal({{ $keySpecies }})"
                                                                                        size="10"
                                                                                        value="{{ $jumlah_stok_kayu_balak[$keySpecies] }}">
                                                                                </td>
                                                                                <td style="text-align:center;" colspan="2">
                                                                                    <input type="text"
                                                                                        style="background-color: #ffffff; text-align:right"
                                                                                        size="10" oninput="validate(this);calculateTotal({{ $keySpecies }});checkValidationMasuk({{ $keySpecies }})"
                                                                                        id='proses_masuk.{{ $keySpecies }}'
                                                                                        name='proses_masuk[]'
                                                                                        onkeypress="return isNumberKey(event)"
                                                                                        value="{{ $proses_masuk[$keySpecies] }}">
                                                                                </td>
                                                                                <td style="text-align:center;" colspan="2">
                                                                                    <input readonly
                                                                                        style="background-color: #e0ec3754; text-align:right"
                                                                                        type="text" oninput="validate(this);calculateTotal({{ $keySpecies }})"
                                                                                        size="10"
                                                                                        id='baki_stok_kehadapan.{{ $keySpecies }}'
                                                                                        name='baki_stok_kehadapan[]'
                                                                                        value="{{ $baki_stok_kehadapan[$keySpecies] }}">
                                                                                </td>
                                                                            </tr>
                                                                        @endif

                                                                    @endforeach

                                                                    <tr style="height:50px;">
                                                                        <th style="text-align:center;" colspan="2">
                                                                            Jumlah</th>
                                                                        <td style="text-align:center;" colspan="2">
                                                                            <input readonly
                                                                                style="background-color: #e0ec3754; text-align:right"
                                                                                type="text" size="10"
                                                                                oninput="validate(this)"
                                                                                id='jumlah_baki_stok.{{ $keyKumpulanKayu }}'
                                                                                name='jumlah_baki_stok[]'
                                                                                value="{{ $jumlah_baki_stok[$keyKumpulanKayu] ?? 0}}">
                                                                        </td>
                                                                        <td style="text-align:center;" colspan="2">
                                                                            <input readonly
                                                                                style="background-color: #e0ec3754; text-align:right"
                                                                                type="text" size="10"
                                                                                oninput="validate(this)"
                                                                                id='jumlah_kayu_masuk.{{ $keyKumpulanKayu }}'
                                                                                name='jumlah_kayu_masuk[]'
                                                                                value="{{ $jumlah_kayu_masuk[$keyKumpulanKayu] ?? 0}}">
                                                                        </td>
                                                                        <td style="text-align:center;" colspan="2">
                                                                            <input readonly
                                                                                style="background-color: #e0ec3754; text-align:right"
                                                                                type="text" size="10"
                                                                                oninput="validate(this)"
                                                                                id='total_stok_kayu_balak.{{ $keyKumpulanKayu }}'
                                                                                name='total_stok_kayu_balak[]'
                                                                                value="{{ $total_stok_kayu_balak[$keyKumpulanKayu] ?? 0}}">
                                                                        </td>
                                                                        <td style="text-align:center;" colspan="2">
                                                                            <input readonly
                                                                                style="background-color: #e0ec3754; text-align:right"
                                                                                type="text" size="10"
                                                                                oninput="validate(this)"
                                                                                id='total_kayu_masuk_jentera.{{ $keyKumpulanKayu }}'
                                                                                name='total_kayu_masuk_jentera[]'
                                                                                value="{{ $total_kayu_masuk_jentera[$keyKumpulanKayu] ?? 0}}">
                                                                        </td>
                                                                        <td style="text-align:center;" colspan="2">
                                                                            <input readonly
                                                                                style="background-color: #e0ec3754; text-align:right"
                                                                                type="text" size="10"
                                                                                oninput="validate(this)"
                                                                                id='total_kayu_dibawa_bulan_hadapan.{{ $keyKumpulanKayu }}'
                                                                                name='total_kayu_dibawa_bulan_hadapan[]'
                                                                                value="{{ $total_kayu_dibawa_bulan_hadapan[$keyKumpulanKayu] ?? 0 }}">
                                                                        </td>
                                                                    </tr>

                                                                @endforeach

                                                            <tr style="height:50px;">
                                                                <th style="text-align:center;" colspan="2">
                                                                    Jumlah Besar </th>
                                                                <td style="text-align:center;" colspan="2">
                                                                    <input readonly
                                                                        style="background-color: #e0ec3754; text-align:right"
                                                                        type="text"
                                                                        oninput="validate(this)"
                                                                        size="10"
                                                                        name='jumlah_besar_baki_stok_bulan_lepas'
                                                                        id='jumlah_besar_baki_stok_bulan_lepas'
                                                                        value="{{ $besar_jumlah_baki_stok }}">
                                                                </td>
                                                                <td style="text-align:center;" colspan="2">
                                                                    <input readonly
                                                                        style="background-color: #e0ec3754; text-align:right"
                                                                        type="text"
                                                                        oninput="validate(this)"
                                                                        size="10"
                                                                        name='jumlah_besar_kemasukan_kayu_ke_kilang'
                                                                        id='jumlah_besar_kemasukan_kayu_ke_kilang'
                                                                        value="{{ $besar_jumlah_kayu_masuk }}">
                                                                </td>
                                                                <td style="text-align:center;" colspan="2">
                                                                    <input readonly
                                                                        style="background-color: #e0ec3754; text-align:right"
                                                                        type="text" size="10" oninput="validate(this)"
                                                                        name='jumlah_besar_stok_kayu_balak'
                                                                        id='jumlah_besar_stok_kayu_balak'
                                                                        value="{{ $besar_total_stok_kayu_balak }}">
                                                                </td>
                                                                <td style="text-align:center;" colspan="2">
                                                                    <input readonly
                                                                        style="background-color: #e0ec3754; text-align:right"
                                                                        type="text" size="10" oninput="validate(this)"
                                                                        name='jumlah_besar_kayu_ke_dalam_jentera'
                                                                        id='jumlah_besar_kayu_ke_dalam_jentera'
                                                                        value="{{ $besar_total_kayu_masuk_jentera }}">
                                                                </td>
                                                                <td style="text-align:center;" colspan="2">
                                                                    <input readonly
                                                                        style="background-color: #e0ec3754; text-align:right"
                                                                        type="text" size="10" oninput="validate(this)"
                                                                        name='jumlah_besar_baki_stok_bulan_depan'
                                                                        id='jumlah_besar_baki_stok_bulan_depan'
                                                                        value="{{ $besar_total_kayu_dibawa_bulan_hadapan }}">
                                                                </td>
                                                            </tr>
                                                        </tbody>


                                                    </table>
                                                </div>
                                                <br>
                                        </div>
                                    </div>
                                </div>

                                <hr>
                                <div class="card-body">

                                    <div class="text-right form-group m-b-0">
                                        <button type="button" wire:loading.attr="disabled"
                                            class="btn btn-primary" alt="default" data-toggle="modal"
                                            data-target="#sebelumnya_borang_a" class="model_img img-fluid">
                                            Sebelumnya</button>

                                     @if($besar_jumlah_kayu_masuk != 0)
                                        <button type="button" id="submit_button"
                                            class="btn btn-primary" alt="default" data-toggle="modal"
                                            data-target="#confirmation_borang_a"
                                            class="model_img img-fluid">
                                            Hantar</button>
                                    @else
                                        <button type="button" class="btn btn-primary" alt="default" id="submit_button"
                                        data-toggle="modal" data-target="#tiada_pengeluaran"
                                        class="model_img img-fluid">
                                        Tiada Pengeluaran</button>
                                    @endif

                                    </div>
                                </div>

                                <div class="modal fade" id="tiada_pengeluaran"
                                        tabindex="-1" role="dialog"
                                        aria-labelledby="tiada_pengeluaranTitle"
                                        aria-hidden="true">
                                        <div class="modal-dialog modal-dialog-centered"
                                            role="document">
                                            <div class="modal-content">
                                                <div class="modal-header" style="background-color:#f3ce8f  !important">
                                                    <h5 class="modal-title "
                                                        id="exampleModalLongTitle"><i style="color:rgb(255, 255, 0)"
                                                            class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                    </h5>
                                                    <button type="button" class="close"
                                                        data-dismiss="modal" aria-label="Close">
                                                        <span aria-hidden="true">&times;</span>
                                                    </button>
                                                </div>
                                                <div class="modal-body">

                                                <span class="text-center"><b>Adakah anda pasti kilang anda tiada pengeluaran?</b></span>

                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn btn-danger"
                                                        data-dismiss="modal">TIDAK</button>
                                                    <button type="submit" name="tiadaPengeluaran" value="1" class="btn btn-success">
                                                        <div>YA</div>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                <div class="modal fade" id="confirmation_borang_a" tabindex="-1"
                                    role="dialog" aria-labelledby="confirmation_borang_aTitle"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header"
                                                style="background-color:#f3ce8f  !important">
                                                <h5 class="modal-title " id="exampleModalLongTitle"><i
                                                        style="color:rgb(255, 255, 0)"
                                                        class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                </h5>
                                                <button type="button" class="close"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <span class="text-center"><b>Adakah anda pasti ingin
                                                    menghantar borang ini?</b></span>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger" wire:loading.attr="disabled"
                                                    data-dismiss="modal">Batal</button>
                                                <button type="submit"
                                                    class="btn btn-success">
                                                    <div>HANTAR</div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="modal fade" id="sebelumnya_borang_a" tabindex="-1"
                                    role="dialog" aria-labelledby="sebelumnya_borang_aTitle"
                                    aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered" role="document">
                                        <div class="modal-content">
                                            <div class="modal-header"
                                                style="background-color:#f3ce8f  !important">
                                                <h5 class="modal-title " id="exampleModalLongTitle"><i
                                                        style="color:rgb(255, 255, 0)"
                                                        class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                </h5>
                                                <button type="button" class="close"
                                                    data-dismiss="modal" aria-label="Close">
                                                    <span aria-hidden="true">&times;</span>
                                                </button>
                                            </div>
                                            <div class="modal-body">

                                                <span class="text-center"><b>Adakah anda pasti untuk ke
                                                    paparan sebelum ini?</b></span>

                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-danger"
                                                    data-dismiss="modal">TIDAK</button>
                                                <button type="submit" name="sebelumnya" value="1"
                                                    class="btn btn-success">
                                                    <div>YA</div>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                </form>
                        </div>

                    </div>

                    </table>
                </div>
            </div>

            <script>
                $(document).ready(function() {
                    $(window).keydown(function(event) {
                        if (event.keyCode == 13) {
                            event.preventDefault();
                            return false;
                        }
                    });
                });

                function onlyNumberKey(evt) {

                    // Only ASCII charactar in that range allowed
                    var ASCIICode = (evt.which) ? evt.which : evt.keyCode
                    if (ASCIICode > 31 && (ASCIICode < 48 || ASCIICode > 57))
                        return false;
                    return true;
                }
            </script>

            <script>
                var validate = function(e) {
                    var t = e.value;
                    e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
                }
            </script>

            <script>

                function calculateTotal(key) {
                    var species_count = {{ $species_count }};
                    var jumlah_kayu_masuk = 0, total_stok_kayu_balak = 0, total_kayu_masuk_jentera = 0, total_kayu_dibawa_bulan_hadapan = 0, total_kayu_keluar_jentera = 0;
                    var jumlah_besar_baki_stok_bulan_lepas = {{ $besar_jumlah_baki_stok_tanpa_lain }}, jumlah_besar_kemasukan_kayu_ke_kilang = {{ $besar_jumlah_kayu_masuk_tanpa_lain }},  jumlah_besar_stok_kayu_balak = {{ $besar_total_stok_kayu_balak_tanpa_lain }},
                    jumlah_besar_kayu_ke_dalam_jentera = {{ $besar_total_kayu_masuk_jentera_tanpa_lain }}, jumlah_besar_baki_stok_bulan_depan = {{ $besar_total_kayu_dibawa_bulan_hadapan_tanpa_lain }};

                    for (let index = 0; index < species_count; index++) {

                        var baki_stoks = parseFloat(document.getElementById("baki_stoks." + index).value);
                        var kayu_masuk = parseFloat(document.getElementById("kayu_masuk." + index).value);
                        var proses_masuk = parseFloat(document.getElementById("proses_masuk." + index).value);
                        var jumlah_stok_kayu_balak = 0;
                        var baki_stok_kehadapan = 0;

                        jumlah_stok_kayu_balak = kayu_masuk + baki_stoks || 0;
                        document.getElementById("jumlah_stok_kayu_balak." + index).value  = parseFloat(jumlah_stok_kayu_balak).toFixed(2);

                        baki_stok_kehadapan = jumlah_stok_kayu_balak - proses_masuk || 0;
                        document.getElementById("baki_stok_kehadapan." + index).value  = parseFloat(baki_stok_kehadapan).toFixed(2);

                        jumlah_kayu_masuk += kayu_masuk || 0;
                        total_stok_kayu_balak += kayu_masuk + baki_stoks  || 0;
                        total_kayu_masuk_jentera += proses_masuk || 0;
                        total_kayu_dibawa_bulan_hadapan += baki_stok_kehadapan|| 0;
                    }

                    jumlah_besar_kemasukan_kayu_ke_kilang += jumlah_kayu_masuk;
                    jumlah_besar_stok_kayu_balak += total_stok_kayu_balak;
                    jumlah_besar_kayu_ke_dalam_jentera += total_kayu_masuk_jentera;
                    jumlah_besar_baki_stok_bulan_depan += total_kayu_dibawa_bulan_hadapan;
                    // console.log(jumlah_besar_kemasukan_kayu_ke_kilang);

                    document.getElementById("jumlah_kayu_masuk.0").value =  parseFloat(jumlah_kayu_masuk).toFixed(2);
                    document.getElementById("total_stok_kayu_balak.0").value = parseFloat(total_stok_kayu_balak).toFixed(2);
                    document.getElementById("total_kayu_masuk_jentera.0").value = parseFloat(total_kayu_masuk_jentera).toFixed(2);
                    document.getElementById("total_kayu_dibawa_bulan_hadapan.0").value = parseFloat(total_kayu_dibawa_bulan_hadapan).toFixed(2);

                    document.getElementById("jumlah_besar_kemasukan_kayu_ke_kilang").value =  parseFloat(jumlah_besar_kemasukan_kayu_ke_kilang).toFixed(2);
                    document.getElementById("jumlah_besar_stok_kayu_balak").value =  parseFloat(jumlah_besar_stok_kayu_balak).toFixed(2);
                    document.getElementById("jumlah_besar_kayu_ke_dalam_jentera").value =  parseFloat(jumlah_besar_kayu_ke_dalam_jentera).toFixed(2);
                    document.getElementById("jumlah_besar_baki_stok_bulan_depan").value =  parseFloat(jumlah_besar_baki_stok_bulan_depan).toFixed(2);

                    console.log(jumlah_besar_kemasukan_kayu_ke_kilang);
                    if(jumlah_besar_kemasukan_kayu_ke_kilang > 0){
                        let element = document.getElementById('submit_button');
                        element.setAttribute('data-target', '#confirmation_borang_a');
                        element.innerHTML = "Hantar";
                    }
                }

                function checkValidationMasuk(key) {
                    var kayu_masuk = document.getElementById("kayu_masuk." + key).value;
                    var proses_masuk = document.getElementById("proses_masuk." + key).value;
                    if(parseFloat(proses_masuk) > parseFloat(kayu_masuk)){
                        if ($('#proses_masuk_validation').length === 1) {
                            $('#proses_masuk_validation').remove();
                        }
                        var img = document.createElement('i');
                        img.setAttribute('id', 'proses_masuk_validation');
                        img.setAttribute('class', 'fas fa-exclamation-circle');
                        img.setAttribute('style', 'color: red');
                        img.setAttribute('title', 'Kemasukan Kayu Balak Ke Dalam Jentera Memproses (05) mestilah tidak melebihi ataupun sama daripada Jumlah Stok Kayu Balak (04)');

                        document.getElementById("proses_masuk." + key).parentNode.appendChild(img);
                    }else{
                        if ($('#proses_masuk_validation').length === 1) {
                            $('#proses_masuk_validation').remove();
                        }
                    }

                }

                function checkValidationuSubmit() {
                    var species_count = {{ $species_count }};
                    var min = {{ $min_recovery_rate }}, max = {{ $max_recovery_rate }};

                    for (let index = 0; index < species_count; index++)
                    {
                        var total_kayu_dibawa_bulan_hadapan = parseFloat(document.getElementById("baki_stok_kehadapan." + index).value);
                        var proses_masuk = parseFloat(document.getElementById("proses_masuk." + index).value);

                        var jumlah_stok_kayu_balak = parseFloat(document.getElementById("jumlah_stok_kayu_balak." + index).value);

                        var min_value = parseFloat(proses_masuk).toFixed(2) * parseFloat(min);
                        var max_value = parseFloat(proses_masuk).toFixed(2) * parseFloat(max);

                        if(proses_masuk > jumlah_stok_kayu_balak){
                            // alert('Kemasukan Kayu Balak Ke Dalam Jentera Memproses (05) mestilah tidak melebihi ataupun sama daripada Jumlah Stok Kayu Balak (04)');
                            toastr.error('Kemasukan Kayu Balak Ke Dalam Jentera Memproses (05) mestilah tidak melebihi ataupun sama daripada Jumlah Stok Kayu Balak (04)', 'Ralat', { "progressBar": true });
                            return false;
                        }
                    }
                }

            </script>


@endsection
