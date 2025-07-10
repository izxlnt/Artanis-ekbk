<div wire:init='loadData'>
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
                                    BORANG 5E - PENYATA PENJUALAN KAYU KUMAI DALAM PASARAN TEMPATAN DAN EKSPORT
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

                                                                <form wire:submit.prevent='store'>
                                                                    <div class="card-body">

                                                                        <div class="row"
                                                                            style="justify-content: center;margin-bottom:-2%;">
                                                                            <div class="col-md-2">
                                                                                <label><b>Tahun:</b></label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #9ac4f7"
                                                                                    value="{{ $kilang_info->tahun }}"
                                                                                    readonly />
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <label><b>Bulan:</b></label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #9ac4f7 ;"
                                                                                    value="{{ $bulan }}"
                                                                                    readonly />

                                                                            </div>
                                                                            <div class="col-md-3">
                                                                                <label><b>Nama Kilang:</b></label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #9ac4f7 ;"
                                                                                    value="{{ $kilang_info->nama_kilang }}"
                                                                                    readonly />
                                                                            </div>
                                                                            {{-- <div class="col-md-2"></div> --}}
                                                                            <div class="col-md-2">
                                                                                <label><b>No. Pendaftaran Syarikat
                                                                                        (SSM):</b></label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #9ac4f7 ;"
                                                                                    value="{{ $kilang_info->no_ssm }}"
                                                                                    readonly />
                                                                            </div>
                                                                            <div class="col-md-2">
                                                                                <label><b>No. Lesen:</b></label>
                                                                                <input type="text"
                                                                                    class="form-control"
                                                                                    style="background-color: #9ac4f7 ;"
                                                                                    value="{{ $kilang_info->no_lesen }}"
                                                                                    readonly />
                                                                            </div>


                                                                        </div>

                                                                        <table>
                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;background-color: #9ac4f7; "
                                                                                    class="col-md-8" colspan="2">
                                                                                    Jenis Pasaran </th>
                                                                                <th style="text-align:center;background-color: #9ac4f7; "
                                                                                    class="col-md-4">Isipadu
                                                                                    (&#x33A5;) </th>
                                                                            </tr>

                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;"
                                                                                    class="">1.</th>
                                                                                <td style="" class="">
                                                                                    Jumlah kayu kumai yang dijual dalam
                                                                                    pasaran tempatan</td>
                                                                                <td
                                                                                    style="text-align:center;padding: 10px">
                                                                                    <input
                                                                                        wire:model='jumlah_jualan_pasaran_tempatan'
                                                                                        style="text-align:right;"
                                                                                        oninput="validate(this)"
                                                                                        type="text" size="30"></td>
                                                                            </tr>

                                                                            <tr style="height:50px;">
                                                                                <th style="text-align:center;"
                                                                                    class="">2.</th>
                                                                                <td style="" class="">
                                                                                    Jumlah kayu kumai yang dieksport
                                                                                </td>
                                                                                <td
                                                                                    style="text-align:center;padding: 10px">
                                                                                    <input
                                                                                        wire:model='jumlah_jualan_eksport'
                                                                                        style="text-align:right;"
                                                                                        oninput="validate(this)"
                                                                                        type="text" size="30"></td>
                                                                            </tr>
                                                                        </table>
                                                                        <br>

                                                                    </div>
                                                            </div>



                                                        </div>

                                                        <hr>
                                                        <div class="card-body">
                                                            <div class="text-right form-group m-b-0">
                                                                {{-- <button type="submit" class="btn btn-primary">Tiada Pengeluaran</button> --}}
                                                                <a href="{{ route('user.shuttle-5-senaraiE', date('Y')) }}"
                                                                    class="btn btn-primary">Kembali</a>
                                                                <button type="button" class="btn btn-primary"
                                                                    data-toggle="modal"
                                                                    data-target="#confirmation_borang_a">HANTAR</button>
                                                            </div>
                                                        </div>
                                                        <div class="modal fade" id="confirmation_borang_a"
                                                            tabindex="-1" role="dialog"
                                                            aria-labelledby="confirmation_borang_aTitle"
                                                            aria-hidden="true">
                                                            <div class="modal-dialog modal-dialog-centered"
                                                                role="document">
                                                                <div class="modal-content">
                                                                    <div class="modal-header bg-info">
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
                                                                        <span class="text-center"><b>Adakah anda
                                                                                pasti ingin menghantar borang
                                                                                ini?</b></span>
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

                                    @if($ulasan_phd)

                                    <div class="row" style="text-align:center">
                                        <div class="col-md-12">
                                            <label>Ulasan PHD</label><br>

                                            @if($ulasan_phd->ulasan == NULL)

                                            <textarea name="ulasan_phd" cols="100%" rows="5" readonly disabled>Tiada Ulasan</textarea>
                                            @else
                                            <textarea name="ulasan_phd" cols="100%" rows="5" readonly disabled>{{ $ulasan_phd->ulasan }}</textarea>

                                            @endif


                                        </div>
                                    </div>
                                    @endif
                                                    </div>

                                            </div>
                                        </div>

                                        </table>
                                        {{-- @if($ulasan_phd)
                                    <div class="row" style="text-align:center">
                                        <div class="col-md-12">
                                                    <textarea name="ulasan_phd" value="" cols="30" rows="10" readonly disabled>{{ $ulasan_phd->ulasan }}</textarea>
                                        </div>
                                    </div>
                                    @endif --}}



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

                        </div>

                    </div>

                </div>

            </div>
