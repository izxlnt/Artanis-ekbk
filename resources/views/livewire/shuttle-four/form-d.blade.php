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
                    <div class="card-header"
                        style="text-align:center; background-color: #6df173 !important; font-size: 130%; font-weight: bold;">
                        BORANG 4D - PENYATA PENGELUARAN DARIPADA JENTERA MEMPROSES PAPAN LAPIS/VENIR
                    </div>
                    <div class="card-body">

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                                <br>
                                <div class="">
                                    <table class="table table-striped table-bordered" id=""
                                        style="width: 100%;">
                                        <form class="form-horizontal" wire:submit.prevent='store' id="formd">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">


                                                        <div class="card-body">

                                                            <div class="row"
                                                                style="justify-content: center;margin-bottom:-2%;">
                                                                <div class="col-md-2">
                                                                    <label><b>Tahun:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #7ee48c6b; border-color: #6df173"
                                                                        value="{{ $kilang_info->tahun }}" readonly />
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label><b>Bulan:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #7ee48c6b; border-color: #6df173"
                                                                        value="{{ $bulan }}" readonly />

                                                                </div>
                                                                <div class="col-md-3">
                                                                    <label><b>Nama Kilang:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #7ee48c6b; border-color: #6df173"
                                                                        value="{{ $kilang_info->nama_kilang }}"
                                                                        readonly />
                                                                </div>
                                                                {{-- <div class="col-md-2"></div> --}}
                                                                <div class="col-md-2">
                                                                    <label><b>No. Pendaftaran Syarikat
                                                                            (SSM):</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #7ee48c6b; border-color: #6df173"
                                                                        value="{{ $kilang_info->no_ssm }}" readonly />
                                                                </div>
                                                                <div class="col-md-2">
                                                                    <label><b>No. Lesen:</b></label>
                                                                    <input type="text" class="form-control"
                                                                        style="background-color: #7ee48c6b; border-color: #6df173"
                                                                        value="{{ $kilang_info->no_lesen }}" readonly />
                                                                </div>


                                                            </div>

                                                            <div class="row"
                                                                style="justify-content: center; margin-bottom:-2%;padding-top:50px;">
                                                                <div class="col-md-3">
                                                                    @if ($formc->status != 'Tiada Pengeluaran')
                                                                        <label><b>Jumlah Besar Kemasukan Kayu Balak ke
                                                                                Dalam
                                                                                Jentera Memproses
                                                                                (dikupas) m³:</b></label>

                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #7ee48c6b; border-color: #6df173"
                                                                            value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_besar_kayu_ke_dalam_jentera,2) ?? 0 }}"
                                                                            readonly />
                                                                    @endif

                                                                </div>
                                                                <div class="col-md-2">

                                                                </div>
                                                                <div class="col-md-2">

                                                                </div>
                                                                <div class="col-md-4" style="margin-top:2%;">
                                                                    <div class="legend" style="border:2px solid;">

                                                                        <b>MR</b>: <i>Moisture Resistant</i> (tahan
                                                                        lembap) <br>
                                                                        <b>WBP</b>: <i>Weather and Boil Proof</i> (tahan
                                                                        rebus dan cuaca) <br>

                                                                    </div>
                                                                </div>

                                                            </div>


                                                            <table class="table-responsive">
                                                                <tr style="height:50px;">
                                                                    <th style="text-align:center;background-color: #7ee48c6b;"
                                                                        class="col-md-12" colspan="3">PENGELUARAN
                                                                    </th>
                                                                </tr>

                                                                <tr style="height:50px;">
                                                                    <th style="background-color: #7ee48c6b;"
                                                                        class="">A. PAPAN
                                                                        LAPIS</th>
                                                                    <th style="text-align:center;background-color: #7ee48c6b;"
                                                                        class=""> MR
                                                                        (m³) </th>
                                                                    <th style="text-align:center;background-color: #7ee48c6b;"
                                                                        class="">WBP
                                                                        (m³) </th>
                                                                </tr>

                                                                <tr style="height:50px;">
                                                                    <th style="" class="col-md-12">
                                                                        "Nipis" (Ketebalan kurang
                                                                        daripada 12mm)</th>
                                                                    <td style="text-align:center;"></td>
                                                                    <td style="text-align:center;"></td>
                                                                </tr>

                                                                <tr style="height:50px;">
                                                                    <td style="text-align:center;padding: 10px">
                                                                        <input type="text" size="70"
                                                                            onkeypress="return isNumberKey(event)"
                                                                            style="@error('produk_ketebalan_a.0') color:red;outline: 2px solid red; @else color:black @endif"
                                                                            wire:model="produk_ketebalan_a.0">
                                                                        @error('produk_ketebalan_a.0')
                                                                            <i class="fas fa-exclamation-circle"
                                                                                style="color: red"
                                                                                title="Data ketebalan perlulah kurang daripada 12 mm"></i>
                                                                        @enderror
                                                                    </td>
                                                                    <td style="text-align:center;padding:
                                                                            5px">
                                                                        <input type="text" size="20"
                                                                            class="text-right"
                                                                            wire:model='produk_isipadumr_a.0'
                                                                            wire:change="CalcJumlah_kecil_1_mr"
                                                                            style="@error('produk_isipadumr_a.0') color:red @else color:black @endif;"
                                                                            oninput="validate(this)"
                                                                            onkeypress="return isNumberKey(event)">
                                                                    </td>
                                                                    <td style="text-align:center;padding: 5px">
                                                                        <input type="text" size="20" class="text-right"
                                                                            wire:model='produk_isipaduwbp_a.0'
                                                                            wire:change="CalcJumlah_kecil_1_wbp"
                                                                            style="@error('produk_isipaduwbp_a.0') color:red @else color:black @endif"
                                                                            oninput="validate(this)"
                                                                            onkeypress="return isNumberKey(event)">
                                                                    </td>

                                                                </tr>

                                                                {{-- <tr style="height:50px;">
                                                                                    <td style="text-align:center;padding: 10px" ><input style="" type="text" size="70" ></td>
                                                                                    <td style="text-align:center;padding: 5px" ><input style="" type="text" size="20" onkeypress="return isNumberKey(event)"></td>
                                                                                    <td style="text-align:center;padding: 5px" ><input style="" type="text" size="20" onkeypress="return isNumberKey(event)"></td>
                                                                                </tr> --}}

                                                                <tr>

                                                                    @foreach ($inputs as $key => $value)
                                                                        <div class=" add-input">
                                                                <tr style="height:50px;">
                                                                    <td style="text-align:center;padding: 10px">
                                                                        <input type="text" size="70" size="70" onkeypress="return isNumberKey(event)"
                                                                            style="@error('produk_ketebalan_a.0') color:red;outline: 2px solid red; @else color:black @endif"
                                                                            wire:model="produk_ketebalan_a.{{ $value }}">
                                                                        @error('produk_ketebalan_a.' . $value)
                                                                            <i class="fas fa-exclamation-circle"
                                                                                style="color: red"
                                                                                title="Data ketebalan perlulah kurang daripada 12 mm"></i>
                                                                        @enderror
                                                                    </td>
                                                                    <td style="text-align:center;padding:
                                                                            5px">
                                                                        <input type="text" size="20"
                                                                            onkeypress="return isNumberKey(event)"
                                                                            wire:model='produk_isipadumr_a.{{ $value }}'
                                                                            wire:change="CalcJumlah_kecil_1_mr"
                                                                            style="@error('produk_isipadumr_a.' . $value) color:red @else color:black @endif">
                                                                    </td>
                                                                    <td
                                                                        style="text-align:center;padding: 5px;padding-left: 35px">
                                                                        <input type="text" size="20" onkeypress="return isNumberKey(event)"
                                                                            wire:model='produk_isipaduwbp_a.{{ $value }}'
                                                                            wire:change="CalcJumlah_kecil_1_wbp"
                                                                            style="@error('produk_isipaduwbp_a.' . $value) color:red @else color:black @endif">
                                                                        @if ($loop->last)
                                                                            <button class="btn btn-danger btn-sm"
                                                                                wire:click.prevent="removeNipis({{ $key }}, {{ $value }})">
                                                                                <i
                                                                                    class="fas fa-times-circle"></i></button>
                                                                    </td>

                                                                    @endif
                                                                </tr>

                                                        </div>
                                                        @endforeach

                                                        </tr>

                                                        <tr style="height:50px;">
                                                            <td colspan="3">
                                                                <div class="col-md-2">
                                                                    <button class="btn btn-primary "
                                                                        wire:click.prevent="addNipis({{ $i }})">Tambah</button>
                                                                </div>
                                                            </td>
                                                        </tr>


                                                        <tr style="height:50px;">
                                                            <th style="text-align:right;background-color: #7ee48c6b;"
                                                                class="">JUMLAH KECIL</th>
                                                            <td style="text-align:center;padding: 5px">
                                                                <input readonly style="background-color: #7ee48c6b;" class="text-right"
                                                                    type="text" size="20"
                                                                    wire:model='jumlah_kecil_1_mr'>
                                                            </td>
                                                            <td style="text-align:center;padding: 5px">
                                                                <input readonly style="background-color: #7ee48c6b;" class="text-right"
                                                                    type="text" size="20"
                                                                    wire:model='jumlah_kecil_1_wbp'>
                                                            </td>
                                                        </tr>


                                                        <tr style="height:50px;">
                                                            <th style="" class="col-md-12">"Tebal"
                                                                (Ketebalan 12mm dan lebih)</th>
                                                            <td style="text-align:center;"></td>
                                                            <td style="text-align:center;"></td>
                                                        </tr>

                                                        <tr style="height:50px;">
                                                            <td style="text-align:center;padding: 10px">
                                                                <input type="text" size="70" onkeypress="return isNumberKey(event)"
                                                                    style="@error('produk_ketebalan_b.0') color:red;outline: 2px solid red; @else color:black @endif"
                                                                    wire:model="produk_ketebalan_b.0">
                                                                @error('produk_ketebalan_b.0')
                                                                    <i class="fas fa-exclamation-circle" style="color: red"
                                                                        title="Data ketebalan perlulah melebihi daripada 12 mm"></i>
                                                                @enderror
                                                            </td>
                                                            <td style="text-align:center;padding:
                                                                            5px">
                                                                        <input type="text" size="20"
                                                                            class="text-right"
                                                                            wire:model='produk_isipadumr_b.0'
                                                                            wire:change="CalcJumlah_kecil_2_mr"
                                                                            style="@error('produk_isipadumr_b.0') color:red @else color:black @endif"
                                                                    oninput="validate(this)"
                                                                    onkeypress="return isNumberKey(event)">
                                                            </td>
                                                            <td style="text-align:center;padding: 5px">
                                                                <input type="text" size="20" class="text-right"
                                                                    wire:model='produk_isipaduwbp_b.0'
                                                                    wire:change="CalcJumlah_kecil_2_wbp"
                                                                    style="@error('produk_isipaduwbp_b.0') color:red @else color:black @endif"
                                                                    oninput="validate(this)"
                                                                    onkeypress="return isNumberKey(event)">
                                                            </td>
                                                        </tr>

                                                        {{-- <tr style="height:50px;">
                                                                                    <td style="text-align:center;padding: 10px" ><input style="" type="text" size="70" ></td>
                                                                                    <td style="text-align:center;padding: 5px" ><input style="" type="text" size="20" onkeypress="return isNumberKey(event)"></td>
                                                                                    <td style="text-align:center;padding: 5px" ><input style="" type="text" size="20" onkeypress="return isNumberKey(event)"></td>
                                                                                </tr> --}}

                                                        @foreach ($inputs2 as $key => $value)
                                                            <div class=" add-input">
                                                                <tr style="height:50px;">
                                                                    <td style="text-align:center;padding: 10px">
                                                                        <input type="text" size="70"
                                                                            style="@error('produk_ketebalan_b.' . $value) color:red;outline: 2px solid red; @else color:black @endif"
                                                                            wire:model="produk_ketebalan_b.{{ $value }}">
                                                                        @error('produk_ketebalan_b.' . $value)
                                                                            <i class="fas fa-exclamation-circle"
                                                                                style="color: red"
                                                                                title="Data ketebalan perlulah melebihi daripada 12 mm"></i>
                                                                        @enderror
                                                                    </td>
                                                                    <td style="text-align:center;padding:
                                                                            5px">
                                                                        <input type="text" size="20"
                                                                            wire:model='produk_isipadumr_b.{{ $value }}'
                                                                            wire:change="CalcJumlah_kecil_2_mr"
                                                                            style="@error('produk_isipadumr_b.' . $value) color:red @else color:black @endif">
                                                                    </td>
                                                                    <td
                                                                        style="text-align:center;padding: 5px;padding-left: 35px">
                                                                        <input type="text" size="20"
                                                                            wire:model='produk_isipaduwbp_b.{{ $value }}'
                                                                            wire:change="CalcJumlah_kecil_2_wbp"
                                                                            style="@error('produk_isipaduwbp_b.' . $value) color:red @else color:black @endif">
                                                                        @if ($loop->last)
                                                                            <button class="btn btn-danger btn-sm"
                                                                                wire:click.prevent="removeTebal({{ $key }},{{ $value }})">
                                                                                <i
                                                                                    class="fas fa-times-circle"></i></button>
                                                                    </td>
                                                        @endif
                                                        </tr>

                                                    </div>
                                                    @endforeach

                                                    </tr>

                                                    <tr style="height:50px;">
                                                        <td colspan="3">
                                                            <div class="col-md-2">
                                                                <button class="btn btn-primary"
                                                                    wire:click.prevent="addTebal({{ $j }})">Tambah</button>
                                                            </div>
                                                        </td>
                                                    </tr>

                                                    <tr style="height:50px;">
                                                        <th style="text-align:right;background-color: #7ee48c6b;"
                                                            class="">JUMLAH KECIL</th>
                                                        <td style="text-align:center;padding: 5px">
                                                            <input readonly style="background-color: #7ee48c6b;" class="text-right"
                                                                type="text" size="20" wire:model='jumlah_kecil_2_mr'>
                                                        </td>
                                                        <td style="text-align:center;padding: 5px">
                                                            <input readonly style="background-color: #7ee48c6b;" class="text-right"
                                                                type="text" size="20" wire:model='jumlah_kecil_2_wbp'>
                                                        </td>
                                                    </tr>

                                                    <tr style="height:50px;">
                                                        <th style="text-align:right;background-color: #7ee48c6b;"
                                                            class="">JUMLAH </th>
                                                        <td style="text-align:center;padding: 5px">
                                                            <input readonly style="background-color: #7ee48c6b;" class="text-right"
                                                                type="text" size="20" wire:model='jumlah_besar_mr'>
                                                        </td>
                                                        <td style="text-align:center;padding: 5px">
                                                            <input readonly style="background-color: #7ee48c6b;" class="text-right"
                                                                type="text" size="20" wire:model='jumlah_besar_wbp'>
                                                        </td>
                                                    </tr>

                                                    <tr style="height:50px;">
                                                        <th style="background-color: #7ee48c6b;" class="">
                                                            B. VENIR</th>
                                                        <th style="text-align:center;background-color: #7ee48c6b;"
                                                            colspan="2" class="">
                                                            (m³) </th>
                                                    </tr>

                                                    <tr style="height:50px;">
                                                        <td style="" class="">Muka (Face)
                                                            </th>
                                                        <td style="text-align:center;padding: 5px" colspan="2"><input
                                                                style=" type=" text" size="50" class="text-right"
                                                                oninput="validate(this)"
                                                                onkeypress="return isNumberKey(event)"
                                                                wire:model='rekod_veniermuka'
                                                                wire:change="CalcJumlah_Venier"></td>
                                                    </tr>

                                                    <tr style="height:50px;">
                                                        <td style="" class="">Teras (Core)
                                                            </th>
                                                        <td style="text-align:center;padding: 5px" colspan="2"><input
                                                                style=" type=" text" size="50" class="text-right"
                                                                oninput="validate(this)"
                                                                onkeypress="return isNumberKey(event)"
                                                                wire:model='rekod_venierteras'
                                                                wire:change="CalcJumlah_Venier"></td>
                                                    </tr>

                                                    <tr style="height:50px;">
                                                        <th style="text-align:right;background-color: #7ee48c6b;"
                                                            class="">JUMLAH </th>
                                                        <td style="text-align:center;padding: 5px" colspan="2"><input
                                                                readonly style="background-color: #7ee48c6b;" class="text-right"
                                                                type="text" size="50" wire:model='jumlah_pengeluaran'>
                                                        </td>

                                                    </tr>
                                                    <tr style="height:50px;">
                                                        <th style="text-align:right;background-color: #7ee48c6b;" class="">JUMLAH BESAR</th>
                                                        <td style="text-align:center;padding: 5px" colspan="2"><input
                                                            readonly style="background-color: #7ee48c6b;" class="text-right"
                                                            type="text" size="50" wire:model='jumlah_besar_pengeluaran' >

                                                            @if ($formc->status != 'Tiada Pengeluaran')
                                                                @if ($jumlah_besar_pengeluaran > $max_recovery_rate)
                                                                    <i class="fas fa-exclamation-circle" style="color: red" title="Pengeluaran Kayu Gergaji Daripada Jentera Memproses Papan Lapis / Venir &#013;mestilah tidak melebihi {{ $max_recovery_rate }} ataupun mestilah sekurang-kurangnya {{ $min_recovery_rate }} &#013; "></i>
                                                                @elseif($jumlah_besar_pengeluaran < $min_recovery_rate)
                                                                    <i class="fas fa-exclamation-circle" style="color: red" title="Pengeluaran Kayu Gergaji Daripada Jentera Memproses Papan Lapis / Venir &#013;mestilah tidak melebihi {{ $max_recovery_rate }} ataupun mestilah sekurang-kurangnya {{ $min_recovery_rate }} &#013;"></i>
                                                                @endif
                                                            @endif
                                                    </td>
                                                    </tr>
                                    </table>
                                    <br>

                                </div>
                            </div>
                        </div>

                        <hr>
                        <div class="card-body">
                                                                        @if ($errors->any())
                                                                            @foreach ($errors as $error)
                                                                                <div
                                                                                    class="text-center form-group m-b-0">
                                                                                    <h4 style="color:red">
                                                                                        {{ $error }}
                                                                                    </h4>
                                                                                </div>
                                                                            @endforeach
                                                                            {{-- <div class="text-center form-group m-b-0">
                                    <h4 style="color:red">Sila Betulkan Maklumat Yang Berwarna Merah
                                    </h4>
                                </div> --}}
                                                                        @endif
                                                                        <div class="text-right form-group m-b-0">
                                                                            <a href="{{ route('user.shuttle-4-senaraiD', date('Y')) }}"
                                                                                class="btn btn-primary">Kembali</a>

                                                                            @if ($formc->tiada_pengeluaran == 1)
                                                                                <button type="button"
                                                                                    wire:loading.attr="disabled"
                                                                                    class="btn btn-primary"
                                                                                    alt="default" data-toggle="modal"
                                                                                    data-target="#tiada_pengeluaran"
                                                                                    class="model_img img-fluid">
                                                                                    Tiada Pengeluaran</button>
                                                                            @endif

                                                                            @if ($formc->tiada_pengeluaran == 0)
                                                                                <button type="button"
                                                                                    class="btn btn-primary"
                                                                                    alt="default" data-toggle="modal"
                                                                                    data-target="#confirmation_borang_b"
                                                                                    class="model_img img-fluid">
                                                                                    HANTAR</button>
                                                                            @endif
                                                                        </div>
                                                        </div>





                                                        <div class="modal
                                                                            fade" id="tiada_pengeluaran"
                                                                            tabindex="-1" role="dialog"
                                                                            aria-labelledby="tiada_pengeluaranTitle"
                                                                            aria-hidden="true">
                                                                        <div class="modal-dialog modal-dialog-centered"
                                                                            role="document">
                                                                            <div class="modal-content">
                                                                                <div class="modal-header"
                                                                                    style="background-color:#f3ce8f  !important">
                                                                                    <h5 class="modal-title "
                                                                                        id="exampleModalLongTitle"><i
                                                                                            style="color:rgb(255, 255, 0)"
                                                                                            class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                                                    </h5>
                                                                                    <button type="button"
                                                                                        class="close"
                                                                                        data-dismiss="modal"
                                                                                        aria-label="Close">
                                                                                        <span
                                                                                            aria-hidden="true">&times;</span>
                                                                                    </button>
                                                                                </div>
                                                                                <div class="modal-body">

                                                                                    <span class="text-center"><b>Adakah
                                                                                            anda pasti
                                                                                            kilang anda tiada
                                                                                            pengeluaran?</b></span>

                                                                                </div>
                                                                                <div class="modal-footer">
                                                                                    <button type="button"
                                                                                        class="btn btn-danger"
                                                                                        wire:loading.attr="disabled"
                                                                                        data-dismiss="modal">TIDAK</button>
                                                                                    <button type="button"
                                                                                        wire:click="tiadaPengeluaran"
                                                                                        wire:loading.attr="disabled"
                                                                                        class="btn btn-success">
                                                                                        <div wire:loading
                                                                                            wire:target="store">
                                                                                            <div
                                                                                                class="la-ball-pulse-sync la-sm">
                                                                                                <div></div>
                                                                                                <div></div>
                                                                                                <div></div>
                                                                                            </div>
                                                                                        </div>
                                                                                        <div wire:loading.remove
                                                                                            wire:target="store">YA
                                                                                        </div>
                                                                                    </button>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                        </div>

                                                        <div class="modal fade" id="confirmation_borang_b"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="confirmation_borang_bTitle"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-info"
                                                                        style="background-color: #f3ce8f !important;">
                                                                        <h5 class="modal-title "
                                                                            id="exampleModalLongTitle"><i
                                                                                style="color:rgb(255, 255, 0)"
                                                                                class="fas fa-exclamation-triangle"></i>&nbspPENGESAHAN
                                                                        </h5>
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <span class="text-center"><b>Adakah anda pasti
                                                                                ingin menghantar borang ini?</b></span>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" id="submit-button"
                                                                            class="btn btn-danger"
                                                                            wire:loading.attr="disabled"
                                                                            data-dismiss="modal">KEMBALI</button>
                                                                        <button type="submit"
                                                                            wire:loading.attr="disabled"
                                                                            class="btn btn-success">
                                                                            <div wire:loading wire:target="store">
                                                                                <div class="la-ball-pulse-sync la-sm">
                                                                                    <div></div>
                                                                                    <div></div>
                                                                                    <div></div>
                                                                                </div>
                                                                            </div>
                                                                            <div wire:loading.remove
                                                                                wire:target="store">HANTAR</div>
                                                                        </button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>





                                        </form>
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
                window.livewire.on('alert', param => {
                    toastr[param['type']](param['message'], 'Ralat', {
                        "progressBar": true
                    })
                    // toastr.error(param['message'], 'Ralat', { "progressBar": true });
                });
            </script>

            <script>
                $('#formd').submit(function(e) {
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
