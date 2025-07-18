
    <div wire:init='loadData'>


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
                            style="text-align:center; background-color: #a0e4ff !important; font-size: 130%; font-weight: bold;">
                            BORANG 4E - PENYATA PENJUALAN PAPAN LAPIS/VENIR DALAM PASARAN TEMPATAN DAN EKSPORT
                        </div>
                        <div class="card-body">

                            <!-- Tab panes -->
                            <div class="tab-content">
                                <form wire:submit.prevent='update'>
                                    <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                                        <br>
                                        <div class="">
                                            <table class="table table-striped table-bordered" id=""
                                                style="width: 100%;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">

                                                            <form class="form-horizontal">
                                                                <div class="card-body">

                                                                    <div class="row"
                                                                        style="justify-content: center;margin-bottom:-2%;">
                                                                        <div class="col-md-2">
                                                                            <label><b>Tahun:</b></label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7"
                                                                                value="{{ date('Y') }}"
                                                                                readonly />
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label><b>Bulan:</b></label>
                                                                            @if($form4e_id->bulan <= '1')

                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="Januari" readonly />
                                                                            @elseif($form4e_id->bulan  <= '2')

                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="Februari" readonly />
                                                                            @elseif($form4e_id->bulan  <= '3')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="Mac" readonly />
                                                                            @elseif($form4e_id->bulan  <= '4')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="April" readonly />
                                                                            @elseif($form4e_id->bulan  <= '5')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="Mei" readonly />
                                                                            @elseif($form4e_id->bulan  <= '6')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="Jun" readonly />
                                                                            @elseif($form4e_id->bulan  <= '7')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="Julai" readonly />
                                                                            @elseif($form4e_id->bulan  <= '8')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="Ogos" readonly />
                                                                            @elseif($form4e_id->bulan  <= '9')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="September" readonly />
                                                                            @elseif($form4e_id->bulan  <= '10')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="Oktober" readonly />
                                                                            @elseif($form4e_id->bulan  <= '11')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="November" readonly />
                                                                            @elseif($form4e_id->bulan  <= '12')


                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7;"
                                                                                value="Disember" readonly />
                                                                            @endif
                                                                        </div>
                                                                        <div class="col-md-3">
                                                                            <label><b>Nama Kilang:</b></label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7 ;"
                                                                                value="{{ $kilang_info->nama_kilang }}"
                                                                                readonly />
                                                                        </div>
                                                                        {{-- <div class="col-md-2"></div> --}}
                                                                        <div class="col-md-2">
                                                                            <label><b>No. Pendaftaran Syarikat
                                                                                    (SSM):</b></label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7 ;"
                                                                                value="{{ $kilang_info->no_ssm }}"
                                                                                readonly />
                                                                        </div>
                                                                        <div class="col-md-2">
                                                                            <label><b>No. Lesen:</b></label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #9ac4f7 ;"
                                                                                value="{{ $kilang_info->no_lesen }}"
                                                                                readonly />
                                                                        </div>


                                                                    </div>
                                                                    <table>
                                                                        <tr style="height:50px;">
                                                                            <td style="width:50%" >Jumlah
                                                                                papan lapis yang dieksport (㎥)</td>

                                                                            <td style="text-align:center;width:50%;"><input
                                                                                    style="text-align:right" type="text" size="20"

                                                                                    wire:model='total_export'
                                                                                    oninput="validate(this)"
                                                                                    onkeypress="return isNumberKey(event)">
                                                                            </td>
                                                                        </tr>

                                                                        <tr style="height:50px;">
                                                                            <td>Jumlah
                                                                                papan lapis yang dijual dalam pasaran
                                                                                tempatan (㎥)</td>
                                                                            <td style="text-align:center;"><input
                                                                                    readonly
                                                                                    style="background-color: #9ac4f7;text-align:right"
                                                                                    type="text" size="20"
                                                                                    wire:model='jumlah_pasaran_tempatan'
                                                                                    oninput="validate(this)"
                                                                                    onkeypress="return isNumberKey(event)">
                                                                            </td>
                                                                        </tr>

                                                                        <tr style="height:50px;">
                                                                            <td style="" >Jumlah
                                                                                venir yang dieksport (㎥)</td>
                                                                            <td style="text-align:center;"><input
                                                                                    style="text-align:right" type="text" size="20"
                                                                                    wire:model='jumlah_venier_eksport'
                                                                                    oninput="validate(this)"
                                                                                    onkeypress="return isNumberKey(event)">
                                                                            </td>
                                                                        </tr>

                                                                        <tr style="height:50px;">
                                                                            <td style="">Jumlah
                                                                                venir yang dijual dalam pasaran
                                                                                tempatan (㎥)</td>
                                                                            <td style="text-align:center;"><input
                                                                                    style="text-align:right" type="text" size="20"
                                                                                    wire:model='jumlah_venier_tempatan'
                                                                                    oninput="validate(this)"
                                                                                    onkeypress="return isNumberKey(event)">
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
                                                                                class="col-md-12">Isipadu (㎥)</th>
                                                                        </tr>

                                                                        @foreach ($jenis_pembeli as $key => $data)
                                                                            <tr style="height:50px;">
                                                                                <td>
                                                                                    {{ $data->keterangan }}

                                                                                    @if ($data->keterangan == 'Lain-lain (Nyatakan)')
                                                                                        <br>
                                                                                        <input type="text"
                                                                                            style="margin:10px"
                                                                                            size="100"
                                                                                            wire:model='catatan.{{ $key }}'>

                                                                                    @endif

                                                                                </td>
                                                                                <td style="text-align:center;"><input
                                                                                        style="text-align:right" type="text" size="20"
                                                                                        wire:model='jumlah_jualan.{{ $key }}'
                                                                                        wire:change='calcTotalJumlahJualan()'
                                                                                        oninput="validate(this)"
                                                                                        onkeypress="return isNumberKey(event)">
                                                                                </td>
                                                                            </tr>


                                                                        @endforeach


                                                                        <tr style="height:50px;">
                                                                            <th style="background-color: #9ac4f7;"
                                                                                class="col-md-12">Jumlah</th>
                                                                            <td style="text-align:center;"><input
                                                                                    readonly
                                                                                    style="background-color: #9ac4f7;text-align:right"
                                                                                    type="text" size="20"
                                                                                    wire:model='total_jumlah_jualan'
                                                                                    onkeypress="return isNumberKey(event)">
                                                                            </td>
                                                                        </tr>
                                                                    </table>
                                                                    <br>

                                                                </div>
                                                        </div>
                                                    </div>

                                                    <hr>

                                                    <div class="row" style="text-align:center">
                                                        <div class="col-md-12">
                                                            <label>Ulasan PHD</label><br>

                                                            @if ($ulasan->ulasan == null)

                                                                <textarea name="ulasan_phd" cols="100%" rows="5"
                                                                    readonly disabled>Tiada Ulasan</textarea>
                                                            @else
                                                                <textarea name="ulasan_phd" cols="100%" rows="5"
                                                                    readonly
                                                                    disabled>{{ $ulasan->ulasan }}</textarea>

                                                            @endif


                                                        </div>
                                                    </div>
                                                    <div class="card-body">
                                                        <div class="text-right form-group m-b-0">
                                                            {{-- <button type="submit" class="btn btn-primary">Tiada Pengeluaran</button> --}}
                                                            <a href="{{ route('user.shuttle-4-senaraiE', date('Y')) }}"
                                                                class="btn btn-primary">Kembali</a>

                                                            <button type="button"
                                                                class="btn btn-primary" alt="default"
                                                                data-toggle="modal" data-target="#confirmation_borang_a">Simpan</button>
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
                                                                            <span class="text-center"><b>Adakah anda pasti ingin menghantar borang ini?</b></span>
                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button" class="btn btn-danger"
                                                                                data-dismiss="modal">Batal</button>
                                                                            <button type="submit"
                                                                                class="btn btn-success">HANTAR</button>
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
    var validate = function(e) {
    var t = e.value;
    e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
    }
</script>

<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

</style>
