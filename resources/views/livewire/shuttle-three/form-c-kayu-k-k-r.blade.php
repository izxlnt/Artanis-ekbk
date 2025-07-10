
        <div>

            <div class="container-fluid">
                <!-- ============================================================== -->
                <!-- Bread crumb and right sidebar toggle -->
                <!-- ============================================================== -->
                <div class="page-breadcrumb" style="padding: 0px">
                    <div class="pb-2 row">
                        <div class="col-5 align-self-center">
                            <button type="button" wire:loading.attr="disabled" class="btn btn-primary" alt="default"
                                data-toggle="modal" data-target="#sebelumnya_borang_a"
                                class="model_img img-fluid">
                            Kembali</button>
                        </div>
                        <div class="col-7 align-self-center">
                            <div class="d-flex align-items-center justify-content-end">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                        @foreach ($returnArr['breadcrumbs'] as $breadcrumb)
                                            @if (!$loop->last)
                                                <li class="breadcrumb-item">
                                                    <a href="{{ $breadcrumb['link'] }}" style="color: white !important;" onMouseOver="this.style.color='lightblue'" onMouseOut="this.style.color='white'"> {{ $breadcrumb['name'] }}
                                                    </a>
                                                </li>
                                            @else
                                            <li class="breadcrumb-item active" aria-current="page" style="color: yellow !important;">
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
                            @if($kilang_info->shuttle_type == '3')
                            <div class="card-header"
                                style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                                BORANG 3C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK <br> DAN PENGELUARAN KAYU GERGAJI
                                MENGIKUT KUMPULAN KAYU-KAYAN
                            </div>
                            @elseif($kilang_info->shuttle_type == '4')
                            <div class="card-header"
                                style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                                BORANG 4C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK <br> DAN PENGELUARAN KAYU GERGAJI
                                MENGIKUT KUMPULAN KAYU-KAYAN
                            </div>
                            @elseif($kilang_info->shuttle_type == '5')
                            <div class="card-header"
                                style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                                BORANG 5C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK <br> DAN PENGELUARAN KAYU GERGAJI
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

                                                        <form class="form-horizontal" wire:submit.prevent='store' id="kkr"
                                                            style="">
                                                            <div class="card-body">

                                                                <div class="row" style="justify-content: center;margin-bottom:-0%;">
                                                                    <div class="col-md-2">
                                                                        <label><b>Tahun:</b></label>
                                                                       <input type="text" class="form-control"
                                                                            style="background-color: #f0e10dbd; border-color: #a79c09"
                                                                            value="{{ $kilang_info->tahun }}" readonly />
                                                                    </div>
                                                                    <div class="col-md-2">
                                                                        <label><b>Bulan:</b></label>
                                                                        <input type="text"
                                                                        class="form-control"
                                                                        style="background-color: #f0e10dbd; border-color: #a79c09"
                                                                        value="{{ $bulan }}"
                                                                        readonly />

                                                                    </div>
                                                                       <div class="col-md-3">
                                                                        <label><b>Nama Kilang:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #f0e10dbd; border-color: #a79c09"
                                                                            value="{{ $kilang_info->nama_kilang }}" readonly />
                                                                    </div>
                                                                    {{-- <div class="col-md-2"></div> --}}
                                                                       <div class="col-md-2">
                                                                        <label><b>No. Pendaftaran Syarikat (SSM):</b></label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #f0e10dbd; border-color: #a79c09"
                                                                            value="{{ $kilang_info->no_ssm }}" readonly />
                                                                    </div>
                                                                       <div class="col-md-2">
                                                                        <label><b>No. Lesen:</b></label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #f0e10dbd; border-color: #a79c09"
                                                                            value="{{ $kilang_info->no_lesen }}" readonly />
                                                                    </div>


                                                                </div>

                                                                <br>
                                                                <div class="row" style="margin-bottom:-2%;"">
                                                                    <div class="col-md-8"></div>
                                                                    <div class="col-md-4">

                                                                            <div class="legend" style="border:2px solid;">

                                                                                    <b>KKB/HHW</b>: Kayu Keras Berat / <i>Heavy Hardwood</i> <br>
                                                                                    <b>KKS/MHW</b>: Kayu Keras Sederhana / <i>Medium Hardwood</i> <br>
                                                                                    <b>KKR/LHW</b>: Kayu Keras Ringan / <i>Light Hardwood</i> <br><br>
                                                                                    Kadar pertukaran kayu bulat : 1 ton =
                                                                                    1.8027 m³

                                                                                    <br>
                                                                                    Kadar pertukaran kayu sudah proses : 1 ton =
                                                                                    1.416 m³

                                                                                <br>
                                                                                <br>
                                                                                <b style="color:red">Sila tekan butang CTRL+F untuk mencari jenis spesies kayu kayan</b>

                                                                            </div>
                                                                    </div>
                                                                </div>

                                                                <div class="row" style="margin-bottom:-2%;">
                                                                    <div class="col-md-4"></div>
                                                                    <div class="col-md-2"></div>

                                                                    <div style="color: rgb(4, 0, 255)"> <b>HALAMAN 3/5
                                                                    </div>
                                                                </div>

                                                                <div class="">
                                                                    <table>
                                                                        <thead class="">
                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center; width: 389px;"
                                                                                    colspan="2">Kumpulan Kayu Kayan</th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">Baki Stok Dari Bulan
                                                                                    Lepas</th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">Kemasukan Kayu Balak Ke
                                                                                    Dalam Kawasan Kilang</th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">Jumlah Stok Kayu Balak
                                                                                </th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">Kemasukan Kayu Balak Ke
                                                                                    Dalam Jentera Memproses</th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">Pengeluaran Kayu Gergaji
                                                                                    Daripada Jentera Memproses</th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">Baki Stok Kayu Balak
                                                                                    Dibawa Ke Bulan Hadapan</th>

                                                                            </tr>

                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">(01)</th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">(m³)<br>(02)
                                                                                </th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">(m³)<br>(03)
                                                                                </th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">(m³)<br>(04)=(02)+(03)
                                                                                </th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">(m³)<br>(05)
                                                                                </th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">(m³)<br>(06)
                                                                                </th>
                                                                                <th style="text-align:center;"
                                                                                    colspan="2">(m³)<br>(07)=(04)-(05)
                                                                                </th>
                                                                            </tr>
                                                                        </thead>

                                                                        <tbody class="">
                                                                            @foreach ($kumpulan_kayu as $keyKumpulanKayu => $data)
                                                                                <tr style="height:50px;">
                                                                                    <th
                                                                                        style="text-align:center;width: 289px;">
                                                                                        {{ $data->singkatan }} </th>
                                                                                    <th
                                                                                        style="text-align:center;width:100px;">
                                                                                        Kod</th>
                                                                                    <th colspan="2"></th>
                                                                                    <th colspan="2"></th>
                                                                                    <th colspan="2"></th>
                                                                                    <th colspan="2"></th>
                                                                                    <th colspan="2"></th>
                                                                                    <th colspan="2"></th>
                                                                                </tr>

                                                                                @foreach ($species as $keySpecies => $data1)

                                                                                    @if ($data1->kumpulan_kayu->singkatan == $data->singkatan)
                                                                                        <tr style="height:50px;">
                                                                                            <td
                                                                                                style="text-align:left;">
                                                                                                {{ $data1->nama_tempatan }}
                                                                                            </td>
                                                                                            <td
                                                                                                style="text-align:center;">
                                                                                                {{ $data1->kod }}
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2"><input
                                                                                                    readonly
                                                                                                    type="text"
                                                                                                    size="10"
                                                                                                    oninput="validate(this)"
                                                                                                    style="background-color: #e0ec3754; text-align:right"
                                                                                                    wire:model.defer='baki_stok.{{ $keySpecies }}'
                                                                                                    wire:change="calcJumlahKayuMasuk({{ $keySpecies }}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');"
                                                                                                    onkeypress="return isNumberKey(event)">
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2"><input
                                                                                                    style="background-color: #ffffff; text-align:left"
                                                                                                    type="text"
                                                                                                    oninput="validate(this)"
                                                                                                    size="10"
                                                                                                    wire:model.defer='kayu_masuk.{{ $keySpecies }}'
                                                                                                    wire:change="calcJumlahKayuMasuk({{ $keySpecies }}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');"
                                                                                                    onkeypress="return isNumberKey(event)">
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2"><input
                                                                                                    readonly
                                                                                                    style="background-color: #e0ec3754; text-align:right"
                                                                                                    type="text"
                                                                                                    oninput="validate(this)"
                                                                                                    size="10"
                                                                                                    wire:model.defer='jumlah_stok_kayu_balak.{{ $keySpecies }}'
                                                                                                    wire:change="calcTotalStokKayuDibawaBulanHadapan({{ $keySpecies }}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');">
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2">
                                                                                                <input type="text"
                                                                                                 style="background-color: #ffffff; text-align:left"
                                                                                                    size="10"
                                                                                                    oninput="validate(this)"
                                                                                                    wire:model.defer='proses_masuk.{{ $keySpecies }}'
                                                                                                    wire:change="calcJumlahKayuMasuk({{ $keySpecies }}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');"
                                                                                                    onkeypress="return isNumberKey(event)"
                                                                                                    style="@error('proses_masuk.' . $keySpecies) color:red; outline: 2px solid red @else color:black @endif">
                                                                                                @error('proses_masuk.' .
                                                                                                    $keySpecies)
                                                                                                    <i class="fas fa-exclamation-circle"
                                                                                                        style="color: red"
                                                                                                        title="Kemasukan Kayu Balak Ke Dalam Jentera Memproses (05) &#013;mestilah tidak melebihi ataupun sama daripada &#013;Jumlah Stok Kayu Balak (04)"></i>
                                                                                                @enderror
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2">
                                                                                                <input type="text"
                                                                                                    style="background-color: #ffffff; text-align:left"
                                                                                                    size="10"
                                                                                                    oninput="validate(this)"
                                                                                                    wire:model.defer='proses_keluar.{{ $keySpecies }}'
                                                                                                    wire:change="calcJumlahKayuMasuk({{ $keySpecies }}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');"
                                                                                                    onkeypress="return isNumberKey(event)"
                                                                                                    style="@error('proses_keluar.' . $keySpecies) color:red; outline: 2px solid red @else color:black @endif">
                                                                                                @error('proses_keluar.'
                                                                                                    . $keySpecies)
                                                                                                    <i class="fas fa-exclamation-circle"
                                                                                                        style="color: red"
                                                                                                        title="Pengeluaran Kayu Gergaji Daripada Jentera Memproses (06) &#013;mestilah tidak melebihi min. {{ $min_rate[$keySpecies] }} dan max. {{ $max_rate[$keySpecies] }} daripada &#013;Kemasukan Kayu Balak Ke Dalam Jentera Memproses (05)"></i>
                                                                                                @enderror
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2"><input
                                                                                                    readonly
                                                                                                    style="background-color: #e0ec3754; text-align:right"
                                                                                                    type="text"
                                                                                                    oninput="validate(this)"
                                                                                                    size="10"
                                                                                                    wire:model.defer='baki_stok_kehadapan.{{ $keySpecies }}'>
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif

                                                                                @endforeach

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:center;"
                                                                                        colspan="2"> Jumlah</th>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754; text-align:right"
                                                                                            type="text" size="10" oninput="validate(this)"
                                                                                            wire:model.defer='jumlah_baki_stok.{{ $keyKumpulanKayu }}'>
                                                                                    </td>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754; text-align:right"
                                                                                            type="text" size="10" oninput="validate(this)"
                                                                                            wire:model.defer='jumlah_kayu_masuk.{{ $keyKumpulanKayu }}'>
                                                                                    </td>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754; text-align:right"
                                                                                            type="text" size="10" oninput="validate(this)"
                                                                                            wire:model.defer='total_stok_kayu_balak.{{ $keyKumpulanKayu }}'>
                                                                                    </td>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754; text-align:right"
                                                                                            type="text" size="10" oninput="validate(this)"
                                                                                            wire:model.defer='total_kayu_masuk_jentera.{{ $keyKumpulanKayu }}'>
                                                                                    </td>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754; text-align:right"
                                                                                            type="text" size="10" oninput="validate(this)"
                                                                                            wire:model.defer='total_kayu_keluar_jentera.{{ $keyKumpulanKayu }}'>
                                                                                    </td>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754; text-align:right"
                                                                                            type="text" size="10" oninput="validate(this)"
                                                                                            wire:model.defer='total_kayu_dibawa_bulan_hadapan.{{ $keyKumpulanKayu }}'>
                                                                                    </td>
                                                                                </tr>

                                                                            @endforeach

                                                                            {{-- <tr style="height:50px;">
                                                                                <th style="text-align:center;"
                                                                                    colspan="2"> Jumlah Besar </th>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        wire:model.defer='jumlah_besar_baki_stok_bulan_lepas'>
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        wire:model.defer='jumlah_besar_kemasukan_kayu_ke_kilang'>
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        wire:model.defer='jumlah_besar_stok_kayu_balak'>
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        wire:model.defer='jumlah_besar_kayu_ke_dalam_jentera'>
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        wire:model.defer='jumlah_besar_pengeluaran_kayu_daripada_jentera'>
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        wire:model.defer='jumlah_besar_baki_stok_bulan_depan'>
                                                                                </td>
                                                                            </tr> --}}
                                                                        </tbody>


                                                                    </table>
                                                                </div>
                                                                <br>
                                                            </div>
                                                    </div>
                                                </div>

                                                <hr>
                                                <div class="card-body">

                                                    {{-- @if ($errors->any())
                                                        @error('proses_masuk.*')
                                                            <div class="text-center form-group m-b-0">
                                                                <h4 style="color:red"><b>Kemasukan Kayu Balak Ke Dalam
                                                                        Jentera Memproses (05)</b> mestilah tidak melebihi
                                                                    ataupun sama daripada <b>Jumlah Stok Kayu Balak (04)
                                                                    </b>
                                                                </h4>
                                                            </div>
                                                        @enderror
                                                        @error('proses_keluar.*')
                                                            <div class="text-center form-group m-b-0">
                                                                <h4 style="color:red"><b>Pengeluaran Kayu Gergaji Daripada
                                                                        Jentera Memproses (06)</b> mestilah tidak melebihi
                                                                    <b>Kemasukan Kayu Balak Ke Dalam Jentera Memproses (05)
                                                                    </b>
                                                                </h4>
                                                            </div>
                                                        @enderror
                                                    @endif --}}

                                                    <div class="text-right form-group m-b-0">
                                                        <button type="button" wire:loading.attr="disabled"  class="btn btn-primary" alt="default"
                                                            data-toggle="modal" data-target="#sebelumnya_borang_a"
                                                                class="model_img img-fluid">
                                                                Sebelumnya</button>
                                                        @if ($errors->isEmpty())
                                                            <button type="button" wire:loading.attr="disabled"  class="btn btn-primary" alt="default"
                                                            data-toggle="modal" data-target="#confirmation_borang_a"
                                                                class="model_img img-fluid">
                                                                Seterusnya</button>

                                                        @else
                                                            <button type="submit" class="btn btn-primary"
                                                                disabled>RALAT</button>
                                                            {{-- <button type="submit" class="btn btn-primary" >Simpan</button> --}}
                                                        @endif

                                                    </div>
                                                </div>

                                                <div class="modal fade" id="confirmation_borang_a"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="confirmation_borang_aTitle"
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

                                                                <span class="text-center"><b>Adakah anda pasti untuk ke paparan seterusnya?</span>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" wire:loading.attr="disabled"
                                                                    data-dismiss="modal">TIDAK</button>
                                                                <button type="submit" wire:loading.attr="disabled"
                                                                    class="btn btn-success">
                                                                 <div wire:loading wire:target="store">
                                                                        <div class="la-ball-pulse-sync la-sm">
                                                                            <div></div>
                                                                            <div></div>
                                                                            <div></div>
                                                                        </div>
                                                                    </div>
                                                                <div wire:loading.remove wire:target="store">YA</div>
                                                            </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="modal fade" id="sebelumnya_borang_a"
                                                    tabindex="-1" role="dialog"
                                                    aria-labelledby="sebelumnya_borang_aTitle"
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

                                                            <span class="text-center"><b>Adakah anda pasti untuk ke paparan sebelum ini?</span>

                                                            </div>
                                                            <div class="modal-footer">
                                                                <button type="button" class="btn btn-danger" wire:loading.attr="disabled"
                                                                    data-dismiss="modal">TIDAK</button>
                                                                <button type="button" wire:loading.attr="disabled" wire:click="$emit('sebelumnya')"
                                                                    class="btn btn-success">
                                                                    <div wire:loading wire:target="store">
                                                                            <div class="la-ball-pulse-sync la-sm">
                                                                                <div></div>
                                                                                <div></div>
                                                                                <div></div>
                                                                            </div>
                                                                        </div>
                                                                    <div wire:loading.remove wire:target="store">YA</div>
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

                        </div>



    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
    <script>
        $(document).ready(function() {
            $(window).keydown(function(event){
                if(event.keyCode == 13) {
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
        $('#kkr').submit(function(e) {
            e.preventDefault();
            // Coding
            // console.log('lol');
            // $('#responsive-modal').modal('hide'); //or  $('#IDModal').modal('hide');
            $('#responsive-modal').modal('hide');
            $('body').removeClass('modal-open');
            $('.modal-backdrop').remove();
            return false;
        });
    </script>

<script>

    var validate = function(e) {
        var t = e.value;
        e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
    }
</script>
