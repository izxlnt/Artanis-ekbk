<div>
    <div>
        <div>

            <div class="container-fluid">

                <div class="row">

                    <div class="col-md-12">
                        <div class="rounded-lg card" style="border-color: #000000 !important;">
                            <div class="card-header"
                                style="text-align:center; background-color: #f0e10dbd !important; font-size: 130%; font-weight: bold;">
                                BORANG 5C - PENYATA KEMASUKAN & PEMPROSESAN KAYU GERGAJI <br> DAN PENGELUARAN KAYU KUMAI MENGIKUT KUMPULAN KAYU-KAYAN
                            </div>
                            <div class="card-body">


                                <!-- Tab panes -->
                                <div class="tab-content">
                                    <div class="tab-pane active" id="hotel" role="tabpanel" aria-labelledby="hotel-tab">


                                        <table class="table table-striped table-bordered ex3" id="">
                                            <div class="row">
                                                <div class="col-12">
                                                    <div class="card">

                                                        <form class="form-horizontal" wire:submit.prevent='store'
                                                            style="">
                                                            <div class="card-body">

                                                                @php
                                                                    $bulanNames = ['Januari','Februari','Mac','April','Mei','Jun','Julai','Ogos','September','Oktober','November','Disember'];
                                                                    $bulanNama = $bulanNames[($month - 1)] ?? $month;
                                                                @endphp

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Tahun:</label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #e0ec3754;"
                                                                            value="{{ $year }}"
                                                                            readonly />
                                                                    </div>
                                                                    <div class="col-md-6">
                                                                        <label>Bulan:</label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #e0ec3754;"
                                                                            value="{{ $bulanNama }}" readonly />
                                                                    </div>
                                                                </div>
                                                                <br>

                                                                <div class="row">
                                                                    <div class="col-md-6">
                                                                        <label>Nama Kilang:</label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #e0ec3754;"
                                                                            value="{{ $kilang_info->nama_kilang }}"
                                                                            readonly />

                                                                    </div>
                                                                    <div class="col-md-6">

                                                                        <label>No. Pendaftaran Syarikat (SSM): </label>
                                                                        <input type="text" class="form-control"
                                                                            style="background-color: #e0ec3754;"
                                                                            value="{{ $kilang_info->no_ssm }}"
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
                                                                            value="{{ $kilang_info->no_lesen }}"
                                                                            readonly />


                                                                    </div>
                                                                </div>

                                                                <br>
                                                                <div class="row">
                                                                    <div class="col-md-4">

                                                                            <div class="legend" style="border:2px solid;">
                                                                                    &nbsp Kadar pertukaran kayu bulat : 1 ton =
                                                                                    1.8027 m³

                                                                                    <br>
                                                                                    &nbsp Kadar pertukaran kayu sudah proses : 1 ton =
                                                                                    1.416 m³

                                                                                <br>
                                                                                <br>
                                                                                &nbsp <b style="color:red">Sila tekan butang CTRL+F untuk mencari jenis spesis kayu kayan</b>

                                                                            </div>
                                                                    </div>
                                                                </div>
                                                                <div class="row">
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
                                                                                                    id="fc_baki_{{ $keySpecies }}"
                                                                                                    wire:model.defer='baki_stok.{{ $keySpecies }}'
                                                                                                    oninput="fcCalcRow({{ $keySpecies }})"
                                                                                                    onkeypress="return isNumberKey(event)">
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2"><input
                                                                                                    type="text"
                                                                                                    size="10"
                                                                                                    id="fc_masuk_{{ $keySpecies }}"
                                                                                                    wire:model.defer='kayu_masuk.{{ $keySpecies }}'
                                                                                                    oninput="fcCalcRow({{ $keySpecies }})"
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
                                                                                                    id="fc_pmasuk_{{ $keySpecies }}"
                                                                                                    wire:model.defer='proses_masuk.{{ $keySpecies }}'
                                                                                                    oninput="fcCalcRow({{ $keySpecies }})"
                                                                                                    onkeypress="return isNumberKey(event)"
                                                                                                    style="@error('proses_masuk.' . $keySpecies) color:red; outline: 2px solid red @else color:black @endif">
                                                                                                   @error('proses_masuk.' . $keySpecies)
                                                                                                        <i class="fas fa-exclamation-circle" style="color: red" title="Kemasukan Kayu Balak Ke Dalam Jentera Memproses (05) &#013;mestilah tidak melebihi ataupun sama daripada &#013;Jumlah Stok Kayu Balak (04)"></i>
                                                                                                    @enderror
                                                                                            </td>
                                                                                            <td style="text-align:center;"
                                                                                                colspan="2">
                                                                                                <input
                                                                                                    type="text"
                                                                                                    size="10"
                                                                                                    id="fc_pkeluar_{{ $keySpecies }}"
                                                                                                    wire:model.defer='proses_keluar.{{ $keySpecies }}'
                                                                                                    oninput="fcCalcRow({{ $keySpecies }})"
                                                                                                    onkeypress="return isNumberKey(event)"
                                                                                                    style="@error('proses_keluar.' . $keySpecies) color:red; outline: 2px solid red @else color:black @endif">
                                                                                                    @error('proses_keluar.' . $keySpecies)
                                                                                                        <i class="fas fa-exclamation-circle" style="color: red" title="Pengeluaran Kayu Gergaji Daripada Jentera Memproses (06) &#013;mestilah tidak melebihi &#013;Kemasukan Kayu Balak Ke Dalam Jentera Memproses (05)"></i>
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
                                                                                        id="fc_grand_baki">
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_grand_masuk">
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_grand_jumlah">
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_grand_pmasuk">
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_grand_pkeluar">
                                                                                </td>
                                                                                <td style="text-align:center;"
                                                                                    colspan="2"><input readonly
                                                                                        style="background-color: #e0ec3754;"
                                                                                        type="text" size="10"
                                                                                        id="fc_grand_kehadapan">
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

                                                    @if ($errors->any())
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
                                                    @endif

                                                    <div class="text-right form-group m-b-0">
                                                        <a href="{{ url()->previous() }}"
                                                            class="btn btn-primary">Kembali</a>
                                                        <button type="button" class="btn btn-primary"
                                                            wire:click="tiadaPengeluaran">Tiada Pengeluaran</button>
                                                        @if ($errors->isEmpty())
                                                            <button type="button" class="btn btn-primary" alt="default"
                                                                data-toggle="modal" data-target="#responsive-modal"
                                                                class="model_img img-fluid">
                                                                HANTAR</button>

                                                        @else
                                                            <button type="submit" class="btn btn-primary"
                                                                disabled>RALAT</button>
                                                        @endif

                                                    </div>
                                                </div>

                                                <div id="responsive-modal" class="modal fade" tabindex="-1"
                                                    role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"
                                                    style="display: none;">
                                                    <div class="modal-dialog modal-dialog-centered">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <button type="button" class="close"
                                                                    data-dismiss="modal" aria-hidden="true">×</button>
                                                            </div>
                                                            <div class="modal-body" style="text-align: center">
                                                                <h4><b>Adakah anda pasti untuk menghantar data ini?</h4>
                                                                <br>
                                                                @if ($total_stok_kayu_balak)
                                                                    <button type="submit"
                                                                        class="btn btn-primary waves-effect waves-light">HANTAR</button>
                                                                @else
                                                                    <button type="button" class="btn btn-primary"
                                                                        wire:click="tiadaPengeluaran">Tiada
                                                                        Pengeluaran</button>
                                                                @endif


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

                    </div>
                </div>
            </div>
        </div>

    </div>
    <!-- ============================================================== -->
    <!-- End Container fluid  -->
    <!-- ============================================================== -->
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
            fcS('fc_kehadapan_' + ks, jumlah - fcN('fc_pmasuk_' + ks));
            fcCalcAll();
        }

        function fcCalcAll() {
            var gb = 0, gm = 0, gj = 0, gpm = 0, gpk = 0, gk = 0;
            Object.keys(fcGroups).forEach(function(kg) {
                var tb = 0, tm = 0, tj = 0, tpm = 0, tpk = 0, tk = 0;
                fcGroups[kg].forEach(function(ks) {
                    tb += fcN('fc_baki_'+ks);   tm  += fcN('fc_masuk_'+ks);
                    tj += fcN('fc_jumlah_'+ks); tpm += fcN('fc_pmasuk_'+ks);
                    tpk+= fcN('fc_pkeluar_'+ks);tk  += fcN('fc_kehadapan_'+ks);
                });
                fcS('fc_tot_baki_'+kg, tb);    fcS('fc_tot_masuk_'+kg, tm);
                fcS('fc_tot_jumlah_'+kg, tj);  fcS('fc_tot_pmasuk_'+kg, tpm);
                fcS('fc_tot_pkeluar_'+kg, tpk);fcS('fc_tot_kehadapan_'+kg, tk);
                gb+=tb; gm+=tm; gj+=tj; gpm+=tpm; gpk+=tpk; gk+=tk;
            });
            fcS('fc_grand_baki',gb);    fcS('fc_grand_masuk',gm);
            fcS('fc_grand_jumlah',gj);  fcS('fc_grand_pmasuk',gpm);
            fcS('fc_grand_pkeluar',gpk);fcS('fc_grand_kehadapan',gk);
        }

        document.addEventListener('livewire:load', function() { fcCalcAll(); });
        document.addEventListener('livewire:update', function() { fcCalcAll(); });
    </script>

</div>

</div>

</div>
