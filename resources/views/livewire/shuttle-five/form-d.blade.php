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
                                    style="text-align:center; background-color: #6df173 !important; font-size: 130%; font-weight: bold;">
                                    BORANG 5D - PENYATA PENGELUARAN KAYU KUMAI MENGIKUT JENIS KAYU KUMAI
                                </div>
                                <div class="card-body">

                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <form wire:submit.prevent='store' id="formd">
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
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #7ee48c6b; border-color: #6df173"
                                                                                    value="{{ date('Y') }}"
                                                                                    readonly />
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <label><b>Bulan:</b></label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #7ee48c6b; border-color: #6df173"
                                                                                    value="{{ $bulan }}"
                                                                                    readonly />

                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <label><b>Nama Kilang:</b></label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #7ee48c6b; border-color: #6df173"
                                                                                    value="{{ $kilang_info->nama_kilang }}"
                                                                                    readonly />
                                                                            </div>
                                                                            {{-- <div class="col-md-2"></div> --}}
                                                                            <div class="col-md-2">
                                                                                <label><b>No. Pendaftaran Syarikat
                                                                                        (SSM):</b></label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #7ee48c6b; border-color: #6df173"
                                                                                    value="{{ $kilang_info->no_ssm }}"
                                                                                    readonly />
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <label><b>No. Lesen:</b></label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #7ee48c6b; border-color: #6df173"
                                                                                    value="{{ $kilang_info->no_lesen }}"
                                                                                    readonly />
                                                                            </div>

                                                                        </div>
                                                                        <div class="row"
                                                                            style="justify-content: center; margin-bottom:-2%;padding-top:50px;">
                                                                            <div class="col-md-3">
                                                                                <label><b>Pengeluaran Kayu Kumai
                                                                                        (m³):</b></label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #7ee48c6b; border-color: #6df173"
                                                                                    value="{{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_besar_pengeluaran_kayu_daripada_jentera,2) ?? 0 }}"
                                                                                    readonly />
                                                                            </div>
                                                                            <div class="col-md-2">

                                                                            </div>
                                                                            <div class="col-md-2">

                                                                            </div>
                                                                            <div class="col-md-4"
                                                                                style="margin-top:2%;">
                                                                                <div class="legend"
                                                                                    style="border:2px solid;">

                                                                                    <b>MR</b>: <i>Moisture Resistant</i>
                                                                                    (tahan lembap) <br>
                                                                                    <b>WBP</b>: <i>Weather and Boil
                                                                                        Proof</i> (tahan rebus dan
                                                                                    cuaca) <br>

                                                                                </div>
                                                                            </div>

                                                                        </div>
                                                                        <table>
                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;background-color: #7ee48c6b;"
                                                                                    class="col-md-12">Jenis Kayu
                                                                                    Kumai</th>
                                                                                <th style="text-align:center;background-color: #7ee48c6b;"
                                                                                    class="col-md-12">Pengeluaran
                                                                                    Kayu Kumai (m³) </th>
                                                                            </tr>

                                                                            @foreach ($jenis_kumai as $key => $data)
                                                                                <tr rowspan="2" style="height:50px;">
                                                                                    <td style=""
                                                                                        class="col-md-12">
                                                                                        {{ $data->keterangan }}
                                                                                        @if ($data->keterangan == 'E. Lain-lain Profil Kumai (Other Moulding Profiles) (Nyatakan)')
                                                                                            <br>
                                                                                            <input type="text"
                                                                                                style="margin:10px"
                                                                                                size="100"
                                                                                                wire:model='catatan.{{ $key }}'>
                                                                                        @elseif($data->keterangan == 'Lain-lain (Nyatakan)')
                                                                                            <br>
                                                                                            <input type="text"
                                                                                                style="margin:10px"
                                                                                                size="100"
                                                                                                wire:model='catatan.{{ $key }}'>
                                                                                        @elseif($data->keterangan == 'A. Komponen Pintu (Door Components)')
                                                                                            <br><br>
                                                                                            <p
                                                                                                style="padding-left:5%;font-size:12px">
                                                                                                1. Penghadang Pintu
                                                                                                (Door Stops)
                                                                                            </p>
                                                                                            <p
                                                                                                style="padding-left:5%;font-size:12px">
                                                                                                2. Selongsong (Casings)
                                                                                            </p>
                                                                                            <p
                                                                                                style="padding-left:5%;font-size:12px">
                                                                                                3. Jenang Pintu (Door
                                                                                                Jambs) </p>
                                                                                            <p
                                                                                                style="padding-left:10%;font-size:12px">
                                                                                                (i) Jenang Rata (Flat
                                                                                                Jambs)</p>
                                                                                            <p
                                                                                                style="padding-left:10%;font-size:12px">
                                                                                                (ii) Jenang Pecah (Split
                                                                                                Jambs)</p>
                                                                                            <p
                                                                                                style="padding-left:10%;font-size:12px">
                                                                                                (iii) Jenang Rebat
                                                                                                (Rebated Jambs)</p>
                                                                                            <p
                                                                                                style="padding-left:5%;font-size:12px">
                                                                                                4. Rel Pintu (Door
                                                                                                Rails) </p>
                                                                                            <p
                                                                                                style="padding-left:5%;font-size:12px">
                                                                                                5. Panel Pintu (Door
                                                                                                Stiles) </p>
                                                                                            <p
                                                                                                style="padding-left:5%;font-size:12px">
                                                                                                6. Hujung Pintu (Door
                                                                                                Lippings) </p>
                                                                                            <p
                                                                                                style="padding-left:5%;font-size:12px">
                                                                                                7. Bingkai Pintu (Door
                                                                                                Frames) </p>
                                                                                            <p
                                                                                                style="padding-left:5%;font-size:12px">
                                                                                                8. Tingkap & Komponen
                                                                                                Skrin (Lourve & Screen
                                                                                                Components) </p>
                                                                                        @endif
                                                                                    </td>
                                                                                    @if ($data->keterangan == 'A. Komponen Pintu (Door Components)')
                                                                                        <td
                                                                                            style="text-align:center;padding-bottom: 23%;">
                                                                                            <input style=""
                                                                                                class="text-right"
                                                                                                type="text"
                                                                                                size="50"
                                                                                                wire:model='pengeluaran_kayu.{{ $key }}'
                                                                                                wire:change='calcTotalJumlahPengeluaranKayu()'
                                                                                                onkeypress="return isNumberKey(event)">
                                                                                        </td>
                                                                                    @else
                                                                                        <td style="text-align:center;">
                                                                                            <input style=""
                                                                                                class="text-right"
                                                                                                type="text"
                                                                                                size="50"
                                                                                                wire:model='pengeluaran_kayu.{{ $key }}'
                                                                                                wire:change='calcTotalJumlahPengeluaranKayu()'
                                                                                                onkeypress="return isNumberKey(event)">
                                                                                        </td>
                                                                                    @endif
                                                                                </tr>
                                                                            @endforeach

                                                                            <tr style="height:50px;">
                                                                                <th style="background-color: #7ee48c6b;"
                                                                                    class="col-md-12">Jumlah</th>
                                                                                <td style="text-align:center;">
                                                                                    <input readonly
                                                                                        style="background-color: #7ee48c6b;"
                                                                                        class="text-right"
                                                                                        type="text" size="50"
                                                                                        wire:model='total_jumlah_pengeluaran'>
                                                                                </td>
                                                                            </tr>
                                                                        </table>
                                                                        <br>

                                                                        <div class="row">
                                                                            <div class="col-md-3"></div>
                                                                            <div class="col-md-6"
                                                                                style="border:1px solid;text-align:center">
                                                                                <b style="color:red">Jumlah Pengeluaran Kayu Kumai Mestilah Sama Dengan Jumlah Pengeluaran Di Borang 5C
                                                                                    ({{ number_format($kemasukan_bahan_calc_lain_lain->jumlah_besar_pengeluaran_kayu_daripada_jentera,2) }})
                                                                                </b>
                                                                            </div>
                                                                        </div>
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

                                                                <div class="row form-group m-b-0">

                                                                    <div class="text-left col-5">

                                                                    </div>

                                                                    <div class="text-right col-7">
                                                                        <button type="button"
                                                                            wire:loading.attr="disabled"
                                                                            class="btn btn-primary" alt="default"
                                                                            data-toggle="modal"
                                                                            data-target="#sebelumnya_borang_a"
                                                                            class="model_img img-fluid">
                                                                            Kembali</button>
                                                                        @if ($form_c_data->status == 'Tiada Pengeluaran')
                                                                            <button type="button"
                                                                                wire:loading.attr="disabled"
                                                                                class="btn btn-primary" alt="default"
                                                                                data-toggle="modal"
                                                                                data-target="#tiada_pengeluaran"
                                                                                class="model_img img-fluid">
                                                                                Tiada Pengeluaran</button>
                                                                        @endif
                                                                        @if ($form_c_data->status == 'Sedang Diproses')
                                                                            @if ($errors->isEmpty())
                                                                                <button type="button"
                                                                                    wire:loading.attr="disabled"
                                                                                    class="btn btn-primary"
                                                                                    alt="default" data-toggle="modal"
                                                                                    data-target="#confirmation_borang_a"
                                                                                    class="model_img img-fluid">
                                                                                    HANTAR</button>
                                                                            @else
                                                                                <button type="submit"
                                                                                    class="btn btn-primary"
                                                                                    disabled>RALAT</button>
                                                                                {{-- <button type="submit" class="btn btn-primary" >Simpan</button> --}}
                                                                            @endif
                                                                        @endif
                                                                    </div>
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
                                                                                    class="fas fa-exclamation-triangle"></i>PENGESAHAN
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                            <span class="text-center"><b>Adakah anda
                                                                                    pasti ingin menghantar borang
                                                                                    ini?</b></span>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-danger"
                                                                                wire:loading.attr="disabled"
                                                                                data-dismiss="modal">TIDAK</button>
                                                                            <button type="submit"
                                                                                wire:loading.attr="disabled"
                                                                                class="btn btn-success">
                                                                                <div wire:loading wire:target="store">
                                                                                    <div
                                                                                        class="la-ball-pulse-sync la-sm">
                                                                                        <div></div>
                                                                                        <div></div>
                                                                                        <div></div>
                                                                                    </div>
                                                                                </div>
                                                                                <div wire:loading.remove
                                                                                    wire:target="store">YA</div>
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
                                                                        <div class="modal-header"
                                                                            style="background-color:#f3ce8f  !important">
                                                                            <h5 class="modal-title "
                                                                                id="exampleModalLongTitle"><i
                                                                                    style="color:rgb(255, 255, 0)"
                                                                                    class="fas fa-exclamation-triangle"></i>PENGESAHAN
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                            <span class="text-center"><b>Adakah anda
                                                                                    pasti untuk ke
                                                                                    paparan senarai Borang
                                                                                    5D?</b></span>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-danger"
                                                                                wire:loading.attr="disabled"
                                                                                data-dismiss="modal">TIDAK</button>
                                                                            <a type="button"
                                                                                href="{{ route('user.shuttle-5-senaraiD', date('Y')) }}"
                                                                                wire:loading.attr="disabled"
                                                                                class="btn btn-success">YA</a>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <div class="modal fade" id="tiada_pengeluaran"
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
                                                                                    class="fas fa-exclamation-triangle"></i>PENGESAHAN
                                                                            </h5>
                                                                            <button type="button" class="close"
                                                                                data-dismiss="modal"
                                                                                aria-label="Close">
                                                                                <span aria-hidden="true">&times;</span>
                                                                            </button>
                                                                        </div>
                                                                        <div class="modal-body">

                                                                            <span class="text-center"><b>Adakah anda
                                                                                    pasti kilang
                                                                                    anda tiada pengeluaran?</b></span>

                                                                        </div>
                                                                        <div class="modal-footer">
                                                                            <button type="button"
                                                                                class="btn btn-danger"
                                                                                data-dismiss="modal">TIDAK</button>
                                                                            <button type="button"
                                                                                wire:click="tiadaPengeluaran"
                                                                                wire:loading.attr="disabled"
                                                                                class="btn btn-success">YA</button>
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
                </div>

            </div>

        </div>

    </div>
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
