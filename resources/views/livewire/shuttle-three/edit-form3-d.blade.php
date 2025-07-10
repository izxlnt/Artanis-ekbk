<div wire:init='loadData'>
    <div>
        <div>
            <div>

                <div class="container-fluid">


                    <div class="row">

                        <div class="col-md-12">


                            <div class="rounded-lg card" style="border-color: #000000 !important;">
                                <div class="card-header"
                                    style="text-align:center; background-color: #6df173 !important; font-size: 130%; font-weight: bold;">
                                    BORANG 3D - PENYATA PENJUALAN KAYU GERGAJI <br>DALAM PASARAN TEMPATAN DAN EKSPORT
                                </div>
                                <div class="card-body">


                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <form wire:submit.prevent='update'>
                                            <div class="tab-pane active" id="hotel" role="tabpanel"
                                                aria-labelledby="hotel-tab">
                                                <br>
                                                <div class="">
                                                    <table class="table table-striped table-bordered" id=""
                                                        style="width: 100%;">
                                                        <div class="row">
                                                            <div class="col-12">
                                                                <div class="card">

                                                                    <form class="form-horizontal">
                                                                        <div class="card-body">

                                                                            <div class="row" style="justify-content: center;margin-bottom:-0%;">
                                                                                <div class="col-md-2">
                                                                                    <label>Tahun:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173"
                                                                                        value="{{ $formd_id->tahun }}"
                                                                                        readonly />
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <label>Bulan:</label>
                                                                                    @if($formd_id->bulan <= '1')

                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="Januari" readonly />
                                                                                    @elseif($formd_id->bulan  <= '2')

                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="Februari" readonly />
                                                                                    @elseif($formd_id->bulan  <= '3')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="Mac" readonly />
                                                                                    @elseif($formd_id->bulan  <= '4')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="April" readonly />
                                                                                    @elseif($formd_id->bulan  <= '5')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="Mei" readonly />
                                                                                    @elseif($formd_id->bulan  <= '6')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="Jun" readonly />
                                                                                    @elseif($formd_id->bulan  <= '7')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="Julai" readonly />
                                                                                    @elseif($formd_id->bulan  <= '8')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="Ogos" readonly />
                                                                                    @elseif($formd_id->bulan  <= '9')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="September" readonly />
                                                                                    @elseif($formd_id->bulan  <= '10')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="Oktober" readonly />
                                                                                    @elseif($formd_id->bulan  <= '11')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="November" readonly />
                                                                                    @elseif($formd_id->bulan  <= '12')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173;"
                                                                                        value="Disember" readonly />
                                                                                    @endif
                                                                                </div>




                                                                                <div class="col-md-3">
                                                                                    <label>Nama Kilang:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173"
                                                                                        value="{{ $formd_id->nama_kilang }}"
                                                                                        readonly />

                                                                                </div>
                                                                                <div class="col-md-2">

                                                                                    <label>No. Pendaftaran Syarikat
                                                                                        (SSM):</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173"
                                                                                        value="{{ $formd_id->no_ssm }}"
                                                                                        readonly />

                                                                                </div>


                                                                                <div class="col-md-2">
                                                                                    <label>No. Lesen:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #7ee48c6b;  border-color: #6df173"
                                                                                        value="{{ $formd_id->no_lesen }}"
                                                                                        readonly />


                                                                                </div>
                                                                            </div>

                                                                            <table>
                                                                                <tr style="height:50px;">
                                                                                    <td style="" class="col-md-12">
                                                                                        Jumlah kayu gergaji yang
                                                                                        dieksport ( m³ )</td>
                                                                                    <td style="text-align:center;">
                                                                                        <input style="" type="text"
                                                                                        oninput="validate(this)"
                                                                                            size="5"
                                                                                            wire:model='total_export' onkeypress="return isNumberKey(event)">
                                                                                    </td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <td style="" class="col-md-12">
                                                                                        Jumlah kayu gergaji yang dijual
                                                                                        dalam pasaran tempatan ( m³ )</td>
                                                                                    <td style="text-align:center;">
                                                                                        <input readonly
                                                                                        oninput="validate(this)"
                                                                                            style="background-color: #7ee48c6b;"
                                                                                            type="text" size="5"
                                                                                            wire:model='jumlah_pasaran_tempatan'>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:center;background-color: #7ee48c6b;"
                                                                                        class="col-md-12"
                                                                                        colspan="2">
                                                                                        Penjualan Kayu Gergaji Dalam
                                                                                        Pasaran Tempatan</th>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:center;background-color: #7ee48c6b;width:50%"
                                                                                        class="col-md-12">Jenis
                                                                                        Pembeli
                                                                                        Tempatan</th>
                                                                                    <th style="text-align:center;background-color: #7ee48c6b;"
                                                                                        class="col-md-12">Jumlah
                                                                                        Jualan
                                                                                        ( m³ )
                                                                                </th>
                                                                                </tr>

                                                                                @foreach ($jenis_pembeli as $key => $data)
                                                                                    <tr style="height:50px;">
                                                                                        <td style=""
                                                                                            class="col-md-12">
                                                                                            {{ $data->keterangan }}
                                                                                            @if ($data->keterangan == 'Sektor awam (Nyatakan)')
                                                                                                <br>
                                                                                                <input type="text"
                                                                                                    style="margin:10px"
                                                                                                    size="100"
                                                                                                    wire:model='catatan.{{ $key }}' >
                                                                                            @endif
                                                                                            @if($data->keterangan == 'Lain-lain (Nyatakan)')
                                                                                                <br>
                                                                                                <input type="text"
                                                                                                    style="margin:10px"
                                                                                                    size="100"
                                                                                                    wire:model='catatan.{{ $key }}'>

                                                                                            @endif
                                                                                    </td>
                                                                                        <td style="text-align:center;">
                                                                                            <input style="text-align:right" type="text"
                                                                                                size="5"
                                                                                                oninput="validate(this)"
                                                                                                wire:model='jumlah_jualan.{{ $key }}'
                                                                                                wire:change='calcTotalJumlahJualan()' onkeypress="return isNumberKey(event)">
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach


                                                                                <tr style="height:50px;">
                                                                                    <th style="background-color: #7ee48c6b;"
                                                                                        class="col-md-12">Jumlah
                                                                                    </th>
                                                                                    <td style="text-align:center;">
                                                                                        <input
                                                                                            style="background-color: #7ee48c6b;text-align:right"
                                                                                            type="text" size="5"
                                                                                            wire:model='total_jumlah_jualan'>
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

                                                                    <a href="{{  route('user.shuttle-3-senaraiD', date('Y')) }}"
                                                                        class="btn btn-primary">Kembali</a>

                                                                    <button type="button" class="btn btn-primary"
                                                                        alt="default" data-toggle="modal" data-target="#confirmation_borang_a">
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





</div>

</div>

</div>

</div>
