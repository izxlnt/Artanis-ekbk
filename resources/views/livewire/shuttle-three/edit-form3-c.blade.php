<div wire:init='loadData'>
    <div>
        <div>

            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-12">
                        <div class="rounded-lg card" style="border-color: #000000 !important;">
                            <div class="card-header"
                                style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                                BORANG 3C - PENYATA KEMASUKAN & PEMPROSESAN KAYU BALAK <br> DAN PENGELUARAN KAYU GERGAJI
                                MENGIKUT KUMPULAN KAYU-KAYAN
                            </div>
                            <div class="card-body">


                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">
                                        <br>
                                        <div class="">
                                            <table class="table table-striped table-bordered" id="" style="width: 100%;">
                                                <form class="form-horizontal" wire:submit.prevent='update'>
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="card">
                                                                <div class="card-body">

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Tahun:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #e0ec3754;"
                                                                                value="{{ $formc_id->tahun }}"
                                                                                readonly />
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label>Bulan:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #e0ec3754;"
                                                                                value="{{ $formc_id->bulan }}"
                                                                                readonly />
                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Nama Kilang:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #e0ec3754;"
                                                                                value="{{ $formc_id->nama_kilang }}"
                                                                                readonly />

                                                                        </div>
                                                                        <div class="col-md-6">

                                                                            <label>No. Pendaftaran Syarikat (SSM):
                                                                            </label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #e0ec3754;"
                                                                                value="{{ $formc_id->no_ssm }}"
                                                                                readonly />

                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-3"></div>
                                                                        <div class="col-md-6">
                                                                            <label>No. Lesen:</label>
                                                                            <input type="text" class="form-control"
                                                                                style="background-color: #e0ec3754;"
                                                                                value="{{ $formc_id->no_lesen }}"
                                                                                readonly />


                                                                        </div>
                                                                    </div>

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
                                                                                                {{ $data1->kod }}</td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2"><input
                                                                                                    style="background-color: #e0ec3754;"
                                                                                                    type="text"
                                                                                                    size="10"
                                                                                                    id="fc_baki_{{ $keySpecies }}" wire:model.defer='baki_stok.{{ $keySpecies }}'

                                                                                                    onkeypress="return isNumberKey(event)">
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2"><input
                                                                                                    type="text"
                                                                                                    size="10"
                                                                                                    id="fc_masuk_{{ $keySpecies }}" wire:model.defer='kayu_masuk.{{ $keySpecies }}' oninput="validate(this);fcCalcRow({{ $keySpecies }})"
                                                                                                    onkeypress="return isNumberKey(event)">
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2"><input
                                                                                                    readonly
                                                                                                    style="background-color: #e0ec3754; text-align:right"
                                                                                                    type="text"
                                                                                                    size="10"
                                                                                                    id="fc_jumlah_{{ $keySpecies }}">
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2">
                                                                                                <input type="text"
                                                                                                    size="10"
                                                                                                    id="fc_pmasuk_{{ $keySpecies }}" wire:model.defer='proses_masuk.{{ $keySpecies }}' oninput="validate(this);fcCalcRow({{ $keySpecies }})"
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
                                                                                                    size="10"
                                                                                                    id="fc_pkeluar_{{ $keySpecies }}" wire:model.defer='proses_keluar.{{ $keySpecies }}' oninput="validate(this);fcCalcRow({{ $keySpecies }})"
                                                                                                    onkeypress="return isNumberKey(event)"
                                                                                                    style="@error('proses_keluar.' . $keySpecies) color:red; outline: 2px solid red @else color:black @endif">
                                                                                                @error('proses_keluar.'
                                                                                                    . $keySpecies)
                                                                                                    <i class="fas fa-exclamation-circle"
                                                                                                        style="color: red"
                                                                                                        title="Pengeluaran Kayu Gergaji Daripada Jentera Memproses (06) &#013;mestilah tidak melebihi &#013;Kemasukan Kayu Balak Ke Dalam Jentera Memproses (05)"></i>
                                                                                                @enderror
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2"><input
                                                                                                    readonly
                                                                                                    style="background-color: #e0ec3754; text-align:right"
                                                                                                    type="text"
                                                                                                    size="10"
                                                                                                    id="fc_kehadapan_{{ $keySpecies }}">
                                                                                            </td>
                                                                                        </tr>
                                                                                    @endif

                                                                                @endforeach

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:center;"
                                                                                        colspan="2"> Jumlah</th>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754;"
                                                                                            type="text" size="10"
                                                                                            id="fc_tot_baki_{{ $keyKumpulanKayu }}">
                                                                                    </td>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754;"
                                                                                            type="text" size="10"
                                                                                            id="fc_tot_masuk_{{ $keyKumpulanKayu }}">
                                                                                    </td>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754;"
                                                                                            type="text" size="10"
                                                                                            id="fc_tot_jumlah_{{ $keyKumpulanKayu }}">
                                                                                    </td>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754;"
                                                                                            type="text" size="10"
                                                                                            id="fc_tot_pmasuk_{{ $keyKumpulanKayu }}">
                                                                                    </td>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754;"
                                                                                            type="text" size="10"
                                                                                            id="fc_tot_pkeluar_{{ $keyKumpulanKayu }}">
                                                                                    </td>
                                                                                    <td style="text-align:center;"
                                                                                        colspan="2"><input readonly
                                                                                            style="background-color: #e0ec3754;"
                                                                                            type="text" size="10"
                                                                                            id="fc_tot_kehadapan_{{ $keyKumpulanKayu }}">
                                                                                    </td>
                                                                                </tr>

                                                                            @endforeach

                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;"
                                                                                    colspan="2"> Jumlah Besar </th>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_jb_baki">
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_jb_masuk">
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_jb_jumlah">
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_jb_pmasuk">
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_jb_pkeluar">
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_jb_kehadapan">
                                                                                </td>
                                                                            </tr>
                                                                        </tbody>


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

                                                                {{-- <p>
                                                                <button style="width:300px;" class="btn btn-success" type="button" data-toggle="collapse" data-target="#collapseExample1" aria-expanded="false" aria-controls="collapseExample">
                                                                    Ulasan PHD
                                                                </button>
                                                            </p>
                                                            <div class="collapse" id="collapseExample1">

                                                                <div class="card card-body">
                                                                </div>

                                                            </div> --}}
                                                            </div>
                                                        </div>
                                                        <div class="card-body">
                                                            <div class="text-right form-group m-b-0">
                                                                {{-- <button type="submit" class="btn btn-primary">Tiada Pengeluaran</button> --}}

                                                                <a href="{{ url()->previous() }}"
                                                                    class="btn btn-primary">Kembali</a>

                                                                <button type="button" class="btn btn-primary"
                                                                    alt="default" data-toggle="modal"
                                                                    data-target="#confirmation_borang_a">
                                                                    HANTAR</button>
                                                            </div>
                                                        </div>

                                                        <div class="modal fade" id="confirmation_borang_a"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="confirmation_borang_aTitle"
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
                                                                        <button type="button" class="close"
                                                                            data-dismiss="modal" aria-label="Close">
                                                                            <span aria-hidden="true">&times;</span>
                                                                        </button>
                                                                    </div>
                                                                    <div class="modal-body">
                                                                        <span class="text-center"><b>Adakah anda pasti
                                                                            ingin menghantar borang ini?</span>
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

</div>

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

<script>
    var fcGroups = {
        @foreach ($kumpulan_kayu as $keyKumpulanKayu => $data)
        {{ $keyKumpulanKayu }}: [
            @foreach ($species as $keySpecies => $data1)
                @if($data1->kumpulan_kayu->singkatan == $data->singkatan)
                    {{ $keySpecies }},
                @endif
            @endforeach
        ],
        @endforeach
    };
    function fcN(id) { var el = document.getElementById(id); return el ? (parseFloat(el.value) || 0) : 0; }
    function fcS(id, v) { var el = document.getElementById(id); if (el) el.value = Math.round(v * 10000) / 10000 || 0; }
    function fcCalcRow(ks) {
        var jumlah = fcN('fc_baki_' + ks) + fcN('fc_masuk_' + ks);
        fcS('fc_jumlah_' + ks, jumlah);
        fcS('fc_kehadapan_' + ks, jumlah - fcN('fc_pmasuk_' + ks) - fcN('fc_pkeluar_' + ks));
        fcCalcAll();
    }
    function fcCalcAll() {
        var jbB=0,jbM=0,jbJ=0,jbPM=0,jbPK=0,jbK=0;
        Object.keys(fcGroups).forEach(function(kg) {
            var tb=0,tm=0,tj=0,tpm=0,tpk=0,tk=0;
            fcGroups[kg].forEach(function(ks) {
                tb+=fcN('fc_baki_'+ks); tm+=fcN('fc_masuk_'+ks);
                tj+=fcN('fc_jumlah_'+ks); tpm+=fcN('fc_pmasuk_'+ks);
                tpk+=fcN('fc_pkeluar_'+ks); tk+=fcN('fc_kehadapan_'+ks);
            });
            fcS('fc_tot_baki_'+kg,tb); fcS('fc_tot_masuk_'+kg,tm);
            fcS('fc_tot_jumlah_'+kg,tj); fcS('fc_tot_pmasuk_'+kg,tpm);
            fcS('fc_tot_pkeluar_'+kg,tpk); fcS('fc_tot_kehadapan_'+kg,tk);
            jbB+=tb; jbM+=tm; jbJ+=tj; jbPM+=tpm; jbPK+=tpk; jbK+=tk;
        });
        fcS('fc_jb_baki',jbB); fcS('fc_jb_masuk',jbM); fcS('fc_jb_jumlah',jbJ);
        fcS('fc_jb_pmasuk',jbPM); fcS('fc_jb_pkeluar',jbPK); fcS('fc_jb_kehadapan',jbK);
    }
</script>

<style>
    table,
    th,
    td {
        border: 1px solid black;
    }

</style>

</div>
