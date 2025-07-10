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
                                        <br>
                                        <div class="" >
                                            <table class="table table-striped table-bordered" id=""
                                                style="width: 100%;">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="card">

                                                        <form class="form-horizontal" wire:submit.prevent ='store'>
                                                                <div class="card-body">

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Tahun:</label>
                                                                            <input type="text" class="form-control" style="background-color: #e0ec3754;" value="{{ $kilang_info->tahun }}" readonly />
                                                                        </div>
                                                                        <div class="col-md-6">
                                                                            <label>Bulan:</label>
                                                                            <input type="text" class="form-control" style="background-color: #e0ec3754;" value="{{ $kilang_info->bulan }}" readonly />
                                                                        </div>
                                                                    </div>
                                                                    <br>

                                                                    <div class="row">
                                                                        <div class="col-md-6">
                                                                            <label>Nama Kilang:</label>
                                                                            <input type="text" class="form-control" style="background-color: #e0ec3754;" value="{{ $kilang_info->nama_kilang }}" readonly />

                                                                        </div>
                                                                        <div class="col-md-6">

                                                                            <label>No. Pendaftaran Syarikat (SSM): </label>
                                                                            <input type="text" class="form-control" style="background-color: #e0ec3754;" value="{{ $kilang_info->no_ssm }}" readonly />

                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-md-3"></div>
                                                                        <div class="col-md-6">
                                                                            <label>No. Lesen:</label>
                                                                            <input type="text" class="form-control" style="background-color: #e0ec3754;" value="{{ $kilang_info->no_lesen }}" readonly />


                                                                        </div>
                                                                    </div>

                                                                    <table>
                                                                        <tr style="height:50px;">
                                                                            <th style="text-align:center;" colspan="2">Kumpulan Kayu Kayan</th>
                                                                            <th style="text-align:center;" colspan="2">Baki Stok Dari Bulan Lepas</th>
                                                                            <th style="text-align:center;" colspan="2">Kemasukan Kayu Balak Ke Dalam Kawasan Kilang</th>
                                                                            <th style="text-align:center;" colspan="2">Jumlah Stok Kayu Balak</th>
                                                                            <th style="text-align:center;" colspan="2">Kemasukan Kayu Balak Ke Dalam Jentera Memproses</th>
                                                                            <th style="text-align:center;" colspan="2">Pengeluaran Kayu Gergaji Daripada Jentera Memproses</th>
                                                                            <th style="text-align:center;" colspan="2">Baki Stok Kayu Balak Dibawa Ke Bulan Hadapan</th>

                                                                        </tr>

                                                                        <tr style="height:50px;">
                                                                            <th style="text-align:center;" colspan="2">(01)</th>
                                                                            <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(02)</th>
                                                                            <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(03)</th>
                                                                            <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(04)=(02)+(03)</th>
                                                                            <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(05)</th>
                                                                            <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(06)</th>
                                                                            <th style="text-align:center;" colspan="2">(&#x33A5;)<br>(07)=(04)-(05)</th>
                                                                        </tr>

                                                                        @foreach ($kumpulan_kayu as $keyKumpulanKayu=>$data)
                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;">{{ $data->singkatan }} </th>
                                                                                <th style="text-align:center;width:100px;">Kod</th>
                                                                                <th colspan="2"></th>
                                                                                <th colspan="2"></th>
                                                                                <th colspan="2"></th>
                                                                                <th colspan="2"></th>
                                                                                <th colspan="2"></th>
                                                                                <th colspan="2"></th>
                                                                            </tr>

                                                                            @foreach ($species as $keySpecies=>$data1)

                                                                                @if($data1->kumpulan_kayu->singkatan == $data->singkatan)
                                                                                    <tr style="height:50px;">
                                                                                        <td style="text-align:center;">{{ $data1->nama_tempatan }}</td>
                                                                                        <td style="text-align:center;">{{ $data1->kod }}</td>
                                                                                        <td style="text-align:center;" colspan="2"><input type="text" size="10" wire:model='baki_stok.{{ $keySpecies }}' wire:change="calcJumlahBakiStok({{ $keySpecies}}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');" onkeypress="return isNumberKey(event)"></td>
                                                                                        <td style="text-align:center;" colspan="2"><input type="text" size="10" wire:model='kayu_masuk.{{ $keySpecies }}' wire:change="calcJumlahKayuMasuk({{ $keySpecies}}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');" onkeypress="return isNumberKey(event)"></td>
                                                                                        <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='jumlah_stok_kayu_balak.{{ $keySpecies }}' wire:change="calcTotalStokKayuDibawaBulanHadapan({{ $keySpecies}}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');"></td>
                                                                                        <td style="text-align:center;" colspan="2"><input type="text" size="10" wire:model='proses_masuk.{{ $keySpecies }}' wire:change="calcBakiStok({{ $keySpecies}}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');" onkeypress="return isNumberKey(event)"></td>
                                                                                        <td style="text-align:center;" colspan="2"><input type="text" size="10" wire:model='proses_keluar.{{ $keySpecies }}' wire:change="calcTotalPengeluaranKayuDaripadaJentera({{ $keySpecies}}, {{ $keyKumpulanKayu }}, '{{ $data->singkatan }}');" onkeypress="return isNumberKey(event)"></td>
                                                                                        <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='baki_stok_kehadapan.{{ $keySpecies }}' ></td>
                                                                                    </tr>
                                                                                @endif

                                                                            @endforeach

                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;" colspan="2"> Jumlah</th>
                                                                                <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='jumlah_baki_stok.{{ $keyKumpulanKayu }}'></td>
                                                                                <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='jumlah_kayu_masuk.{{ $keyKumpulanKayu }}'></td>
                                                                                <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='total_stok_kayu_balak.{{ $keyKumpulanKayu }}' ></td>
                                                                                <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='total_kayu_masuk_jentera.{{ $keyKumpulanKayu }}'></td>
                                                                                <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='total_kayu_keluar_jentera.{{ $keyKumpulanKayu }}'></td>
                                                                                <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='total_kayu_dibawa_bulan_hadapan.{{ $keyKumpulanKayu }}'></td>
                                                                            </tr>

                                                                        @endforeach

                                                                        <tr style="height:50px;">
                                                                            <th style="text-align:center;" colspan="2"> Jumlah BESAR </th>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='jumlah_besar_baki_stok_bulan_lepas' ></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='jumlah_besar_kemasukan_kayu_ke_kilang'></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='jumlah_besar_stok_kayu_balak'></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='jumlah_besar_kayu_ke_dalam_jentera'></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='jumlah_besar_pengeluaran_kayu_daripada_jentera'></td>
                                                                            <td style="text-align:center;" colspan="2"><input readonly style="background-color: #e0ec3754;" type="text" size="10" wire:model='jumlah_besar_baki_stok_bulan_depan'></td>
                                                                        </tr>

                                                                    </table>
                                                                    <br>
                                                                </div>
                                                                    </div>
                                                                </div>

                                                                <hr>
                                                                <div class="card-body">
                                                                    <div class="text-right form-group m-b-0">
                                                                        <button type="button" class="btn btn-primary">Tiada Pengeluaran</button>
                                                                        <button type="button" class="btn btn-primary">Kembali</button>
                                                                        <button type="submit" class="btn btn-primary">Simpan</button>
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

</div>
