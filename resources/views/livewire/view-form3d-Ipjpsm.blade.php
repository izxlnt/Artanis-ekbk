
@extends('layouts.layout-ipjpsm-nicepage')

@section('content')

<div>
    <div>
        <div>
            <div>

                <div class="container-fluid">

                    <div class="row">

                        <div class="col-md-12">

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

                            <div class="rounded-lg card" style="border-color: #000000 !important;">
                                <div class="card-header"
                                    style="text-align:center; background-color: #6df173 !important; font-size: 130%; font-weight: bold;">
                                    BORANG 3D - PENYATA PENJUALAN KAYU GERGAJI DALAM PASARAN TEMPATAN DAN EKSPORT
                                </div>
                                <div class="card-body">


                                    <!-- Tab panes -->
                                    <div class="tab-content">
                                        <form action="{{ route('update_status_form3D_ipjpsm',$id) }}" method="post">
                                            @csrf
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

                                                                            <div class="row" style="justify-content: center;margin-bottom:-0%;"">
                                                                                <div class="col-md-2">
                                                                                    <label>Tahun:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="{{ $formd->tahun }}" readonly />
                                                                                </div>
                                                                                <div class="col-md-2">
                                                                                    <label>Bulan:</label>
                                                                                    @if($formd->bulan <= '1')

                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="Januari" readonly />
                                                                                    @elseif($formd->bulan  <= '2')

                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="Februari" readonly />
                                                                                    @elseif($formd->bulan  <= '3')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="Mac" readonly />
                                                                                    @elseif($formd->bulan  <= '4')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="April" readonly />
                                                                                    @elseif($formd->bulan  <= '5')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="Mei" readonly />
                                                                                    @elseif($formd->bulan  <= '6')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="Jun" readonly />
                                                                                    @elseif($formd->bulan  <= '7')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="Julai" readonly />
                                                                                    @elseif($formd->bulan  <= '8')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="Ogos" readonly />
                                                                                    @elseif($formd->bulan  <= '9')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="September" readonly />
                                                                                    @elseif($formd->bulan  <= '10')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="Oktober" readonly />
                                                                                    @elseif($formd->bulan  <= '11')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="November" readonly />
                                                                                    @elseif($formd->bulan  <= '12')


                                                                                    <input type="text" class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="Disember" readonly />
                                                                                    @endif
                                                                                </div>

                                                                                <div class="col-md-3">
                                                                                    <label>Nama Kilang:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="{{ $formd->nama_kilang }}" readonly />

                                                                                </div>
                                                                                <div class="col-md-2">

                                                                                    <label>No. Pendaftaran Syarikat (SSM):</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="{{ $formd->no_ssm }}" readonly />

                                                                                </div>


                                                                                <div class="col-md-2">
                                                                                    <label>No. Lesen:</label>
                                                                                    <input type="text"
                                                                                        class="form-control"
                                                                                        style="background-color: #7ee48c6b; border-color:rgb(45, 243, 6)"
                                                                                        value="{{ $formd->no_lesen }}" readonly />


                                                                                </div>
                                                                            </div>

                                                                            <table>
                                                                                <tr style="height:50px;">
                                                                                    <td style="" class="col-md-12">
                                                                                        Jumlah kayu gergaji yang
                                                                                        dieksport (m³)</td>
                                                                                    <td style="text-align:center;">
                                                                                        <input readonly class="text-right" style="background-color: #7ee48c6b;" type="text"
                                                                                        size="10" wire:model='total_export' value="{{ number_format($formd->total_export ?? 0,2,'.','')}} ">

                                                                                        <input class="text-right" style="" type="text" oninput="validate(this)" onkeypress="return isNumberKey(event)" size="10" name="total_export_cleaning" >
                                                                                    </td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <td style="" class="col-md-12">
                                                                                        Jumlah kayu gergaji yang dijual
                                                                                        dalam pasaran tempatan (m³)</td>
                                                                                    <td style="text-align:center;">
                                                                                        <input style="background-color: #7ee48c6b;" class="text-right" type="text" size="10" value="{{ number_format($formd->jumlah_pasaran_tempatan,2,'.','')}}" readonly>
                                                                                        <input type="text" style="background-color: #7ee48c6b;" class="text-right" size="10" oninput="validate(this)" onkeypress="return isNumberKey(event)" name="jumlah_pasaran_tempatan_cleaning" id="jumlah_pasaran_tempatan_cleaning" readonly>
                                                                                    </td>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:center;background-color: #7ee48c6b;"
                                                                                        class="col-md-12" colspan="2">
                                                                                        Penjualan Kayu Gergaji Dalam
                                                                                        Pasaran Tempatan</th>
                                                                                </tr>

                                                                                <tr style="height:50px;">
                                                                                    <th style="text-align:center;background-color: #7ee48c6b;width:50%"
                                                                                        class="col-md-12">Jenis Pembeli
                                                                                        Tempatan</th>
                                                                                        <th style="text-align:center;background-color: #7ee48c6b;"
                                                                                        class="col-md-12">Jumlah
                                                                                        Jualan ( m³ )
                                                                                    </th>
                                                                                </tr>

                                                                                @foreach ($jenis_pembeli as $key => $data)


                                                                                    <tr style="height:50px;">
                                                                                        <td style="" class="col-md-12" >
                                                                                            {{ $data->keterangan }}
                                                                                            @if($data->keterangan == 'Sektor awam (Nyatakan)')
                                                                                            <br>
                                                                                            <span type="text" style="margin:10px"  size="100" wire:model='catatan.{{ $key }}'> {{ $form_d[$key]->catatan}} </span>

                                                                                            @elseif($data->keterangan == 'Lain-lain (Nyatakan)')
                                                                                            <br>
                                                                                            <span type="text" style="margin:10px"  size="100" wire:model='catatan.{{ $key }}'> {{ $form_d[$key]->catatan}} </span>

                                                                                            @endif
                                                                                        </td>
                                                                                        <td style="text-align:center;">
                                                                                            <input style="background-color:#7ee48c6b;text-align:right" type="text" size="10"  value="{{ number_format($form_d[$key]->jumlah_jualan,2,'.','')}}" readonly>
                                                                                            <input  type="text" oninput="validate(this);calcTotalJumlahJualan()" onkeypress="return isNumberKey(event)" size="10" style="text-align: right" name="jumlah_jualan_cleaning[]" id="jumlah_jualan_cleaning.{{ $key }}"  >
                                                                                        </td>
                                                                                    </tr>
                                                                                @endforeach


                                                                                <tr style="height:50px;">
                                                                                    <th style="background-color: #7ee48c6b;"
                                                                                        class="col-md-12">Jumlah</th>
                                                                                    <td style="text-align:center;background-color: #7ee48c6b;">
                                                                                        <input type="text" style="background-color:#7ee48c6b; text-align:right" size="10" wire:model='total_jumlah_jualan' value="{{ number_format($form_d[0]->total_jumlah_jualan,2,'.','')}} " readonly>
                                                                                        <input type="text"  size="10" style="background-color:#7ee48c6b;text-align:right" name="total_jumlah_jualan_cleaning" id="total_jumlah_jualan_cleaning" readonly>
                                                                                    </td>  </span>
                                                                                </tr>
                                                                            </table>
                                                                            <br>

                                                                        </div>
                                                                </div>
                                                            </div>

                                                            <hr>

                                                            <br>


                                                            <div class="row" style="text-align:center">
                                                                <div class="col-md-12">
                                                                    <input type="text" name="status" value="Lulus" hidden>

                                                                    <a href="{{ route('shuttle-3-listD', date('Y')) }}"
                                                                    class="btn btn-primary">Kembali</a>

                                                                    <button type="button" class="btn btn-primary"
                                                                    alt="default" data-toggle="modal" data-target="#confirmation_borang_a">
                                                                    DIPERAKU</button>

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
                                                                        <span class="text-center"><b>Adakah anda pasti ingin memperaku borang ini?</b></span>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-danger"
                                                                            data-dismiss="modal">Batal</button>
                                                                        <button type="submit"
                                                                            class="btn btn-success">PERAKU</button>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        </form>
                                                        <br>

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

<script type="text/javascript">
    function calcTotalJumlahJualan(){
        var length = {{ $form_d_count }};
        var total = 0;
        for (let index = 0; index < length; index++) {
            var jualan = parseFloat(document.getElementById("jumlah_jualan_cleaning." + index).value) || 0;
            console.log(jualan);
            total += jualan;
        }

        document.getElementById('total_jumlah_jualan_cleaning').value = total.toFixed(2);
        document.getElementById('jumlah_pasaran_tempatan_cleaning').value = total.toFixed(2);
    }

</script>
<script>
    var validate = function(e) {
    var t = e.value;
    e.value = (t.indexOf(".") >= 0) ? (t.substr(0, t.indexOf(".")) + t.substr(t.indexOf("."), 3)) : t;
    }
</script>

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

<style >

    table, th, td {
      border: 1px solid black;
    }
    </style>





</div>

</div>

</div>

</div>


@endsection

